<div class="card">
    <div class="card-header">
        <h5 class="card-title">Create Deduction for {{ $employee->name }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-5">
            <div class="col-md-6">
                <p><strong>Employee ID:</strong> {{ $employee->employee_id }}</p>
                <p><strong>Department:</strong> {{ $employee->department->name }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Name:</strong> {{ $employee->name }}</p>
                <p><strong>Position:</strong> {{ $employee->position->name }}</p>
            </div>
        </div>

        <form wire:submit="saveDeduction">
            <div class="form-group mb-5">
                <label>Device/Asset</label>
                <select wire:model.live="selectedDevice" class="form-control">
                    <option value="">Not Device Issue</option>
                    @foreach($assignedDevices as $device)
                        <option value="{{ $device->id }}">{{ $device->device_name }} - ({{ $device->device_type }}) - {{ $device->device_code }}</option>
                    @endforeach
                </select>
                @error('selectedDevice') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            @if($selectedDevice)
                <div class="card mb-5">
                    <div class="card-body">
                        <h6>Device Properties</h6>
                        @php $device = $assignedDevices->where('id', $selectedDevice)->first() @endphp
                        @if($device)
                            <p><strong>Name:</strong> {{ $device->device_name }}</p>
                            <p><strong>Type:</strong> {{ $device->device_type }}</p>
                            <p><strong>Code:</strong> {{ $device->device_code }}</p>
                            <p><strong>Specifications:</strong> {{ $device->specifications }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <div class="form-group mb-5">
                <label>Reason for Deduction</label>
                <select wire:model.live="reason" class="form-control">
                    <option value="">Select Reason</option>
                    <option value="misuse">Misuse</option>
                    <option value="lost">Lost</option>

                    <option value="other">Other</option>
                </select>
                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-5">
                <label>Amount</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" wire:model.live="amount" class="form-control" step="0.01" min="0">
                </div>
                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <label>Description</label>
                <textarea wire:model.live="description" class="form-control" rows="4"></textarea>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Preview Section -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6>Deduction Report Preview</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img class="img-fluid invoice-brand-img d-block mb-20" width="250"
                                    src="{{ asset('X-Files/Dash/imgs/logo-blue.webp') }}" alt="brand">
                    </div>
                    <div class="text-center mb-5">
                        <h2>EMPLOYEE DEDUCTION NOTICE</h2>
                        <p>Date: {{ date('Y-m-d') }}</p>
                    </div>

                    <div class="row mb-5">
                        <div class="col-12 mb-3">
                            <h3><strong>Employee Information:</strong></h3>
                            <div class="row">
                                <div class="col-6">
                                    <h4 style="color: red">Name: {{ $employee->name }}</h4>
                                    <h4 style="color: red">ID: {{ $employee->employee_id }}</h4>
                                </div>
                                <div class="col-6">
                                    <h4>Department: {{ $employee->department?->name }}</h4>
                                    <h4>Position: {{ $employee->position?->name }}</h4>
                                </div>
                            </div>


                        </div>
                        @if($selectedDevice && $device = $assignedDevices->where('id', $selectedDevice)->first())
                        <div class="col-12 mb-3">
                            <h3><strong>Device Information:</strong></h3>
                            <h5>Name: {{ $device->device_name }}</h5>
                            <h5>Type: {{ $device->device_type }}</h5>
                            <h5>Code: {{ $device->device_code }}</h5>
                        </div>
                        @endif
                    </div>

                    <div class="mb-5">
                        <h3 class="my-2"><strong>Deduction Details:</strong></h3>
                        <h4>Reason: {{ ucfirst($reason ?: '-') }}</h4>
                        <h4 style="color: red">Amount: {{ number_format($amount ?: 0, 2) }} AED</h4>
                        <h4 class="my-3">Description: {!! nl2br(e($description ?: '-')) !!}</h4>
                    </div>

                    <div class="row mt-5" style="margin: 30px 5px 20px 5px">
                        <div class="col-4 text-center">
                            <p>_______________________</p>
                            <p>IT Manager</p>
                        </div>
                        <div class="col-4 text-center">
                            <p>_______________________</p>
                            <p>HR Signature</p>
                        </div>
                        <div class="col-4 text-center">
                            <p>_______________________</p>
                            <p>Top Management Signature</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Save Deduction</button>

                <a type="button" href="{{ url()->previous() }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
