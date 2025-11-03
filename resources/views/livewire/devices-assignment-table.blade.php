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
                            <th style="width: 50px; text-align: center;">Select</th>
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
                            <td class="text-center align-top" style="padding-top: 12px;">
                                <input type="checkbox"
                                    wire:model.live="selectedDevices"
                                    value="{{ $device->id }}"
                                    class="device-checkbox">
                            </td>
                            <td class="align-top" style="padding-top: 8px;">
                                <img src="{{ asset('X-Files/Dash/imgs/devices/' . $device->main_image) }}" alt="" width="75" height="75">
                            </td>
                            <td class="align-top" style="padding-top: 12px;">{{ $device->device_code }}</td>
                            <td class="align-top" style="padding-top: 12px;">{{ $device->device_name }}</td>
                            <td class="align-top" style="padding-top: 12px;">{{ $device->device_type }}</td>
                            {{-- <td class="align-top" style="padding-top: 12px;">{{ $device->status }}</td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- {{ $devices->links() }} --}}

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

<style>
    /* Ensure checkboxes are properly sized and visible */
    .device-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
        margin: 0;
    }
    
    /* Prevent any layout issues with table responsiveness */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
</style>
