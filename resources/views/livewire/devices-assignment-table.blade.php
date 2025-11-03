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
                            <th style="width: 50px; text-align: center; vertical-align: middle;">
                                <input type="checkbox" id="selectAll" style="width: 18px; height: 18px; cursor: pointer;">
                            </th>
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
                            <td style="text-align: center; vertical-align: top; padding-top: 15px;">
                                <input type="checkbox"
                                    wire:model.live="selectedDevices"
                                    value="{{ $device->id }}"
                                    style="width: 20px; height: 20px; cursor: pointer; margin: 0;">
                            </td>
                            <td style="vertical-align: top; padding-top: 10px;"> <img src="{{ asset('X-Files/Dash/imgs/devices/' . $device->main_image) }}" alt="" srcset="" width="75" height="75"></td>
                            <td style="vertical-align: top; padding-top: 15px;">{{ $device->device_code }}</td>
                            <td style="vertical-align: top; padding-top: 15px;">{{ $device->device_name }}</td>
                            <td style="vertical-align: top; padding-top: 15px;">{{ $device->device_type }}</td>
                            {{-- <td style="vertical-align: top; padding-top: 15px;">{{ $device->status }}</td> --}}
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
    /* Ensure checkboxes align with first line of text */
    .table tbody tr td {
        vertical-align: top !important;
    }
    
    /* Align checkbox to top of cell */
    .table tbody tr td:first-child {
        padding-top: 15px !important;
    }
    
    /* Ensure checkboxes are properly sized and visible */
    .table input[type="checkbox"] {
        width: 20px !important;
        height: 20px !important;
        cursor: pointer;
        margin: 0;
        vertical-align: top;
    }
</style>
