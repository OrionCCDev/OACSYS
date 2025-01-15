<div>
    <div class="form-group">
        <label for="images">Device Images</label>
        <br>
        <input type="file"
               wire:model="device_gallary"
               name="device_gallary[]"
               multiple
               class="form-control"
               accept="image/*">

        <div wire:loading wire:target="device_gallary">
            <span class="text-muted">Uploading...</span>
        </div>

        <div class="d-flex flex-wrap gap-3 mt-3">
            @if($device_gallary)
                @foreach($device_gallary as $index => $image)
                    <div class="position-relative">
                        <img src="{{ $image->temporaryUrl() }}"
                             class="img-thumbnail"
                             style="width: 150px; height: 150px; object-fit: cover;">
                        <button type="button"
                                wire:click="removeImage({{ $index }})"
                                class="btn btn-danger btn-sm position-absolute"
                                style="top: 5px; right: 5px;">
                            ×
                        </button>
                    </div>
                @endforeach
            @endif
        </div>

        @error('device_gallary.*')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>
</div>
