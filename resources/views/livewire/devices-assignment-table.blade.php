<div>
    <div class="card">
        <div class="card-header">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Search</span>
                </div>
                <input type="text" wire:model.live="search" class="form-control" placeholder="Search by name or code">
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>$</th>
                            <th>img</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Type</th>
                            {{-- <th>Status</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($devices as $device)
                        <tr>
                            <td>
                                <input type="checkbox"
                                    wire:model.live="selectedDevices"
                                    value="{{ $device->id }}">
                            </td>
                            <td> <img src="{{ asset('X-Files/Dash/dist/imgs/devices' . $device->main_image) }}" alt="" srcset="" width="75" height="75"></td>
                            <td>{{ $device->device_code }}</td>
                            <td>{{ $device->device_name }}</td>
                            <td>{{ $device->device_type }}</td>
                            {{-- <td>{{ $device->status }}</td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $devices->links() }}

            <div class="mt-3">
                <button wire:click="assignSelected"
                    class="btn btn-primary"
                    @if(empty($selectedDevices)) disabled @endif>
                    Assign Selected
                </button>
                <button wire:click="cancelSelection"
                    class="btn btn-secondary"
                    @if(empty($selectedDevices)) disabled @endif>
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
