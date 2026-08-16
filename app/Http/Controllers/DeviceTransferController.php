<?php

namespace App\Http\Controllers;

use App\Models\Clearance;
use App\Models\Device;
use App\Models\DeviceAndSimReceive;
use App\Models\Receive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeviceTransferController extends Controller
{
    /**
     * Show the picker form (releasing employee, receiving employee, devices).
     */
    public function create()
    {
        return view('device-transfer.create');
    }

    /**
     * Show both pending documents (clearance + receive) with a print step and
     * a signature upload for each, mirroring the receive/clearance finish pages
     * used elsewhere in the app.
     */
    public function finish(Clearance $clearance, Receive $receive)
    {
        $clearance->load(['employee', 'devices']);
        $receive->load('employee');

        $deviceRecords = DeviceAndSimReceive::where('receive_id', $receive->id)
            ->whereNotNull('device_id')
            ->with('device')
            ->get();

        return view('device-transfer.finish', compact('clearance', 'receive', 'deviceRecords'));
    }

    /**
     * Sign the releasing employee's clearance. Deliberately does not touch the
     * device's status or ownership - it stays reserved (pending-cancel) until
     * the receive side is completed, so it's never briefly "available" and
     * grabbable by an unrelated flow mid-transfer.
     */
    public function completeClearance(Request $request, Clearance $clearance)
    {
        $request->validate([
            'clearing_signature' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $image = $request->file('clearing_signature');
        $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('X-Files/Dash/imgs/clearance'), $imageName);

        $clearance->update([
            'clear_image' => $imageName,
            'status' => 'finished',
        ]);

        return redirect()->back()->with('success', 'Clearance signed.');
    }

    /**
     * Sign the receiving employee's receive. This is the step that actually
     * moves the device(s) to the new owner.
     */
    public function completeReceive(Request $request, Receive $receive)
    {
        $request->validate([
            'receiving_signature' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        return DB::transaction(function () use ($request, $receive) {
            $image = $request->file('receiving_signature');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('X-Files/Dash/imgs/receives'), $imageName);

            $receive->update([
                'receive_image' => $imageName,
                'status' => 'received',
            ]);

            $deviceIds = DeviceAndSimReceive::where('receive_id', $receive->id)
                ->whereNotNull('device_id')
                ->pluck('device_id');

            Device::whereIn('id', $deviceIds)->update([
                'status' => 'taken',
                'employee_id' => $receive->employee_id,
                'client_id' => null,
                'consultant_id' => null,
                'project_id' => null,
                'department_id' => null,
                'receive_id' => $receive->id,
            ]);

            return redirect()->route('device.index')
                ->with('success', 'Transfer completed - device(s) now assigned to the new employee.');
        });
    }
}
