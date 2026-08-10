<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Device;
use App\Models\Project;
use App\Models\Receive;
use App\Models\SimCard;
use App\Models\Employee;
use App\Models\Clearance;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Imports\EmployeesImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DeviceAndSimClearance;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Support\PdfFonts;

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

    public function showHistory($id)
    {
        $employee = Employee::with([
            'receives',
            'clearance',
            'devices',
            'sim_card'
        ])->find($id);

        // Get all receives with related devices and sim cards
        $receives = $employee->receives->map(function($receive) use ($id) {
            $deviceIds = DB::table('device_and_sim_receives')
                ->where('receive_id', $receive->id)
                ->whereNotNull('device_id')
                ->pluck('device_id')
                ->toArray();

            $simCardIds = DB::table('device_and_sim_receives')
                ->where('receive_id', $receive->id)
                ->whereNotNull('sim_card_id')
                ->pluck('sim_card_id')
                ->toArray();

            $receive->devices_list = Device::whereIn('id', $deviceIds)->get();
            $receive->simcards_list = SimCard::whereIn('id', $simCardIds)->get();
            $receive->type = 'receive';

            return $receive;
        });

        // Get all clearances with related devices and sim cards
        $clearances = $employee->clearance->map(function($clearance) use ($id) {
            $deviceIds = DB::table('device_and_sim_clearances')
                ->where('clearance_id', $clearance->id)
                ->whereNotNull('device_id')
                ->pluck('device_id')
                ->toArray();

            $simCardIds = DB::table('device_and_sim_clearances')
                ->where('clearance_id', $clearance->id)
                ->whereNotNull('sim_card_id')
                ->pluck('sim_card_id')
                ->toArray();

            $clearance->devices_list = Device::whereIn('id', $deviceIds)->get();
            $clearance->simcards_list = SimCard::whereIn('id', $simCardIds)->get();
            $clearance->type = 'clearance';

            return $clearance;
        });

        // Merge and sort by date (most recent first)
        $history = $receives->merge($clearances)->sortByDesc('created_at');

        return view('employees.history', compact('employee', 'history'));
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
            'employee_personal_email' => 'nullable|email|unique:employees,personal_email',
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
                $imageName = \Illuminate\Support\Str::uuid() . '.' . $image->getClientOriginalExtension();

                // Debug information
                Log::info('Attempting to move image');
                Log::info('Target path: ' . public_path('X-Files/Dash/imgs/EmployeeProfilePic'));
                Log::info('Image name: ' . $imageName);

                if ($image->move(public_path('X-Files/Dash/imgs/EmployeeProfilePic'), $imageName)) {
                    $employee->update([
                        'profile_image' => $imageName,
                    ]);
                    Log::info('Image moved successfully');
                } else {
                    Log::error('Failed to move image');
                }
            } catch (\Exception $e) {
                Log::error('Image upload error: ' . $e->getMessage());
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
        $user = Auth::user();
        if (!$user->hasRole(['o-hr', 'o-super-admin', 'o-admin','o-manager'])) {

                abort(403, 'Unauthorized access');

        }
        if($user->hasRole(['o-manager']) && $employee->manager_id != $user->employee_profile_id){
            abort(403, 'Unauthorized access');
        }

        $employee = Employee::with(['devices', 'department', 'position', 'project', 'sim_card', 'receives', 'clearance'])->find($employee->id);
        $project = $employee->project;
        $hireDate = Carbon::parse($employee->hire_date)->format('Y,M');
        $now = $employee->resign_date ? Carbon::parse($employee->resign_date) : Carbon::now();
        $diff = Carbon::parse($employee->hire_date)->diff($now);
        return view('employees.show', compact('employee', 'project', 'diff' ,'hireDate'));
    }

    public function generatePrintablePdf($id)
    {
        $employee = Employee::with(['department', 'position', 'project', 'sim_card'])->findOrFail($id);
        $hireDate = $employee->hire_date ? Carbon::parse($employee->hire_date)->format('F j, Y') : null;
        $now = $employee->resign_date ? Carbon::parse($employee->resign_date) : Carbon::now();
        $diff = $employee->hire_date ? Carbon::parse($employee->hire_date)->diff($now) : null;

        $pdf = Pdf::loadView('employees.employee_print', compact('employee', 'hireDate', 'diff'));
        PdfFonts::register($pdf->getDomPDF());

        // Stream the PDF to the browser. This will typically display it inline.
        return $pdf->stream('employee_' . $employee->employee_id . '_profile.pdf');
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
        $employee = Employee::with('devices', 'department', 'position', 'sim_card', 'project', 'clearance')->findOrFail($id);

        $clearanceResign = DB::transaction(function () use ($employee) {
            // Lock any existing pending/finished resignation clearance for this employee so a
            // double-click or two simultaneous requests can't both pass this check and each
            // create their own clearance + duplicated device/sim pivot rows.
            $existing = Clearance::where('employee_id', $employee->id)
                ->whereIn('status', ['pending_resign', 'resigned'])
                ->lockForUpdate()
                ->first();

            if ($existing) {
                return $existing;
            }

            $clearanceResign = Clearance::create([
                'employee_id' => $employee->id,
                'status' => 'pending_resign',
            ]);

            foreach ($employee->devices as $device) {
                DeviceAndSimClearance::create([
                    'clearance_id' => $clearanceResign->id,
                    'device_id' => $device->id,
                ]);
            }
            foreach ($employee->sim_card as $simCard) {
                DeviceAndSimClearance::create([
                    'clearance_id' => $clearanceResign->id,
                    'sim_card_id' => $simCard->id,
                ]);
            }

            return $clearanceResign;
        });

        return view('employees.resign', compact('employee', 'clearanceResign'));
    }

    public function finishResign($id, $clr, Request $request)
    {
        $request->validate([
            'signature' => 'required|mimes:png,jpg,jpeg,webp,pdf|max:2048',
        ]);
        $employee = Employee::with('devices', 'sim_card')->findOrFail($id);
        $finalClearance = Clearance::findOrFail($clr);

        if ((int) $finalClearance->employee_id !== (int) $employee->id) {
            abort(403, 'This clearance does not belong to this employee.');
        }

        if (!$request->hasFile('signature')) {
            return back()->with('error', 'A signature file is required to finish this resignation.');
        }

        DB::transaction(function () use ($request, $employee, $finalClearance) {
            $signature = $request->file('signature');
            $signatureName = \Illuminate\Support\Str::uuid() . '.' . $signature->getClientOriginalExtension();
            $signature->move(public_path('X-Files/Dash/imgs/clearance'), $signatureName);
            $finalClearance->update([
                'clear_image' => $signatureName,
                'status' => 'resigned',
            ]);

            $employee->update([
                'resign_date' => now(),
                'project_id' => null,
                'type' => 'resigned',
            ]);
            // Only frees devices/sims tied to the employee directly (employee_id).
            // Devices/sims parked against a project (project_id, no employee_id) are
            // shared project assets, not this person's individually - see the
            // project-manager check below for the one case where that matters here.
            $employee->devices()->update([
                'status' => 'available',
                'employee_id' => null,
                'project_id' => null,
                'receive_id' => null,
            ]);
            $employee->sim_card()->update([
                'employee_id' => null,
                'project_id' => null,
                'status' => 'available',
            ]);
        });

        $managedProjects = Project::where('manager_id', $employee->id)->pluck('project_name');
        if ($managedProjects->isNotEmpty()) {
            return to_route('employees.index')->with(
                'error',
                'Resignation completed, but this employee manages ' . $managedProjects->count() .
                ' project(s) (' . $managedProjects->implode(', ') . ') with their own assigned equipment. ' .
                'That equipment was NOT released automatically - reassign the project manager and its devices separately.'
            );
        }

        return to_route('employees.index')->with('success', 'Resignation completed.');
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
            $imageName = \Illuminate\Support\Str::uuid() . '.' . $image->getClientOriginalExtension();

            if ($image->move(public_path('X-Files/Dash/imgs/EmployeeProfilePic'), $imageName)) {
                $employee->update(['profile_image' => $imageName]);
            }
        }

        return to_route('employees.index', [
            'page' => $request->input('return_page'),
            'positionFilter' => $request->input('return_filter')
        ])->with('success', 'Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * Deleting an employee cascades in the database: receives.employee_id is
     * ON DELETE CASCADE, so their whole receiving history would be destroyed
     * along with them, and any device/sim still assigned to them would be
     * orphaned (owner FK nulled, but status left as "taken"). Rather than try
     * to work around the cascade in code, refuse the delete until the
     * employee has no assigned assets and no receiving history - point staff
     * at the resignation flow instead, since that's what actually produces a
     * clean clearance record.
     */
    public function destroy(Employee $employee)
    {
        $hasAssets = $employee->devices()->count() > 0 || $employee->sim_card()->count() > 0;
        $hasHistory = $employee->receives()->count() > 0;

        if ($hasAssets || $hasHistory) {
            return back()->with('error', 'This employee still has assigned equipment or receiving history on record. Process their resignation/clearance first, then delete.');
        }

        $employee->delete();
        return to_route('employees.index')->with('success', 'Employee deleted successfully');
    }

    /**
     * Search employees by code or name
     */
    public function search(Request $request)
    {
        $search = $request->get('search');

        return Employee::where('employee_id', 'like', "%{$search}%")
            ->orWhere('name', 'like', "%{$search}%")
            ->select('id', 'name', 'employee_id as employee_code')
            ->limit(10)
            ->get();
    }
}
