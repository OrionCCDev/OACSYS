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
    #[Rule('image|mimes:png,jpg,jpeg,svg')]
    public $client_image;

    public $search = '';

    public $edtId;
    public $edtName;
    public $edtableImage;
    public $editImage = false;

    protected $rules = [
        'client_name' => 'required|min:2|unique:clients,name',
        'client_image' => 'image|mimes:png,jpg,jpeg,svg'
    ];

    // Or use custom validation messages
    protected $messages = [
        'client_name.required' => 'client name is required for new clients',
        'client_image.required' => 'client name is required when editing'
    ];

    public function addNewclient()
    {
        $this->validateOnly('client_name');
        $client = Client::create(['name' => $this->client_name]);
        if ($this->client_image) {
            $imageName = time() . '.' . $this->client_image->extension();
            $this->client_image->move(public_path('X-Files/Dash/imgs/clinets'), $imageName);
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
        Client::find($id)->delete();
        $this->resetPage();
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
        $this->validateOnly('edtableImage', [
            'edtableImage' => 'required|image|mimes:png,jpg,jpeg,svg'
        ]);
        // // Clear existing media from collection first
        // $client->clearMediaCollection('client_images');

        // // Add new media to collection
        // $client->addMedia($this->edtableImage)
        //        ->toMediaCollection('client_images');
        if ($this->client_image) {
            // Delete old image if exists
            if ($client->image) {
                Storage::delete(public_path('X-Files/Dash/imgs/clinets/' . $client->image));
            }

            $imageName = time() . '.' . $this->client_image->extension();
            $this->client_image->move(public_path('X-Files/Dash/imgs/clinets'), $imageName);
            $client->update(['image' => $imageName]);
        }

        $this->reset(['edtId', 'edtName', 'edtableImage', 'editImage']);

        $this->dispatch('showToastOfUpdate');
    }
}
