<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Project;
use App\Models\Consultant;
use App\Models\ClientEmployee;
use App\Models\PrinterAssignment;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    /**
     * Report of every rental printer, wherever it currently is.
     */
    public function index(Request $request)
    {
        $query = Device::printers()->with(['currentAssignment.project', 'currentAssignment.clientEmployee', 'currentAssignment.consultant']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('device_name', 'like', "%{$search}%")
                    ->orWhere('device_model', 'like', "%{$search}%")
                    ->orWhere('supplier_name', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        $printers = $query->orderBy('device_name')->paginate(15)->withQueryString();

        return view('printers.index', compact('printers'));
    }

    /**
     * Single printer: current location plus the full dated history of every
     * project/client/consultant/office period it's been through.
     */
    public function show(Device $device)
    {
        abort_unless($device->device_type === 'Printer', 404);

        $device->load([
            'currentAssignment.project',
            'currentAssignment.clientEmployee',
            'currentAssignment.consultant',
            'printerAssignments.project',
            'printerAssignments.clientEmployee',
            'printerAssignments.consultant',
            'printerAssignments.assignedBy',
        ]);

        $projects = Project::where('status', 'in-progress')->orderBy('project_name')->get();
        $clientEmployees = ClientEmployee::orderBy('name')->get();
        $consultants = Consultant::orderBy('name')->get();

        return view('printers.show', compact('device', 'projects', 'clientEmployees', 'consultants'));
    }

    /**
     * Move a printer to a project, a client, a consultant, or our office,
     * with a start date - closing out whatever period it's currently in.
     */
    public function assign(Request $request, Device $device)
    {
        abort_unless($device->device_type === 'Printer', 404);

        $validated = $request->validate([
            'location_type' => 'required|in:project,client,consultant,office',
            'target_id' => 'nullable|integer|required_unless:location_type,office',
            'start_date' => 'required|date',
            'notes' => 'nullable|string|max:255',
        ]);

        $targetId = $validated['location_type'] === 'office' ? null : (int) $validated['target_id'];

        $targetExists = match ($validated['location_type']) {
            'project' => Project::where('id', $targetId)->exists(),
            'client' => ClientEmployee::where('id', $targetId)->exists(),
            'consultant' => Consultant::where('id', $targetId)->exists(),
            'office' => true,
        };

        if (!$targetExists) {
            return redirect()->back()->with('error', 'The selected destination could not be found.');
        }

        PrinterAssignment::reassign(
            $device,
            $validated['location_type'],
            $targetId,
            $validated['start_date'],
            auth()->user()->employee_profile_id,
            $validated['notes'] ?? null
        );

        return redirect()->route('printers.show', $device->id)
            ->with('success', 'Printer reassigned successfully.');
    }
}
