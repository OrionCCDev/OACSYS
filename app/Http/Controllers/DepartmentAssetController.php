<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Receive;
use App\Models\SimCard;
use App\Models\Clearance;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DeviceAndSimReceive;
use App\Models\DeviceAndSimClearance;

class DepartmentAssetController extends Controller
{
    /**
     * Display all departments with their assets
     */
    public function index()
    {
        $departments = Department::with(['devices', 'simCards', 'manager'])->paginate(10);

        return view('department-assets.index', compact('departments'));
    }

    /**
     * Show a specific department's assets
     */
    public function show($id)
    {
        $department = Department::with(['devices', 'simCards', 'manager', 'receives', 'clearances'])
            ->findOrFail($id);

        $assetsCount = [
            'devices' => $department->devices()->count(),
            'sim_cards' => $department->simCards()->count(),
            'total' => $department->devices()->count() + $department->simCards()->count(),
        ];

        return view('department-assets.show', compact('department', 'assetsCount'));
    }

    /**
     * Show form to receive assets to a department
     */
    public function createReceive($departmentId)
    {
        $department = Department::findOrFail($departmentId);

        if (!$department->manager) {
            return redirect()->route('department-assets.show', $department->id)
                ->with('error', 'This department has no manager assigned. Please assign a department manager before receiving assets.');
        }

        // Get available devices and sim cards (not assigned to anyone or any project/department)
        $availableDevices = Device::where('status', 'available')
            ->whereNull('employee_id')
            ->whereNull('consultant_id')
            ->whereNull('client_id')
            ->whereNull('project_id')
            ->whereNull('department_id')
            ->get();

        $availableSimCards = SimCard::where('status', 'available')
            ->whereNull('employee_id')
            ->whereNull('consultant_id')
            ->whereNull('client_employee_id')
            ->whereNull('project_id')
            ->whereNull('department_id')
            ->get();

        return view('department-assets.receive.create', compact('department', 'availableDevices', 'availableSimCards'));
    }

    /**
     * Store receive for department assets
     */
    public function storeReceive(Request $request, $departmentId)
    {
        $request->validate([
            'devices' => 'nullable|array',
            'devices.*' => 'exists:devices,id',
            'sim_cards' => 'nullable|array',
            'sim_cards.*' => 'exists:sim_cards,id',
            'device_notes' => 'nullable|array',
            'sim_notes' => 'nullable|array',
        ]);

        if (empty($request->devices) && empty($request->sim_cards)) {
            return redirect()->back()->with('error', 'Please select at least one device or SIM card to receive.');
        }

        if (!Department::findOrFail($departmentId)->manager) {
            return redirect()->route('department-assets.show', $departmentId)
                ->with('error', 'This department has no manager assigned. Please assign a department manager before receiving assets.');
        }

        return DB::transaction(function () use ($request, $departmentId) {
            $skipped = [];

            $receive = Receive::create([
                'code' => 'RCV-' . strtoupper(Str::random(10)),
                'department_id' => $departmentId,
                'status' => 'pending',
            ]);

            if (!empty($request->devices)) {
                foreach ($request->devices as $index => $deviceId) {
                    $device = Device::findOrFail($deviceId);
                    if (!$this->deviceIsAvailable($device)) {
                        $skipped[] = $device->device_code . ' (no longer available)';
                        continue;
                    }
                    $device->update([
                        'status' => 'pending-receiving',
                        'department_id' => $departmentId,
                    ]);

                    DeviceAndSimReceive::create([
                        'receive_id' => $receive->id,
                        'device_id' => $deviceId,
                        'notes' => $request->device_notes[$index] ?? null,
                    ]);
                }
            }

            if (!empty($request->sim_cards)) {
                foreach ($request->sim_cards as $index => $simId) {
                    $simCard = SimCard::findOrFail($simId);
                    if (!$this->simCardIsAvailable($simCard)) {
                        $skipped[] = $simCard->sim_number . ' (no longer available)';
                        continue;
                    }
                    $simCard->update([
                        'status' => 'pending-receive',
                        'department_id' => $departmentId,
                    ]);

                    DeviceAndSimReceive::create([
                        'receive_id' => $receive->id,
                        'sim_card_id' => $simId,
                        'notes' => $request->sim_notes[$index] ?? null,
                    ]);
                }
            }

            $message = 'Assets added to receive. Please upload signature to complete.';
            if ($skipped) {
                $message .= ' Skipped (already assigned elsewhere): ' . implode(', ', $skipped) . '.';
            }

            return redirect()->route('department-assets.receive.finish', $receive->id)
                ->with('success', $message);
        });
    }

    /**
     * Show page to finish receive (upload signature)
     */
    public function finishReceive($receiveId)
    {
        $receive = Receive::with(['department'])->findOrFail($receiveId);

        $deviceRecords = DeviceAndSimReceive::where('receive_id', $receiveId)
            ->whereNotNull('device_id')
            ->with('device')
            ->get();

        $simRecords = DeviceAndSimReceive::where('receive_id', $receiveId)
            ->whereNotNull('sim_card_id')
            ->with('simCard')
            ->get();

        return view('department-assets.receive.finish', compact('receive', 'deviceRecords', 'simRecords'));
    }

    /**
     * Complete the receive process
     */
    public function completeReceive(Request $request, $receiveId)
    {
        $request->validate([
            'receiving_signature' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        return DB::transaction(function () use ($request, $receiveId) {
            $receive = Receive::findOrFail($receiveId);

            if ($request->hasFile('receiving_signature')) {
                $image = $request->file('receiving_signature');
                $imageName = \Illuminate\Support\Str::uuid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('X-Files/Dash/imgs/receives'), $imageName);

                $receive->receive_image = $imageName;
                $receive->status = 'received';
                $receive->save();
            }

            $records = DeviceAndSimReceive::where('receive_id', $receiveId)->get();

            foreach ($records as $record) {
                if ($record->device_id) {
                    Device::where('id', $record->device_id)->update([
                        'status' => 'taken',
                    ]);
                }

                if ($record->sim_card_id) {
                    SimCard::where('id', $record->sim_card_id)->update([
                        'status' => 'taken',
                    ]);
                }
            }

            return redirect()->route('department-assets.show', $receive->department_id)
                ->with('success', 'Assets received successfully!');
        });
    }

    /**
     * Show form to create clearance for department assets
     */
    public function createClearance($departmentId)
    {
        $department = Department::findOrFail($departmentId);

        if (!$department->manager) {
            return redirect()->route('department-assets.show', $department->id)
                ->with('error', 'This department has no manager assigned. Please assign a department manager before clearing assets.');
        }

        $departmentDevices = Device::where('department_id', $departmentId)
            ->where('status', 'taken')
            ->get();

        $departmentSimCards = SimCard::where('department_id', $departmentId)
            ->where('status', 'taken')
            ->get();

        return view('department-assets.clearance.create', compact('department', 'departmentDevices', 'departmentSimCards'));
    }

    /**
     * Store clearance for department assets
     */
    public function storeClearance(Request $request, $departmentId)
    {
        $request->validate([
            'devices' => 'nullable|array',
            'devices.*' => 'exists:devices,id',
            'sim_cards' => 'nullable|array',
            'sim_cards.*' => 'exists:sim_cards,id',
            'device_notes' => 'nullable|array',
            'sim_notes' => 'nullable|array',
        ]);

        if (empty($request->devices) && empty($request->sim_cards)) {
            return redirect()->back()->with('error', 'Please select at least one device or SIM card to clear.');
        }

        if (!Department::findOrFail($departmentId)->manager) {
            return redirect()->route('department-assets.show', $departmentId)
                ->with('error', 'This department has no manager assigned. Please assign a department manager before clearing assets.');
        }

        return DB::transaction(function () use ($request, $departmentId) {
            $skipped = [];

            $clearance = Clearance::create([
                'status' => 'pending',
                'department_id' => $departmentId,
            ]);

            if (!empty($request->devices)) {
                foreach ($request->devices as $index => $deviceId) {
                    $device = Device::findOrFail($deviceId);
                    if ((int) $device->department_id !== (int) $departmentId || $device->status !== 'taken') {
                        $skipped[] = $device->device_code . ' (not currently in this department)';
                        continue;
                    }
                    $device->update(['status' => 'pending-cancel']);

                    DeviceAndSimClearance::create([
                        'clearance_id' => $clearance->id,
                        'device_id' => $deviceId,
                        'notes' => $request->device_notes[$index] ?? null,
                    ]);
                }
            }

            if (!empty($request->sim_cards)) {
                foreach ($request->sim_cards as $index => $simId) {
                    $simCard = SimCard::findOrFail($simId);
                    if ((int) $simCard->department_id !== (int) $departmentId || $simCard->status !== 'taken') {
                        $skipped[] = $simCard->sim_number . ' (not currently in this department)';
                        continue;
                    }
                    $simCard->update(['status' => 'pending-cancel']);

                    DeviceAndSimClearance::create([
                        'clearance_id' => $clearance->id,
                        'sim_card_id' => $simId,
                        'notes' => $request->sim_notes[$index] ?? null,
                    ]);
                }
            }

            $message = 'Assets added to clearance. Please upload signature to complete.';
            if ($skipped) {
                $message .= ' Skipped: ' . implode(', ', $skipped) . '.';
            }

            return redirect()->route('department-assets.clearance.finish', $clearance->id)
                ->with('success', $message);
        });
    }

    /**
     * Show page to finish clearance (upload signature)
     */
    public function finishClearance($clearanceId)
    {
        $clearance = Clearance::findOrFail($clearanceId);
        $departmentId = $clearance->department_id;
        $department = Department::findOrFail($departmentId);

        $deviceRecords = DeviceAndSimClearance::where('clearance_id', $clearanceId)
            ->whereNotNull('device_id')
            ->with('device')
            ->get();

        $simRecords = DeviceAndSimClearance::where('clearance_id', $clearanceId)
            ->whereNotNull('sim_card_id')
            ->with('simCard')
            ->get();

        return view('department-assets.clearance.finish', compact('clearance', 'deviceRecords', 'simRecords', 'department'));
    }

    /**
     * Complete the clearance process
     */
    public function completeClearance(Request $request, $clearanceId)
    {
        $request->validate([
            'clearing_signature' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        return DB::transaction(function () use ($request, $clearanceId) {
            $clearance = Clearance::findOrFail($clearanceId);
            $departmentId = $clearance->department_id;

            if ($request->hasFile('clearing_signature')) {
                $image = $request->file('clearing_signature');
                $imageName = \Illuminate\Support\Str::uuid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('X-Files/Dash/imgs/clearance'), $imageName);

                $clearance->clear_image = $imageName;
                $clearance->status = 'finished';
                $clearance->save();
            }

            $deviceRecords = DeviceAndSimClearance::where('clearance_id', $clearanceId)
                ->whereNotNull('device_id')
                ->get();

            foreach ($deviceRecords as $record) {
                Device::where('id', $record->device_id)->update([
                    'status' => 'available',
                    'department_id' => null,
                    'employee_id' => null,
                    'consultant_id' => null,
                    'client_id' => null,
                    'receive_id' => null,
                ]);
            }

            $simRecords = DeviceAndSimClearance::where('clearance_id', $clearanceId)
                ->whereNotNull('sim_card_id')
                ->get();

            foreach ($simRecords as $record) {
                SimCard::where('id', $record->sim_card_id)->update([
                    'status' => 'available',
                    'department_id' => null,
                    'employee_id' => null,
                    'consultant_id' => null,
                    'client_employee_id' => null,
                ]);
            }

            return redirect()->route('department-assets.show', $departmentId)
                ->with('success', 'Assets cleared successfully!');
        });
    }

    /**
     * True only if nothing currently claims this device - no owner FK set, not already
     * spoken for by a project or another department. Mirrors the filter createReceive()
     * uses to build the "available" picklist.
     */
    private function deviceIsAvailable(Device $device): bool
    {
        return $device->status === 'available'
            && $device->employee_id === null
            && $device->client_id === null
            && $device->consultant_id === null
            && $device->project_id === null
            && $device->department_id === null;
    }

    private function simCardIsAvailable(SimCard $simCard): bool
    {
        return $simCard->status === 'available'
            && $simCard->employee_id === null
            && $simCard->consultant_id === null
            && $simCard->client_employee_id === null
            && $simCard->project_id === null
            && $simCard->department_id === null;
    }
}
