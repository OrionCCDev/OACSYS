<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="row">
        <div class="col-sm">
            <div class="card-body">
                <form wire:submit="assignDevice">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="search">Search Employee by Code</label>
                                <input type="text"
                                       class="form-control @error('employee') is-invalid @enderror"
                                       wire:model.live="search"
                                       placeholder="Enter employee code...">
                                @error('employee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if(strlen($search) >= 2)
                                <div class="mt-3">
                                    <div class="list-group">
                                        @forelse($employees as $employee)
                                            <button type="button"
                                                    class="list-group-item list-group-item-action {{ $selectedEmployee == $employee->id ? 'active' : '' }}"
                                                    wire:click="selectEmployee({{ $employee->id }})">
                                                <strong>{{ $employee->employee_id }}</strong> - {{ $employee->name }}
                                            </button>
                                        @empty
                                            <div class="list-group-item">No employees found</div>
                                        @endforelse
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">Assign Device</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
