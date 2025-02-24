<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Deduction;
use Illuminate\Http\Request;

class DeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function showDeductionReport($id)
    {
        $deduction = Deduction::with('employee.devices','employee.department','employee.position','device')->findOrFail($id);

        return view('deductions.deduction_report' , compact('deduction'));
    }

    public function uploadSignedDeduction(Request $request , $id)
    {
        $request->validate([
            'signed_deduction' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $deduction = Deduction::findOrFail($id);
            // Remove old image if exists
        if ($deduction->image) {
            $oldImagePath = public_path('X-Files/Dash/imgs/deductions/' . $deduction->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        $imageName = time() . '.' . $request->signed_deduction->extension();
        $destinationPath = public_path('X-Files/Dash/imgs/deductions');
        $request->signed_deduction->move($destinationPath, $imageName);
        $deduction->image = $imageName;
        $deduction->save();
        return redirect()->route('deduction.showEmployeeDeduction' , $deduction->employee_id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    public function createNewDeduct($id)
    {
        $employee = Employee::with('devices' , 'department' , 'position' , 'deductions' , 'sim_card')->findOrFail($id);
        return view('deductions.create' , compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function showEmployeeDeductions($id)
    {

        $employee = Employee::with('deductions')->findOrFail($id);
        // if ($employee->deductions->isEmpty()) {
        //     // Handle empty case
        //     return view('deductions.employee_deductions', [
        //         'employee' => $employee,
        //         'message' => 'No deductions found for this employee'
        //     ]);
        // }
        return view('deductions.employee_deductions', ['employee' => $employee]);
    }



    /**
     * Display the specified resource.
     */
    public function show(Deduction $deduction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deduction $deduction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deduction $deduction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deduction $deduction)
    {
        $deduction->delete();
        if ($deduction->image) {
            $oldImagePath = public_path('X-Files/Dash/imgs/deductions/' . $deduction->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        return redirect()->back()->with('success', 'Deduction deleted successfully');
    }
}
