<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientEmployeeRequest;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ClientEmployee;
use App\Models\SimCard;

class ClientEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ClientEmployee::with(['client','project','sim_card','devices'])->paginate(10);
        $projects = Project::where('status', 'in-progress')->get();
        $Clients = Client::all();
        return view('clientEmployee.index' , compact('data','projects','Clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientEmployeeRequest $request)
    {

        $validated = $request->validated();

        $clientEmployee = ClientEmployee::create([
            'name' => $request->name,
            'email' => $request->email,
            'client_id' => $request->client_id,
            'project_id' => $request->project_id,
            'mobile_number' => $request->mobile_number,
        ]);

        // if($request->orion_number){
        //     $sim_card =  SimCard::where('id', $request->orion_number)->update([
        //         'client_employee_id' => $request->mobile_number,
        //     ]);
        // }
        if($request->orion_number && $request->orion_number !== 'Select SIM Card'){
            $sim_card = SimCard::where('id', $request->orion_number)->update([
                'client_employee_id' => $clientEmployee->id
            ]);
        }
        if($request->hasFile('client_receives')) {
            foreach($request->file('client_receives') as $receive) {
                $clientEmployee->addMedia($receive)
                    ->toMediaCollection('receives');
            }
        }

        if($request->hasFile('client_gallary')) {
            foreach($request->file('client_gallary') as $image) {
                $clientEmployee->addMedia($image)
                    ->toMediaCollection('gallery');
            }
        }

        return redirect()->route('clientEmployee.index')->with('success', 'Client Employee Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientEmployee $clientEmployee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientEmployee $clientEmployee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientEmployee $clientEmployee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientEmployee $clientEmployee)
    {
        //
    }
}
