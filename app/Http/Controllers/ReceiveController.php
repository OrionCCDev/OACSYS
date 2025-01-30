<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Receive;
use App\Models\SimCard;
use Illuminate\Http\Request;
use App\Models\DeviceAndSimReceive;
use Illuminate\Support\Facades\Storage;

class ReceiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Receive::with(['clientEmployee', 'consultant', 'employee'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        return view('receive.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Device $makeReceiveDeviceId = null)
    {
        return view('receive.create', compact('makeReceiveDeviceId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function cancel($id)
    {
        $device = Device::with(['employee.department', 'consultant', 'clientEmployee', 'project'])->findOrFail($id);
        $device->status = 'pending-cancel';
        $device->save();

        $newClearance = new \App\Models\Clearance();
        $newClearance->device_id = $device->id;
        if ($device->employee_id != null) {
            $newClearance->employee_id = $device->employee_id;
            $hisDevices  = Device::where('employee_id', $device->employee_id)->get();
            $simCards = SimCard::where('employee_id', $device->employee_id)->get();
        } elseif ($device->client_id != null) {
            $newClearance->client_employee_id = $device->client_id;
            $hisDevices = Device::where('client_id', $device->client_id)->get();
            $simCards = SimCard::where('client_employee_id', $device->client_id)->get();
        } elseif ($device->consultant_id != null) {
            $newClearance->consultant_id = $device->consultant_id;
            $hisDevices = Device::where('consultant_id', $device->consultant_id)->get();
            $simCards = SimCard::where('consultant_id', $device->consultant_id)->get();
        }
        $newClearance->save();

        return view('receive.cancel-receiving', compact('device', 'newClearance', 'hisDevices', 'simCards'));
    }

    public function pendingCancel($id)
    {
        $device = Device::with(['employee.department', 'consultant', 'clientEmployee', 'project'])->findOrFail($id);
        $newClearance = \App\Models\Clearance::where('device_id', $device->id)->latest('updated_at')->first();
        if ($device->employee_id != null) {

            $simCards = SimCard::where('employee_id', $device->employee_id)->get();
            $hisDevices  = Device::where('employee_id', $device->employee_id)->get();
        } elseif ($device->client_id != null) {
            $simCards = SimCard::where('client_employee_id', $device->client_employee_id)->get();
            $hisDevices = Device::where('client_id', $device->client_id)->get();
        } elseif ($device->consultant_id != null) {
            $simCards = SimCard::where('consultant_id', $device->consultant_id)->get();
            $hisDevices = Device::where('consultant_id', $device->consultant_id)->get();
        }

        return view('receive.cancel-receiving', compact('device', 'newClearance', 'hisDevices', 'simCards'));
    }

    public function clear($id, $clearId, Request $request)
    {
        $clr = \App\Models\Clearance::findOrFail($clearId);
        $device = Device::with(['employee.department', 'consultant', 'clientEmployee', 'project'])->findOrFail($id);
        $device->status = 'available';
        $device->client_id  = null;
        $device->consultant_id  = null;
        $device->project_id  = null;
        $device->employee_id  = null;
        $device->receive_id   = null;
        $device->save();
        $request->validate([
            'clearing_signature' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
        $imageName = time() . '.' . $request->clearing_signature->extension();
        $destinationPath = public_path('X-Files/Dash/imgs/clearance');
        $request->receiving_signature->move($destinationPath, $imageName);
        $clr->clear_image = $imageName;
        $clr->status = 'finished';
        $clr->save();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function make($devices = null, $receiver_id, $receiver_type, $receive_id, $rcv_id, $simCards = null)
    {
    

        $receive = Receive::findOrFail($rcv_id);
        if ($receiver_type == 'employee') {
            $receiver = \App\Models\Employee::with(['project', 'department'])->findOrFail($receiver_id);
        } elseif ($receiver_type == 'client') {
            $receiver = \App\Models\ClientEmployee::with(['project'])->findOrFail($receiver_id);
        } elseif ($receiver_type == 'consultant') {
            $receiver = \App\Models\Consultant::with(['project'])->findOrFail($receiver_id);
        }
        $devicesData = Device::whereIn('id', explode(',', $devices))->get();
        $simCardIds = $simCards !== 'none'
            ? explode(',', $simCards)
            : [];
        $simCardsData = SimCard::whereIn('id', $simCardIds)->get();
        return view('receive.make-receiving', compact('devicesData', 'receiver', 'receiver_type', 'receive_id', 'rcv_id', 'receive', 'simCardsData'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Receive $receive)
    {
        // simCardsData && devicesData
        // $devicesData = Device::where('receive_id', $receive->id)->get();
        $rcv_id =  $receive->id;
        $receive_id =  $receive->code;
        if ($receive->employee_id != null) {
            $receiver_type = 'employee';
        } elseif ($receive->client_employee_id != null) {
            $receiver_type = 'client';
        } elseif ($receive->consultant_id != null) {
            $receiver_type = 'consultant';
        }
        if ($receiver_type == 'employee') {
            $receiver = \App\Models\Employee::with(['project', 'department'])->findOrFail($receive->employee_id);
        } elseif ($receiver_type == 'client') {
            $receiver = \App\Models\ClientEmployee::with(['project'])->findOrFail($receive->client_employee_id);
        } elseif ($receiver_type == 'consultant') {
            $receiver = \App\Models\Consultant::with(['project'])->findOrFail($receive->consultant_id);
        }

        $records = DeviceAndSimReceive::where('receive_id', $receive->id)->get();

        // Retrieve devices and sim cards data
        $devicesData = Device::whereIn('id', $records->pluck('device_id'))->get();
        $simCardsData = SimCard::whereIn('id', $records->pluck('sim_card_id'))->get();


        return view('receive.make-receiving', compact('receive', 'receiver', 'rcv_id', 'simCardsData', 'receive_id', 'receiver_type', 'devicesData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function finish($receive, Request $request)
    {
        $request->validate([
            'receiving_signature' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
        $rcv = Receive::findOrFail($receive);
        $devices = json_decode($request->devices);

        // Retrieve all devices associated with this receive
        $deviceRecords = DeviceAndSimReceive::where('receive_id', $rcv->id)->get();


        // Loop through each device and update its status to 'taken'
        foreach ($deviceRecords as $record) {
            if ($record->device_id) {
                Device::where('id', $record->device_id)
                    ->update(['status' => 'taken']);
            }elseif($record->sim_card_id){
                SimCard::where('id', $record->sim_card_id)
                    ->update(['status' => 'taken']);
            }
        }

        $imageName = time() . '.' . $request->receiving_signature->extension();
        $destinationPath = public_path('X-Files/Dash/imgs/receives');
        $request->receiving_signature->move($destinationPath, $imageName);
        $rcv->receive_image = $imageName;
        $rcv->status = 'received';
        $rcv->save();
        return redirect()->route('receive.index')->with('success', 'Receive updated successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receive $receive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Receive $receive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receive $receive)
    {
        // Get all records from device_and_sim_receives with the same receive_id
        $records = DeviceAndSimReceive::where('receive_id', $receive->id)->get();

        foreach ($records as $record) {
            // Update device if device_id is present
            if ($record->device_id) {
                Device::where('id', $record->device_id)
                    ->update([
                        'status' => 'available',
                        'client_id' => null,
                        'consultant_id' => null,
                        'employee_id' => null,
                        'receive_id' => null
                    ]);
            }

            // Update sim card if sim_card_id is present
            if ($record->sim_card_id) {
                SimCard::where('id', $record->sim_card_id)
                    ->update([
                        'status' => 'available',
                        'client_employee_id' => null,
                        'consultant_id' => null,
                        'employee_id' => null
                    ]);
            }
        }

        // Delete all records from device_and_sim_receives with the same receive_id
        DeviceAndSimReceive::where('receive_id', $receive->id)->delete();

        // Delete the receive record
        $receive->delete();

        return redirect()->route('device.index');
    }
}
