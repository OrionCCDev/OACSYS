<div>
    <div class="row">
        @foreach($device->media as $image)
            <div class="col-md-3 mb-4">
                <div class="position-relative">
                    <img src="{{ asset($image->getUrl()) }}" class="img-fluid rounded" alt="Device image">
                    <button wire:click="deleteImage({{ $image->id }})"
                            class="btn btn-danger btn-sm position-absolute"
                            style="top: 10px; right: 10px;">
                        <i class="zmdi zmdi-delete"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
