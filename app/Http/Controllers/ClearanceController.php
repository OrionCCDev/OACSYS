<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Project;
use App\Models\SimCard;
use App\Models\Employee;
use App\Models\Clearance;
use App\Models\Department;
use App\Models\Consultant;
use App\Support\PdfFonts;
use Illuminate\Http\Request;
use App\Models\ClientEmployee;
use App\Models\DeviceAndSimClearance;
use Barryvdh\DomPDF\Facade\Pdf;

class ClearanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Clearance::with(['clientEmployee', 'consultant', 'employee'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        return view('clearance.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clearance.make');
    }

    public function cancel(Clearance $clearance)
    {
        $this->revertPendingCancelAssets($clearance);

        $clearance->delete();

        return redirect()->route('clearance.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Cancelled!',
                'text' => 'Clearance has been cancelled successfully.'
            ]);
    }

    /**
     * Both ProjectAssetController::storeClearance() and ReceiveController::cancel() flip a
     * device/sim to 'pending-cancel' immediately, before any clearance is actually finished.
     * If that clearance gets deleted/cancelled through the ordinary clearance.destroy/cancel
     * routes instead of being completed, those assets would otherwise be stranded at
     * 'pending-cancel' forever - not available for reissue, not matched by "still on this
     * project" queries, nothing. Revert each one to whatever active status actually fits its
     * current ownership, instead of just deleting the clearance record and leaving them stuck.
     */
    private function revertPendingCancelAssets(Clearance $clearance): void
    {
        $devices = Device::where('status', 'pending-cancel')
            ->whereIn('id', $clearance->devices()->pluck('devices.id'))
            ->get();

        foreach ($devices as $device) {
            $hasPersonalOwner = $device->employee_id || $device->client_id || $device->consultant_id;
            $device->update(['status' => ($hasPersonalOwner || $device->department_id) ? 'taken' : 'In-Project-Site']);
        }

        // Sim cards have no project-site equivalent status - 'taken' covers both cases.
        SimCard::where('status', 'pending-cancel')
            ->whereIn('id', $clearance->simCards()->pluck('sim_cards.id'))
            ->update(['status' => 'taken']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function selectDevicesAndSimCards($id, $type)
    {
        $person = null;

        if ($type == 'employee') {
            $person = Employee::findOrFail($id);
        } elseif ($type == 'client') {
            $person = ClientEmployee::findOrFail($id);
        } elseif ($type == 'consultant') {
            $person = Consultant::findOrFail($id);
        }

        if (!$person) {
            abort(404, 'Person not found');
        }

        // Fetch available devices and SIM cards for the selected person
        $devices = $person->devices()->where('status', 'taken')->get();
        $simCards = $person->sim_card()->where('status', 'taken')->get();

        // Return the view with the data
        return view('clearance.select', compact('person', 'devices', 'simCards', 'type'));
    }


    public function selectedDevicesAndSimCardsToMakeClearance(Request $request)
    {
        $request->validate([
            'person_type' => 'required|in:employee,client,consultant',
            'person_id' => 'required|integer',
            'devices' => 'nullable|array',
            'devices.*' => 'integer',
            'simCards' => 'nullable|array',
            'simCards.*' => 'integer',
        ]);

        $person = null;

        if ($request->person_type == 'employee') {
            $person = Employee::findOrFail($request->person_id);
        } elseif ($request->person_type == 'client') {
            $person = ClientEmployee::findOrFail($request->person_id);
        } elseif ($request->person_type == 'consultant') {
            $person = Consultant::findOrFail($request->person_id);
        }

        if (!$person) {
            abort(404, 'Person not found');
        }

        // Only attach devices/sims actually currently held by this person - a tampered
        // request shouldn't be able to attach (and later free) someone else's assets.
        $deviceIds = $person->devices()->where('status', 'taken')->whereIn('id', $request->devices ?? [])->pluck('id');
        $simIds = $person->sim_card()->where('status', 'taken')->whereIn('id', $request->simCards ?? [])->pluck('id');

        if ($deviceIds->isEmpty() && $simIds->isEmpty()) {
            return back()->with('error', 'None of the selected items are currently held by this person.');
        }

        // Create a new clearance (clear_code is generated by the model's creating() hook)
        $clearance = Clearance::create([
            'employee_id' => $request->person_type == 'employee' ? $person->id : null,
            'client_employee_id' => $request->person_type == 'client' ? $person->id : null,
            'consultant_id' => $request->person_type == 'consultant' ? $person->id : null,
            'status' => 'pending'
        ]);

        $clearance->devices()->attach($deviceIds);
        $clearance->simCards()->attach($simIds);

        return redirect()->route('clearance.show' , ['clearance' => $clearance->id]);
    }


    public function uploadSignature(Request $request, $id)
    {
        $request->validate([
            'signature' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $clearance = Clearance::with(['devices', 'simCards'])->findOrFail($id);

        if ($request->hasFile('signature')) {

            $imageName = \Illuminate\Support\Str::uuid() . '.' . $request->signature->extension();

            $destinationPath = public_path('X-Files/Dash/imgs/clearance');
            $request->signature->move($destinationPath, $imageName);

            // Update clearance with signature path
            $clearance->clear_image = $imageName;
            $clearance->status = 'finished';

            $clearance->save();
            foreach ($clearance->devices as $device) {
                $device->update([
                    'employee_id' => null,
                    'client_id' => null,
                    'consultant_id' => null,
                    'project_id' => null,
                    'receive_id' => null,
                    'status' => 'available'
                ]);
            }
            foreach ($clearance->simCards as $sim) {
                $sim->update([
                    'employee_id' => null,
                    'client_employee_id' => null,
                    'consultant_id' => null,
                    'project_id' => null,
                    'status' => 'available'
                ]);
            }
        }
        return redirect()->route('clearance.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => 'Signature uploaded successfully'
            ]);
    }
    /**
     * Resolve who a clearance was made out to. Shared by the on-screen view
     * and the PDF export so the two can't drift apart - mirrors
     * ReceiveController::receiveDetails().
     */
    private function clearanceDetails(Clearance $clearance): array
    {
        $project = null;
        $department = null;
        if ($clearance->project_id != null) {
            $receiver_type = 'project';
            $project = Project::findOrFail($clearance->project_id);
            $receiver = $project->manager ?? $project->client;
        } elseif ($clearance->department_id != null) {
            $receiver_type = 'department';
            $department = Department::findOrFail($clearance->department_id);
            $receiver = $department->manager;
        } elseif ($clearance->employee_id != null) {
            $receiver_type = 'employee';
            $receiver = $clearance->employee;
        } elseif ($clearance->client_employee_id != null) {
            $receiver_type = 'client';
            $receiver = $clearance->clientEmployee;
        } elseif ($clearance->consultant_id != null) {
            $receiver_type = 'consultant';
            $receiver = $clearance->consultant;
        } else {
            $receiver_type = null;
            $receiver = null;
        }

        return compact('receiver', 'receiver_type', 'project', 'department');
    }

    /**
     * Display the specified resource.
     */
    public function show(Clearance $clearance)
    {
        $clearance->load(['employee.department', 'clientEmployee', 'consultant', 'devices', 'simCards']);
        extract($this->clearanceDetails($clearance));

        $data = [
            'clearance' => $clearance,
            'employee' => $clearance->employee,
            'consultant' => $clearance->consultant,
            'clientEmployee' => $clearance->clientEmployee,
            'devices' => $clearance->devices,
            'simCards' => $clearance->simCards,
            'receiver' => $receiver,
            'receiver_type' => $receiver_type,
            'project' => $project,
            'department' => $department,
        ];

        return view('clearance.show', compact('data'));
    }

    /**
     * Branded, print-ready PDF of the clearance / resignation document.
     */
    public function pdf(Clearance $clearance)
    {
        $clearance->load(['employee.department', 'clientEmployee', 'consultant', 'devices', 'simCards']);
        extract($this->clearanceDetails($clearance));

        $isResignation = in_array($clearance->status, ['pending_resign', 'resigned']);

        $pdf = Pdf::loadView('pdf.clearance', [
            'clearance' => $clearance,
            'receiver' => $receiver,
            'receiver_type' => $receiver_type,
            'project' => $project,
            'department' => $department,
            'isResignation' => $isResignation,
            'devicesData' => $clearance->devices,
            'simCardsData' => $clearance->simCards,
        ]);
        PdfFonts::register($pdf->getDomPDF());

        $prefix = $isResignation ? 'resignation-' : 'clearance-';

        return $pdf->stream($prefix . $clearance->clear_code . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clearance $clearance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clearance $clearance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clearance $clearance)
    {
        $this->revertPendingCancelAssets($clearance);

        DeviceAndSimClearance::where('clearance_id', $clearance->id)->delete();
        $clearance->delete();
        return redirect()->back()->with('success', 'Clearance deleted and assets returned to their prior status.');
    }
}
