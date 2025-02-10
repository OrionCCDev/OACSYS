{{-- <div class="col-8 my-5">
    <div class="row">
        <div class="col-12 col-md-6 form-group">
            <h6 class="" for="AddNewEmployeeOrionEmail">Department
            </h6>
            <div class="input-group mb-2 w-100">
                <select wire:model.live="selectedDepartment" id="department" name="department_id"
                    class="form-control custom-select form-control custom-select-lg mt-15">

                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="col-12 col-md-6 form-group">
            <h6 class="" for="AddNewEmployeeOrionEmail">Position
            </h6>
            <div class="input-group mb-2 w-100">

                <select wire:model="selectedPosition" name="position_id" id="position"
                    class="form-control custom-select form-control custom-select-lg mt-15"
                    @disabled($selectedDepartment==='' )>

                    <option value="">Select Position</option>
                    @foreach($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div> --}}
<div class="col-8 my-5">
    <div class="row">
        <div class="col-12 col-md-6 form-group">
            <h6 class="" for="AddNewEmployeeOrionEmail">Department</h6>
            <div class="input-group mb-2 w-100">
                <select wire:model.live="selectedDepartment" id="department" name="department_id"
                    class="form-control custom-select form-control custom-select-lg mt-15">
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                    <option value="{{ $department->id }}"
                        {{ $selectedDepartment == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-12 col-md-6 form-group">
            <h6 class="" for="AddNewEmployeeOrionEmail">Position</h6>
            <div class="input-group mb-2 w-100">
                <select wire:model="selectedPosition" name="position_id" id="position"
                    class="form-control custom-select form-control custom-select-lg mt-15"
                    @disabled($selectedDepartment==='' )>
                    <option value="">Select Position</option>
                    @foreach($positions as $position)
                    <option value="{{ $position->id }}" {{ $selectedPosition  == $position->id ? 'selected' : '' }}>
                        {{ $position->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
