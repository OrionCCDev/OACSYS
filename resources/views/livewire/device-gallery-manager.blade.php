<div>
    <div class="row">
        @foreach( $images as $img )
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
