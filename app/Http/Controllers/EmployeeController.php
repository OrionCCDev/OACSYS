<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Device;
use App\Models\Project;
use App\Models\Receive;
use App\Models\SimCard;
use App\Models\Employee;
use App\Models\Clearance;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DeviceAndSimClearance;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeesImport;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with(['devices', 'department', 'position', 'project', 'sim_card'])->orderBy('created_at', 'DESC')->paginate(25);
        return view('employees.index', compact('employees'));
    }

    public function showReceives($id)
    {
        $employee = Employee::with('receives')->find($id);
        // Logic to display all employee receives
        return view('employees.receives', compact('employee'));
    }
    public function updateEmployees(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new EmployeesImport, $request->file('file'));

        return redirect()->back()->with('success', 'Employees updated successfully.');
    }
    public function showReceiveDetails($id)
    {
        $receive = Receive::find($id);
        $deviceIds = DB::table('device_and_sim_receives')
                        ->where('receive_id', $id)
                        ->whereNotNull('device_id')
                        ->pluck('device_id')
                        ->toArray();
        $simCardsIds = DB::table('device_and_sim_receives')
                        ->where('receive_id', $id)
                        ->whereNotNull('sim_card_id')
                        ->pluck('sim_card_id')
                        ->toArray();

        $Devices = Device::whereIn('id', $deviceIds)->get();
        $SimCards = SimCard::whereIn('id', $simCardsIds)->get();

        // Logic to display all employee receives
        return view('receive.receiveDetails', compact('receive' , 'Devices' , 'SimCards'));
    }


    public function showClearances($id)
    {
        $employee = Employee::with('clearance')->find($id);
        // Logic to display all employee clearances
        return view('employees.clearances', compact('employee'));
    }
    public function showClearanceDetails($id)
    {
        $clr = Clearance::find($id);
        $deviceIds = DB::table('device_and_sim_clearances')
                        ->where('clearance_id', $id)
                        ->whereNotNull('device_id')
                        ->pluck('device_id')
                        ->toArray();
        $simCardsIds = DB::table('device_and_sim_clearances')
                        ->where('clearance_id', $id)
                        ->whereNotNull('sim_card_id')
                        ->pluck('sim_card_id')
                        ->toArray();

        $Devices = Device::whereIn('id', $deviceIds)->get();
        $SimCards = SimCard::whereIn('id', $simCardsIds)->get();

        // Logic to display all employee receives
        return view('clearance.clearanceDetails', compact('clr' , 'Devices' , 'SimCards'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastID = Employee::orderByRaw('CAST(employee_id AS UNSIGNED) DESC')
            ->value('employee_id');

        $sims = SimCard::where('status', 'available')->get();

        $projects = Project::where('status', 'in-progress')->get();

        $managers = Employee::where('type', 'manager')->get();

        return view('employees.add', compact('lastID', 'sims', 'projects', 'managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_code' => 'required',
            'employee_name' => 'required',
            'employee_personal_email' => 'email|unique:employees,personal_email',
            'employee_personal_mobile' => 'nullable',
            'employee_orion_email' => 'nullable|email|unique:employees,orion_email',
            'employee_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'employee_department' => 'required|exists:departments,id',
            'employee_position' => 'required|exists:positions,id',
            'employee_sim_number' => 'nullable',
            'hire_date' => 'nullable|date',
            'type' => 'required|in:manager,employee,owner,labor',
            'employee_project' => 'nullable',
            'employee_manager' => 'nullable',
            'notes' => 'nullable|max:255',
        ]);
        $employee = Employee::create([
            'employee_id' => $request->employee_code,
            'name' => $request->employee_name,
            'personal_email' => $request->employee_personal_email,
            'personal_mobile' => $request->employee_personal_mobile,
            'orion_email' => $request->employee_orion_email,
            'department_id' => $request->employee_department,
            'position_id' => $request->employee_position,
            'type' => $request->type,
            'hire_date' => $request->hire_date ?? now(),
            'project_id' => $request->employee_project,
            'manager_id' => $request->employee_manager,
            'notes' => $request->notes,
        ]);
        if ($request->employee_sim_number) {
            $sim_card =  SimCard::where('id', $request->employee_sim_number)->update([
                'employee_id' => $employee->id,
                'status' => 'taken',
            ]);
        }
        if ($request->hasFile('employee_image')) {
            try {
                $image = $request->file('employee_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();

                // Debug information
                Log::info('Attempting to move image');
                \Log::info('Target path: ' . public_path('X-Files/Dash/imgs/EmployeeProfilePic'));
                \Log::info('Image name: ' . $imageName);

                if ($image->move(public_path('X-Files/Dash/imgs/EmployeeProfilePic'), $imageName)) {
                    $employee->update([
                        'profile_image' => $imageName,
                    ]);
                    \Log::info('Image moved successfully');
                } else {
                    \Log::error('Failed to move image');
                }
            } catch (\Exception $e) {
                \Log::error('Image upload error: ' . $e->getMessage());
                return back()->with('error', 'Failed to upload image: ' . $e->getMessage());
            }
        }
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee = Employee::with(['devices', 'department', 'position', 'project', 'sim_card', 'receives', 'clearance'])->find($employee->id);
        $project = $employee->project;
        return view('employees.show', compact('employee', 'project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $projects = Project::where('status', 'in-progress')->get();
        $managers = Employee::where('type', 'manager')->get();
        return view('employees.edit', compact('employee', 'projects', 'managers'));
    }

    public function preResign($id)
    {
        $employee = Employee::with('devices', 'department', 'position', 'sim_card', 'project', 'clearance')->find($id);
        // dd($employee);
        if ($employee->clearance->where('status', 'pending_resign')->count() > 0) {
            $clearanceResign = $employee->clearance->where('status', 'pending_resign')->first();
        } elseif ($employee->clearance->where('status', 'resigned')->count() > 0) {
            $clearanceResign = $employee->clearance->where('status', 'resigned')->first();
        } else {
            $clearanceResign = Clearance::create([
                'employee_id' => $employee->id,
                'status' => 'pending_resign',
            ]);
            // Create a new DeviceAndSimClearance
            $deviceAndSimClearance = DeviceAndSimClearance::create([
                'clearance_id' => $clearanceResign->id,
            ]);

            // Attach all devices assigned to the employee
            foreach ($employee->devices as $device) {
                DB::table('device_and_sim_clearances')->insert([
                    'device_id' => $device->id,
                    'clearance_id' => $deviceAndSimClearance->id,
                ]);
            }

            // Attach all SIM cards assigned to the employee
            foreach ($employee->simCards as $simCard) {
                DB::table('device_and_sim_clearances')->insert([
                    'sim_card_id' => $simCard->id,
                    'clearance_id' => $deviceAndSimClearance->id,
                ]);
            }
        }

        return view('employees.resign', compact('employee', 'clearanceResign'));
    }

    public function finishResign($id, $clr, Request $request)
    {
        $validatedData = $request->validate([
            'signature' => 'required|mimes:png,jpg,jpeg,webp,pdf|max:2048',
        ]);
        $employee = Employee::with('devices', 'sim_card')->find($id);
        $finalClearance = Clearance::find($clr);
        if ($request->hasFile('signature')) {
            $signature = $request->file('signature');
            $signatureName = time() . '.' . $signature->getClientOriginalExtension();
            $signature->move(public_path('X-Files/Dash/imgs/clearance'), $signatureName);
            $finalClearance->update([
                'clear_image' => $signatureName,
                'status' => 'resigned',
            ]);
            foreach ($employee->devices as $device) {

                DB::table('device_and_sim_clearances')->create([
                    'device_id' => $device->id,
                    'clearance_id' => $finalClearance->id,
                ]);
            }
            foreach ($employee->sim_card() as $sim) {

                DB::table('device_and_sim_clearances')->create([
                    'sim_card_id' => $sim->id,
                    'clearance_id' => $finalClearance->id,
                ]);
            }

            $employee->update([
                'resign_date' => now(),
                'projectt_id' => null,
                'type' => 'resigned',
            ]);
            $employee->devices()->update([
                'employee_id' => null,
                'status' => 'available',
            ]);
            $employee->sim_card()->update([
                'employee_id' => null,
                'status' => 'available',
            ]);
        }
        return to_route('employees.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'employee_code' => 'required',
            'employee_name' => 'required',
            'employee_personal_email' => 'nullable|email|unique:employees,personal_email,' . $employee->id,
            'employee_personal_mobile' => 'nullable',
            'employee_orion_email' => 'nullable|email|unique:employees,orion_email,' . $employee->id,
            'employee_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'hire_date' => 'nullable|date',
            'type' => 'required|in:manager,employee,owner,labor',
            'employee_project' => 'nullable',
            'employee_manager' => 'nullable',
            'notes' => 'nullable|max:255',
        ]);

        $employee->update([
            'employee_id' => $request->employee_code,
            'name' => $request->employee_name,
            'personal_email' => $request->employee_personal_email,
            'personal_mobile' => $request->employee_personal_mobile,
            'orion_email' => $request->employee_orion_email,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'type' => $request->type,
            'hire_date' => $request->hire_date ?? now(),
            'project_id' => $request->employee_project,
            'manager_id' => $request->employee_manager,
            'notes' => $request->notes,
        ]);



        if ($request->hasFile('employee_image')) {
            // Delete old image if exists and not default
            if ($employee->profile_image && $employee->profile_image !== 'default_employee.png') {
                $oldImagePath = public_path('X-Files/Dash/imgs/EmployeeProfilePic/') . $employee->profile_image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('employee_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            if ($image->move(public_path('X-Files/Dash/imgs/EmployeeProfilePic'), $imageName)) {
                $employee->update(['profile_image' => $imageName]);
            }
        }

        return redirect(url()->previous())->with('success', 'Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
