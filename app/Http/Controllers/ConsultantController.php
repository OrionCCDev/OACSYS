<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Consultant;
use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consultants = Consultant::with('project','devices','sim_card')->paginate(10);
        return view('consultant.all',compact('consultants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allProjects = Project::all('id','project_name','project_code');
        return view('consultant.add',compact('allProjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validate the request data
         $validatedData = $request->validate([
            'consultant_name' => 'required|string|max:255',
            'consultant_project_id' => 'nullable|exists:projects,id',
            'consultant_company' => 'required|string|max:255',
            'consultant_email' => 'nullable|email|max:255|unique:consultants,email',
            'consultant_mobile' => 'nullable|string|max:15',
            'consultant_position' => 'nullable|string|max:255',
        ]);

        // Create a new consultant
        Consultant::create([
            'name' => $validatedData['consultant_name'],
            'company_name' => $validatedData['consultant_company'],
            'email' => $validatedData['consultant_email'],
            'mobile' => $validatedData['consultant_mobile'],
            'position' => $validatedData['consultant_position'],
            'project_id' => $validatedData['consultant_project_id'],
        ]);

        // Redirect to the consultant index page with a success message
        return redirect()->route('consultant.index')->with('success', 'Consultant added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultant $consultant)
    {
        return view('consultant.show', compact('consultant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultant $consultant)
    {
        $allProjects = Project::all();
        return view('consultant.edit', compact('consultant', 'allProjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consultant $consultant)
    {
         // Validate the request data
         $validatedData = $request->validate([
            'consultant_name' => 'required|string|max:255',
            'consultant_company' => 'nullable|string|max:255',
            'consultant_email' => 'nullable|email|max:255|unique:consultants,email,' . $consultant->id,
            'consultant_mobile' => 'nullable|string|max:15',
            'consultant_position' => 'nullable|string|max:255',
            'consultant_project_id' => 'nullable|exists:projects,id',
        ]);

        // Update the consultant
        $consultant->update([
            'name' => $validatedData['consultant_name'],
            'company_name' => $validatedData['consultant_company'],
            'email' => $validatedData['consultant_email'],
            'mobile' => $validatedData['consultant_mobile'],
            'position' => $validatedData['consultant_position'],
            'project_id' => $validatedData['consultant_project_id'],
        ]);

        // Redirect to the consultant index page with a success message
        return redirect()->route('consultant.index')->with('success', 'Consultant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultant $consultant)
    {
        $consultant->delete();
        return redirect()->route('consultant.index')->with('success', 'Consultant deleted successfully.');
    }
}
