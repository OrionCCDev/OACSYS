<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Request;

class RequestList extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $selectedStatus = '';
    public $signature;
    public $showModal = false;
    public $currentRequest;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function updateStatus($requestId, $status)
    {
        $request = Request::find($requestId);
        $request->update(['status' => $status]);
        session()->flash('message', 'Status updated successfully.');
    }

    public function uploadSignature($requestId)
    {
        $this->validate([
            'signature' => 'required|image|max:1024',
        ]);

        $request = Request::find($requestId);
        $path = $this->signature->store('signatures', 'public');
        $request->update(['signature_path' => $path]);

        session()->flash('message', 'Signature uploaded successfully.');
        $this->signature = null;
    }

    public function deleteRequest($requestId)
    {
        $request = Request::find($requestId);
        $request->delete();
        session()->flash('message', 'Request deleted successfully.');
    }

    public function render()
    {
        return view('livewire.request-list', [
            'requests' => Request::with(['employee'])->paginate(10)
        ]);
    }
}
