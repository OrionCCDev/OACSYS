<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Device;
use App\Models\Project;
use App\Models\Receive;
use App\Models\SimCard;
use App\Models\Employee;
use App\Models\Clearance;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    // public static function middleware(): array
    // {
    //     return [
    //         'web',
    //         'auth',
    //         [
    //             'role:o-hr|o-super-admin|o-admin' => [
    //                 'only' => ['index','create','store','edit','update','destroy']
    //             ]
    //         ],
    //         [
    //             'role:o-hr|o-super-admin|o-admin|o-manager' => [
    //                 'only' => ['show']
    //             ]
    //         ]
    //     ];
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('manager.index');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id )
    {

        $user = auth()->user();
        $managerID = auth()->user()->employee_profile_id;
        $manager = Employee::with(['devices', 'department', 'position', 'project', 'sim_card', 'receives', 'clearance'])->find($managerID);
        $project = $manager->project;
        $hireDate = Carbon::parse($manager->hire_date)->format('Y,M');
        $now = $manager->resign_date ? Carbon::parse($manager->resign_date) : Carbon::now();
        $diff = Carbon::parse($manager->hire_date)->diff($now);
        // If user is not HR/admin/super-admin, they can only view their own profile
        if (!$user->hasRole(['o-hr', 'o-super-admin', 'o-admin','o-manager'])) {
            if ($user->id != $id) {
                abort(403, 'Unauthorized access');
                // Or you can redirect:
                // return redirect()->route('managers.show', $user->id)
                //     ->with('error', 'You can only view your own profile');
            }
        }

        return view('profile.manager', compact('manager' , 'hireDate', 'diff', 'project'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
