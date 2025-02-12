<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Consultant;
use Illuminate\Http\Request;
use App\Models\ClientEmployee;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function addDevices($id)
    {
        $project = Project::find($id);
        $devices = Device::whereNotNull('project_id')->whereNotNull('employee_id')->whereNotNull( 'consultant_id')->whereNotNull('client_id')->get();
        return view('project.addDevices' , compact('project' , 'devices'));
    }


    public function addEmployeeProject($id)
    {
        $project = Project::find($id);
        // $employees =Employee::all();
        return view('project.addEmployees' , compact('project'));
    }


    public function storeDevices()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // First get the project without employees
        $project = Project::with(['consultants', 'clients.client', 'devices', 'manager'])
            ->find($id);
        if (!$project) {
            abort(404, 'Project not found');
        }
        $projects = Project::where('status', 'in-progress')->where('id', '!=', $id)->get();
        // Get paginated employees separately
        $project->employees = $project->employees()->with('position')->paginate(10);
        $clientsCount = $project->clients()->count() ?? '0';
        $consultantsCount = $project->consultants()->count() ?? '0';
        $clientEmployees = ClientEmployee::with('client')->get();
        $projectEmployeesCount = Employee::where('project_id', $id)->count() ?? '0';

        $consultants = Consultant::all();
        return view('project.details', compact( 'projectEmployeesCount' , 'project', 'clientsCount', 'consultantsCount', 'projects', 'clientEmployees', 'consultants'));
    }

    public function addClient(Request $request, $id)
    {
        // $project->clients()->attach($request->client_employee_id);
        $clientEmployee = ClientEmployee::find($request->client_employee_id);
        $clientEmployee->update(['project_id' => $id]);
        return redirect()->back()->with('success', 'Client added successfully');
    }

    public function removeClient(ClientEmployee $client)
    {
        $client->update(['project_id' => null]);
        return redirect()->back()->with('success', 'Client removed from project');
    }

    public function transferClient(Request $request, ClientEmployee $client)
    {
        $client->update(['project_id' => $request->project_id]);
        return redirect()->back()->with('success', 'Client transferred to new project');
    }

    public function addConsultant(Request $request, $id)
    {
        // $project->clients()->attach($request->client_employee_id);
        $consultantEmployee = Consultant::find($request->consultantEmployee);
        $consultantEmployee->update(['project_id' => $id]);
        return redirect()->back()->with('success', 'Consultant added successfully');
    }

    public function removeConsultant(Consultant $consultant)
    {
        $consultant->update(['project_id' => null]);
        return redirect()->back()->with('success', 'consultant removed from project');
    }

    public function transferConsultant(Request $request, Consultant $consultant)
    {
        $consultant->update(['project_id' => $request->project_id]);
        return redirect()->back()->with('success', 'consultant transferred to new project');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function transfer(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'project_id' => 'required|exists:projects,id',
        ]);
        $employee = Employee::find($request->employee_id);
        $employee->project_id = $request->project_id;
        $employee->save();
        return redirect()->back()->with('success', 'Employee transferred successfully');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
