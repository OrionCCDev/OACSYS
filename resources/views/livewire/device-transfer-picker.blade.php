<div>
    <form wire:submit="submit">
        <div class="row">
            <!-- From Employee -->
            <div class="col-md-6">
                <div class="card p-3 mb-3">
                    <h6 class="mb-3">From (releasing employee)</h6>

                    @if($fromEmployeeId)
                        <div class="alert alert-warning d-flex justify-content-between align-items-center mb-0">
                            <span>{{ $fromSearch }}</span>
                            <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="clearFrom">Change</button>
                        </div>
                    @else
                        <input type="text" class="form-control @error('fromEmployeeId') is-invalid @enderror"
                               wire:model.live="fromSearch" placeholder="Search by employee ID or name...">
                        @error('fromEmployeeId')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        @if(strlen($fromSearch) >= 2)
                            <div class="list-group mt-2">
                                @forelse($this->fromResults as $employee)
                                    <button type="button" class="list-group-item list-group-item-action"
                                            wire:click="selectFromEmployee({{ $employee->id }})">
                                        <strong>{{ $employee->employee_id }}</strong> - {{ $employee->name }}
                                    </button>
                                @empty
                                    <div class="list-group-item">No employees found</div>
                                @endforelse
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- To Employee -->
            <div class="col-md-6">
                <div class="card p-3 mb-3">
                    <h6 class="mb-3">To (receiving employee)</h6>

                    @if($toEmployeeId)
                        <div class="alert alert-success d-flex justify-content-between align-items-center mb-0">
                            <span>{{ $toSearch }}</span>
                            <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="clearTo">Change</button>
                        </div>
                    @else
                        <input type="text" class="form-control @error('toEmployeeId') is-invalid @enderror"
                               wire:model.live="toSearch" placeholder="Search by employee ID or name...">
                        @error('toEmployeeId')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        @if(strlen($toSearch) >= 2)
                            <div class="list-group mt-2">
                                @forelse($this->toResults as $employee)
                                    <button type="button" class="list-group-item list-group-item-action"
                                            wire:click="selectToEmployee({{ $employee->id }})">
                                        <strong>{{ $employee->employee_id }}</strong> - {{ $employee->name }}
                                    </button>
                                @empty
                                    <div class="list-group-item">No employees found</div>
                                @endforelse
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        @if($fromEmployeeId)
        <div class="card p-3 mb-3">
            <h6 class="mb-3">Devices held by {{ $fromSearch }}</h6>
            @error('selectedDevices')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-sm table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">Select</th>
                            <th>Device Name</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->fromDevices as $device)
                        <tr>
                            <td>
                                <input type="checkbox" wire:model="selectedDevices" value="{{ $device->id }}" class="form-check-input">
                            </td>
                            <td>{{ $device->device_name }}</td>
                            <td>{{ $device->device_code }}</td>
                            <td>{{ $device->device_type }}</td>
                            <td>
                                <input type="text" wire:model="deviceNotes.{{ $device->id }}" class="form-control form-control-sm" placeholder="Optional note">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">This employee has no devices to transfer</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($fromEmployeeId && $toEmployeeId)
        <div class="text-right">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-exchange"></i> Create Transfer
            </button>
        </div>
        @endif
    </form>
</div>
