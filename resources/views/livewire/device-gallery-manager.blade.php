<div>
    <div class="row">
        @foreach($device->getMedia('Device_image') as $img )
        {{-- @foreach ($images as $image)
        <div class="col-md-3">
            <div class="card">
                <img src="{{ $image->getUrl() }}" class="card-img-top" alt="Device Image">
                <div class="card-body">
                    <button wire:click="deleteImage({{ $image->id }})" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
        @endforeach --}}
            <div class="col-md-3 mb-4">
                <div class="position-relative">
                    <img src="{{ asset('media/' . $img->id . '/' . $img->file_name) }}" class="img-fluid rounded" alt="Device image">
                    <button wire:click="deleteImage({{ $img->id }})"
                            class="btn btn-danger btn-sm position-absolute"
                            style="top: 10px; right: 10px;">
                        <i class="zmdi zmdi-delete"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
