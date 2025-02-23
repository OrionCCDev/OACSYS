<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Models\RequestItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request as GlobalRequestInputs;




class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = Request::paginate(15);
        return view('request.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('request.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GlobalRequestInputs $request)
    {
        $requests = $request->input('requests', []);
        $employee_id = Auth::user()->employee->id;
        $main_request = Request::create([
            'employee_id' => $employee_id,
            'request_code' => $request->request_code,
            'status' => 'pending',
        ]);

        foreach ($requests as $requestData) {
            // Validate each request
            $validator = Validator::make($requestData, [
                'item_type' => 'required|string',
                'request_for_type' => 'required|string',
                'requested_for_id' => 'nullable|string',
                'quantity' => 'nullable|numeric|min:1',
                'requested_for_name' => 'nullable|string',
                'requested_for_position' => 'nullable|string',
                'notes' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $request_item = RequestItem::create([
                'request_id' => $main_request->id,
                'item_type' => $requestData['item_type'],
                'request_for_type' => $requestData['request_for_type'],
                'requested_for_id' => $requestData['requested_for_id'],
                'requested_for_name' => $requestData['requested_for_name'],
                'requested_for_position' => $requestData['requested_for_position'],
                'quantity' => $requestData['quantity'],
                'notes' => $requestData['notes'],
            ]);


        }

        return redirect()->route('request.index')->with('success', 'Requests created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(GlobalRequestInputs $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GlobalRequestInputs $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GlobalRequestInputs $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GlobalRequestInputs $request)
    {
        //
    }
}
