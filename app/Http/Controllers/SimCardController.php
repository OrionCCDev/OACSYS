<?php

namespace App\Http\Controllers;

use App\Models\SimCard;
use Illuminate\Http\Request;
use App\Imports\SimCardImport;
use Maatwebsite\Excel\Facades\Excel;
class SimCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    // public function import(Request $request)
    // {
    //     $file = $request->file('excel_file');
    //     Excel::import(new SimCardImport, $file);

    //     return redirect()->back()->with('success', 'SimCards updated successfully');
    // }
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
    public function show(SimCard $simCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SimCard $simCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SimCard $simCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SimCard $simCard)
    {
        //
    }
}
