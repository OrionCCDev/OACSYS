
    <div class="container">
        <div class="row w-100 mt-2">
            <div class="col-12 col-md-6 form-group">
                <h6 class="" for="AddNewEmployeeDepartment">Orion Department</h6>
                <div class="input-group mb-2 w-100">
                    <select wire:model.live="selectedDepartment" name="employee_department" class="form-control custom-select form-control custom-select-lg mt-15">
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12 col-md-6 form-group">
                <h6 for="AddNewEmployeePosition">Orion Position</h6>
                <div class="input-group mb-2 w-100">
                    <select wire:model="selectedPosition" name="employee_position" @if(!$selectedDepartment) disabled @endif class="form-control custom-select form-control custom-select-lg mt-15">
                        @if(!$selectedDepartment)
                        <option value="">Select Position</option>
                        @endif
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

