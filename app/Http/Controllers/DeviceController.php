<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices = Device::with(['employee','consultant','clientEmployee','project'])->paginate(5);
        return view('device.index' , compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('device.add');
    }
    public function assignDeviceToEmp()
    {
        $devices = Device::all();
        $employees = Employee::all();
        return view('device.assignDeviceToEmp', compact('devices', 'employees'));
    }
    public function storeAssignDeviceToEmp(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        $devId = $request->input('device_id');
        $empId = $request->input('employee_id');

        $device = Device::find($devId);
        $employee = Employee::find($empId);

        if ($device && $employee) {
            $device->status = 'taken';
            $device->client_id = null;
            $device->consultant_id = null;
            $device->project_id = null;
            $device->employee_id = $employee->id;
            $device->save();
            return redirect()->route('device.index')->with('success', 'Device assigned to employee successfully.');
        } else {
            return redirect()->back()->with('error', 'Device or Employee not found.');
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestedData = $request->validate([
            'device_type' => 'required|string|max:255|in:Laptop,Pc,Router,Switch,NVR,Camera,Printer,Screen,Inverter,PC_Element,Electric_Element,Telephone,Other',
            'device_name' => 'required|string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'device_model' => 'nullable|string|max:255',
            'device_price' => 'nullable|string|max:255',
            'supplier_name' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'health' => 'required|in:New,Mediam_use,Bad_use,Scrap,Need_fix',
            'stored_at' => 'required|in:office,server,store,delivered',
            'short_description' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
            'device_gallary.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $deviceType = substr($request->device_type, 0, 2); // First 2 letters
        $year = date('y'); // Last 2 digits of year
        $month = date('m'); // 2 digits month
        $hours = date('H'); // 2 digits month
        $minutes = date('i'); // 2 digits minutes
        $seconds = date('s'); // 2 digits minutes

        $deviceCode = strtoupper($deviceType) . $year . $month . $hours . $minutes . $seconds;
        $device = Device::create([
            'device_type' => $requestedData['device_type'],
            'device_name' => $requestedData['device_name'],
            'device_code' => $deviceCode,
            'device_model' => $requestedData['device_model'],
            'device_price' => $requestedData['device_price'],
            'supplier_name' => $requestedData['supplier_name'],
            'stored_at' => $requestedData['stored_at'],
            'serial_number' => $requestedData['serial_number'],
            'health' => $requestedData['health'],
            'short_description' => $requestedData['short_description'],
            'notes' => $requestedData['notes'],
        ]);
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_' . $mainImage->getClientOriginalName();
            $mainImage->move(public_path('X-Files/Dash/imgs/devices'), $mainImageName);
            $device->main_image = $mainImageName;
            $device->save();
        }
        if($request->hasFile('device_gallary')) {
            foreach($request->file('device_gallary') as $image) {
                $media = $device->addMedia($image)
                    ->preservingOriginal()
                    ->toMediaCollection('Device_image');

                    $mediaPath = $media->getPath();
                    chmod($mediaPath, 0777);
                    chmod(dirname($mediaPath), 0777);
            }
        }

        return redirect()->route('device.index')->with('success', 'Device created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        return view('device.show', compact('device'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        return view('device.edit', compact('device'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'device_type' => 'required|string',
            'device_name' => 'required|string',
            'device_model' => 'nullable|string',
            'device_price' => 'nullable|numeric',
            'supplier_name' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'stored_at' => 'required|in:office,server,store,delivered',
            'health' => 'required|in:New,Mediam_use,Bad_use,Scrap,Need_fix',
            'short_description' => 'nullable|string',
            'notes' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

        // Handle main image update
        if ($request->hasFile('main_image')) {
            // Delete old image if it exists and is not the default image
            if ($device->main_image && $device->main_image != 'default_device.png') {
                Storage::delete('public/X-Files/Dash/imgs/devices/' . $device->main_image);
            }

            // Store new image
            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_' . $mainImage->getClientOriginalName();
            $mainImage->move(public_path('X-Files/Dash/imgs/devices'), $mainImageName);
            $validated['main_image'] = $mainImageName;
        }

        // Handle device gallery update
        if ($request->hasFile('device_gallary')) {
            // Optionally, you can clear the existing gallery images if needed
            // $device->clearMediaCollection('Device_image');

            foreach ($request->file('device_gallary') as $image) {
                $media = $device->addMedia($image)
                    ->preservingOriginal()
                    ->toMediaCollection('Device_image');

                    $mediaPath = $media->getPath();
                    chmod($mediaPath, 0777);
                    chmod(dirname($mediaPath), 0777);
            }
        }

        // Update the device with validated data
        $device->update($validated);

        return redirect()->route('device.index')
            ->with('success', 'Device updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        //
    }

    /**
     * Unassign a device and make it available
     */
    public function unassign(Device $device)
    {
        $device->update([
            'status' => 'available',
            'client_id' => null,
            'consultant_id' => null,
            'project_id' => null,
            'employee_id' => null
        ]);

        return redirect()->back()->with('success', 'Device has been made available');
    }

    /**
     * Assign a device to an employee
     */
    public function assign(Request $request, Device $device)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id'
        ]);

        $device->update([
            'status' => 'taken',
            'employee_id' => $request->employee_id,
            'client_id' => null,
            'consultant_id' => null,
            'project_id' => null
        ]);

        return response()->json(['success' => true]);
    }
}
