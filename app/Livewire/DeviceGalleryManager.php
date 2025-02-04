<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DeviceGalleryManager extends Component
{
    public $device;

    public function mount($device)
    {
        $this->device = $device;
    }

    public function deleteImage($imageId)
    {
        $image = Media::find($imageId);
        if ($image) {
            $image->delete();
            // Refresh the device's media collection
            $this->device->refresh();
        }
    }

    public function render()
    {
        return view('livewire.device-gallery-manager', [
            'images' => $this->device->getMedia('Device_image'),
        ]);
    }
}
