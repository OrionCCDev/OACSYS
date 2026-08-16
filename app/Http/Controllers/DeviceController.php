<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Employee;
use App\Support\PdfFonts;
use App\Models\DeviceAndSimReceive;
use App\Models\DeviceAndSimClearance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            $mainImageName = \Illuminate\Support\Str::uuid() . '.' . $mainImage->getClientOriginalExtension();
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
        $device->load('department');

        // A device can pass through many receives/clearances over its life (the
        // devices.receive_id column only ever points at the latest one), so the
        // full history has to come from the pivot tables, not that column.
        $receiveHistory = DeviceAndSimReceive::where('device_id', $device->id)
            ->with('receive')
            ->get()
            ->pluck('receive')
            ->filter()
            ->sortByDesc('created_at')
            ->values();

        $clearanceHistory = DeviceAndSimClearance::where('device_id', $device->id)
            ->with('clearance')
            ->get()
            ->pluck('clearance')
            ->filter()
            ->sortByDesc('created_at')
            ->values();

        // Whichever of the two most recent records actually happened last -
        // shown up top so a QR scan surfaces it without scrolling past history tables.
        $lastReceive = $receiveHistory->first();
        $lastClearance = $clearanceHistory->first();
        $lastActivityType = null;
        $lastActivity = null;
        if ($lastReceive && (!$lastClearance || $lastReceive->created_at->greaterThan($lastClearance->created_at))) {
            $lastActivity = $lastReceive;
            $lastActivityType = 'receive';
        } elseif ($lastClearance) {
            $lastActivity = $lastClearance;
            $lastActivityType = 'clearance';
        }

        return view('device.show', compact(
            'device', 'receiveHistory', 'clearanceHistory', 'lastActivity', 'lastActivityType'
        ));
    }

    /**
     * Fixed, printable QR code for this device - encodes the (admin-only)
     * device.show URL, so scanning it always lands on this device's current
     * data and full receive/clearance history.
     */
    public function qrCode(Device $device)
    {
        $url = route('device.show', $device->id);
        $qrSvg = QrCode::size(280)->margin(1)->generate($url);

        return view('device.qr-code', compact('device', 'url', 'qrSvg'));
    }

    /**
     * Phomemo label as an actual PDF, not an HTML page sent to window.print().
     * Printing HTML lets the browser inject its own "headers and footers"
     * (date, page URL, page number) into the printable area regardless of
     * @page margin - that text was showing up on the physical label and
     * pushing the QR code out of frame. A real PDF, printed via the
     * browser's PDF viewer, never gets that overlay.
     */
    public function qrPrint(Device $device)
    {
        $url = route('device.show', $device->id);
        // PNG needs the imagick extension, which isn't available here, so SVG it is -
        // but dompdf only resolves SVG through an <img src="data:image/svg+xml;..."> ,
        // it has no renderer for an inline <svg> element written directly in the HTML
        // (that was silently dropped, leaving the label with no QR code at all).
        $qrSvg = QrCode::size(240)->margin(1)->generate($url);
        $qrDataUri = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        $pdf = Pdf::loadView('device.qr-label-pdf', compact('device', 'qrDataUri'));
        PdfFonts::register($pdf->getDomPDF());

        // 50mm x 30mm in points (1mm = 2.83464567pt) - matches the actual paper size
        // preset ("50 x 30mm") the M110S driver offers, confirmed against a real print.
        $pdf->setPaper([0, 0, 141.732, 85.039]);

        return $pdf->stream($device->device_code . '-qr-label.pdf');
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
                $oldImagePath = public_path('X-Files/Dash/imgs/devices/' . $device->main_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Store new image
            $mainImage = $request->file('main_image');
            $mainImageName = \Illuminate\Support\Str::uuid() . '.' . $mainImage->getClientOriginalExtension();
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
            'employee_id' => null,
            'receive_id' => null,
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
