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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultant $consultant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultant $consultant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consultant $consultant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultant $consultant)
    {
        //
    }
}
