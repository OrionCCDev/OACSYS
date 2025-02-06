<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ClientManage extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    #[Rule('required|min:2|string')]
    public $client_name;
    #[Rule('image|mimes:png,jpg,jpeg,svg,gif|max:2048')]
    public $client_image;

    public $search = '';
    protected $messages = [
        'client_name.required' => 'Client name is required for new clients',
        'client_image.required' => 'Client image is required when editing',
    ];
    public $edtId;
    public $edtName;
    public $edtableImage;
    public $editImage = false;

    protected $rules = [
        'client_name' => 'required|min:2|unique:clients,name',
        'client_image' => 'image|mimes:png,jpg,jpeg,svg'
    ];

    public function addNewclient()
    {
        $this->validateOnly('client_name');
        $client = Client::create(['name' => $this->client_name]);
        if ($this->client_image) {
            // dd($this->client_image);
            $imageName = time() . '.' . $this->client_image->extension();
            // $destinationPath = public_path('X-Files/Dash/imgs/clients/' . $imageName);
            $this->client_image->storeAs('/clients', $imageName , 'public_uploads');
            $client->update(['image' => $imageName]);
        }
        $this->reset(['client_name', 'client_image']);
        $this->resetPage();
        $this->dispatch('showToast');
    }

    public function render()
    {
        return view('livewire.client-manage', [
            'data' => Client::where('name', 'like', '%' . $this->search . '%')
                ->paginate(10)
        ]);
    }

    public function del($id)
    {
        $client = Client::findOrFail($id);
        if ($client->image) {
            unlink(public_path('X-Files/Dash/imgs/clients/' . $client->image));

        }
        $client->delete();

        // Maintain the current page after deletion
        $this->dispatch('clientDeleted');
    }

    public function edtImg(Client $client)
    {
        $this->edtId = $client->id;
        $this->editImage = true;
    }

    public function edt(Client $client)
    {
        $this->edtId = $client->id;
        $this->edtName = $client->name;
    }

    public function cancel()
    {
        $this->reset(['edtId' , 'edtName' , 'editImage']);
    }

    public function update(Client $client)
    {
        $this->validateOnly('edtName', [
            'edtName' => 'required|min:2|unique:clients,name,'.$client->id
        ]);
        $client->update([
            'name' => $this->edtName
        ]);

        $this->reset(['edtId' , 'edtName']);

        $this->dispatch('showToastOfUpdate');
    }

    public function updateImage(Client $client)
    {
        $editableImageNew = $this->validateOnly('edtableImage', [
            'edtableImage' => 'required|image|mimes:png,jpg,jpeg,svg'
        ]);

        if ($this->edtableImage) {
            // Delete old image if exists $editableImageNew
            if ($client->image) {
                // Storage::delete('public/X-Files/Dash/imgs/clients/' . $client->image);
                unlink(public_path('X-Files/Dash/imgs/clients/' . $client->image));
            }

            $imageName = time() . '.' . $this->edtableImage->extension();
            $this->edtableImage->storeAs('/clients', $imageName , 'public_uploads');
            $client->update(['image' => $imageName]);
        }

        $this->reset(['edtId', 'edtName', 'edtableImage', 'editImage']);

        $this->dispatch('showToastOfUpdate');
    }
}
