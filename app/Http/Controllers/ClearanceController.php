<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\SimCard;
use App\Models\Employee;
use App\Models\Clearance;
use App\Models\Consultant;
use Illuminate\Http\Request;
use App\Models\ClientEmployee;
use App\Models\DeviceAndSimClearance;

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
        // Release any associated devices

        $clearance->delete();

        return redirect()->route('clearance.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Cancelled!',
                'text' => 'Clearance has been cancelled successfully.'
            ]);
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
        // Create a new clearance
        $clearance = Clearance::create([
            'clear_code' => Clearance::generateUniqueCode(),
            'employee_id' => $request->person_type == 'employee' ? $person->id : null,
            'client_employee_id' => $request->person_type == 'client' ? $person->id : null,
            'consultant_id' => $request->person_type == 'consultant' ? $person->id : null,
            'status' => 'pending'
        ]);

        // Attach devices to the clearance
        $clearance->devices()->attach($request->devices);

        // Attach SIM cards to the clearance
        $clearance->simCards()->attach($request->simCards);

        return redirect()->route('clearance.show' , ['clearance' => $clearance->id]);
    }


    public function uploadSignature(Request $request, $id)
    {
        $request->validate([
            'signature' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $clearance = Clearance::with(['devices', 'simCards'])->findOrFail($id);

        if ($request->hasFile('signature')) {

            $imageName = time() . '.' . $request->signature->extension();

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
                    'status' => 'available'
                ]);
            }
            foreach ($clearance->simCards as $sim) {
                $sim->update([
                    'employee_id' => null,
                    'client_employee_id' => null,
                    'consultant_id' => null,
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
    public function selectAllDevicesAndSims(Request $request, $id)
    {
        $request->validate([
            'signature' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $clearance = Clearance::with(['devices', 'simCards'])->findOrFail($id);

        if ($request->hasFile('signature')) {

            $imageName = time() . '.' . $request->signature->extension();
            $request->signature->storeAs('public/X-Files/Dash/imgs/clearance', $imageName);
            // Update clearance with signature path
            $clearance->clear_image = $imageName;
            $clearance->status = 'finished';

            $clearance->save();
            foreach ($clearance->devices as $device) {
                $device->update([
                    'employee_id' => null,
                    'client_id' => null,
                    'consultant_id' => null
                ]);
            }
            foreach ($clearance->simCards as $sim) {
                $sim->update([
                    'employee_id' => null,
                    'client_employee_id' => null,
                    'consultant_id' => null,
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
     * Display the specified resource.
     */
    public function show(Clearance $clearance)
    {
        $data = [
            'clearance' => $clearance,
            'employee' => $clearance->employee,
            'consultant' => $clearance->consultant,
            'clientEmployee' => $clearance->clientEmployee,
            'devices' => $clearance->devices,
            'simCards' => $clearance->simCards,
        ];

        return view('clearance.show', compact('data'));
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
        DeviceAndSimClearance::where('clearance_id', $clearance->id)->delete();
        $clearance->delete();
        return to_route('clearance.index');
    }
}
