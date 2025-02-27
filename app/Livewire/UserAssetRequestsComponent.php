<?php

namespace App\Livewire;
use App\Models\AssetRequest;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class UserAssetRequestsComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $requests = AssetRequest::where('employee_id', Auth::user()->employee->id)
            ->latest()
            ->paginate(5);

        return view('livewire.user-asset-requests-component', [
            'requests' => $requests
        ]);
    }

    public function deleteRequest($id)
    {
        $request = AssetRequest::findOrFail($id);

        // Check if user is authorized to delete this request
        if (!in_array($request->status, ['pending', 'pending-receive'])) {
            session()->flash('error', 'You are not authorized to delete this request');
            return;
        }

        // Delete related items
        $request->items()->delete();

        // Delete image if exists
        if ($request->image != null) {
            $oldImagePath = public_path('X-Files/Dash/imgs/request/' . $request->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Delete the request
        $request->delete();

        session()->flash('success', 'Request deleted successfully');
        $this->redirect(request()->header('Referer'));
    }
}
