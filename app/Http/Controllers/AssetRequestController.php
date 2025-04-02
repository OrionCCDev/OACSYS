<?php

namespace App\Http\Controllers;

use App\Models\RequestItem;
use App\Models\AssetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssetRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasRole(['o-admin', 'o-super-admin'])) {
            return redirect()->back()->with('error', 'You are not authorized to approve requests');
        }
        $requests = AssetRequest::paginate(15);
        return view('request.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('request.create');

    }
    public function uploadSignature(Request $request , $id)
    {
        $requestAsset = AssetRequest::find($id);
        $request->validate([
            'signature' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $image = $request->file('signature');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('X-Files/Dash/imgs/request');
        $request->signature->move($destinationPath, $imageName);
        $requestAsset->image = $imageName;
        $requestAsset->status = 'pending-receive';
        $requestAsset->save();
        return redirect()->route('asset-request.index')->with('success', 'Signature uploaded successfully.');
    }

    public function approve($id)
    {
        if (!auth()->user()->hasRole(['o-admin', 'o-super-admin'])) {
            return redirect()->back()->with('error', 'You are not authorized to approve requests');
        }
        $request = AssetRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();
        return redirect()->back()->with('success', 'Request approved successfully');

    }

    public function reject($id)
    {
        if (!auth()->user()->hasRole(['o-admin', 'o-super-admin'])) {
            return redirect()->back()->with('error', 'You are not authorized to approve requests');
        }
        $request = AssetRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        return redirect()->back()->with('success', 'Request has been rejected successfully');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requests = $request->input('requests', []);
        $employee_id = Auth::user()->employee->id;
        $main_request = AssetRequest::create([
            'employee_id' => $employee_id,
            'request_code' => $request->request_code,
            'status' => 'pending',
            'is_read' => false,
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
                'quantity' => $requestData['quantity'] ?? 1,
                'notes' => $requestData['notes'],
            ]);


        }

        if(Auth::user()->orion_role_lvl == 'o-manager'){
            return redirect()->route('manager.show' , ['manager' => $employee_id])->with('success', 'Requests created successfully!');
        }else{
            return redirect()->route('asset-request.index')->with('success', 'Requests created successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $request = AssetRequest::with(['employee.position', 'employee.department', 'items'])->findOrFail($id);
        $request->update(['is_read' => true]);
        return view('request.show', compact('request'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $request = AssetRequest::findOrFail($id);

        if (!in_array($request->status, ['pending', 'pending-receive']) &&
            !auth()->user()->hasRole(['o-admin', 'o-super-admin'])) {
            return redirect()->back()->with('error', 'You are not authorized to edit this request');
        }

        return view('request.edit', compact('request'));
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
    // public function destroy(string $id)
    // {

    //     $request = AssetRequest::find($id);
    //     $request->items()->delete();
    //     if($request->image != null){
    //         $oldImagePath = public_path('X-Files/Dash/imgs/request/' . $request->image);
    //         if (file_exists($oldImagePath)) {
    //             unlink($oldImagePath);
    //         }
    //     }
    //     $request->delete();
    //     return redirect()->route('asset-request.index')->with('success', 'Request deleted successfully!');
    // }
    public static function getUnreadRequestsCount()
    {
        return AssetRequest::where('is_read', false)->count();
    }
    public static function getPendingRequestsCount()
    {
        return AssetRequest::whereIn('status', ['pending', 'pending-approve', 'pending-receive'])->count();
    }

    public function destroy($id)
    {
        $request = AssetRequest::findOrFail($id);

        if (!in_array($request->status, ['pending', 'pending-receive']) &&
            !auth()->user()->hasRole(['o-admin', 'o-super-admin'])) {
            return redirect()->back()->with('error', 'You are not authorized to delete this request');
        }

        $request->items()->delete();
        if($request->image != null){
            $oldImagePath = public_path('X-Files/Dash/imgs/request/' . $request->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        $request->delete();
        return redirect()->route('asset-request.index')->with('success', 'Request deleted successfully');
    }
}
