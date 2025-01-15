<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class DeviceImageUpload extends Component
{
    use WithFileUploads;

    public $images = [];
    public $temporaryImages = [];
    public $device_gallary = [];
    public function updatedImages()
    {
        foreach ($this->images as $image) {
            $this->temporaryImages[] = [
                'url' => $image->temporaryUrl(),
                'name' => $image->getClientOriginalName()
            ];
        }
    }



    public function removeImage($index)
    {
        array_splice($this->device_gallary, $index, 1);
    }

    public function render()
    {
        return view('livewire.device-image-upload');
    }
}
