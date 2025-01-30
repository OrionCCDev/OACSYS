@extends('layouts.app')


@section('content')
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Employee Edit</h2>
                {{-- <p>Questions about onboarding lead data? <a href="#">Learn more.</a></p> --}}
            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title">Edit Data</h5>
                        <div class="row">
                            <div class="col-sm">
                                <div class="add-new-dev-img d-flex justify-content-center mb-2">
                                    <img id="image-preview" class="circle img-fluid img-thumbnail"
                                        style="object-fit: cover" width="250" height="250"
                                        src="{{ asset('X-Files/Dash/imgs/EmployeeProfilePic/' . $employee->profile_image) }}"
                                        alt="">
                                </div>
                                <form method="POST" enctype="multipart/form-data"
                                    action="{{ route('employees.update', $employee->id) }}" class="form-inline">
                                    @csrf
                                    @method('PUT')
                                    <div class="row w-100">
                                        {{-- ---------------- --}}
                                        {{-- employee Orion Image --}}
                                        {{-- ---------------- --}}
                                        <div class="col-12 form-group my-25">
                                            <label class="sr-only" for="AddNewEmployeeImage">Profile Image</label>
                                            <div class="fileinput fileinput-new input-group w-100"
                                                data-provides="fileinput">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="form-control text-truncate" data-trigger="fileinput"><i
                                                        class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                                        class="fileinput-filename"></span></div>
                                                <span class="input-group-append">
                                                    <span class=" btn btn-primary btn-file"><span
                                                            class="fileinput-new">Select file</span><span
                                                            class="fileinput-exists">Change</span>
                                                        {{-- ----------------- --}}
                                                        <input id="AddNewEmployeeImage" onchange="showPreview(event)"
                                                            type="file" name="employee_image">
                                                        {{-- ----------------- --}}
                                                    </span>
                                                    <a href="#" class="btn btn-secondary fileinput-exists"
                                                        data-dismiss="fileinput">Remove</a>
                                                </span>

                                            </div>
                                            @error('employee_image')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <script>
                                                function showPreview(event) {
                                                    if (event.target.files.length > 0) {
                                                        var src = URL.createObjectURL(event.target.files[0]);
                                                        var preview = document.getElementById("image-preview");
                                                        preview.src = src;
                                                        preview.style.display = "block";
                                                    }
                                                }
                                            </script>
                                        </div>
                                        {{-- ----------------------- --}}
                                        {{-- // END employee Orion Image --}}
                                        {{-- ----------------------- --}}
                                        {{-- ---------------- --}}
                                        {{-- employee CODE ID --}}
                                        {{-- ---------------- --}}
                                        <div class="col-6 form-group">
                                            <label class="sr-only" for="AddNewEmployeeCode">Orion ID</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Employee ID</div>
                                                </div>
                                                <input type="text" name="employee_code"
                                                    value="{{ $employee->employee_id }}" class="form-control"
                                                    id="AddNewEmployeeCode" placeholder="Employee Code">
                                            </div>
                                            @error('employee_code')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- ----------------------- --}}
                                        {{-- // END employee CODE ID --}}
                                        {{-- ----------------------- --}}
                                        {{-- ---------------- --}}
                                        {{-- employee Name --}}
                                        {{-- ---------------- --}}
                                        <div class="col-6 form-group">

                                            <label class="sr-only" for="AddNewEmployeeName">Name</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Employee Name</div>
                                                </div>
                                                <input type="text" name='employee_name' class="form-control"
                                                    id="AddNewEmployeeName" value="{{ $employee->name }}"
                                                    placeholder="Employee Name">
                                            </div>
                                            @error('employee_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- ----------------------- --}}
                                        {{-- // END employee Name --}}
                                        {{-- ----------------------- --}}

                                    </div>

                                    <div class="row w-100">
                                        {{-- ---------------- --}}
                                        {{-- employee Personal Email --}}
                                        {{-- ---------------- --}}
                                        <div class="col-6 form-group">

                                            <label class="sr-only" for="AddNewEmployeePersonalEmail">Personal
                                                Email</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Personal Email</div>
                                                </div>
                                                <input type="email" name='employee_personal_email' class="form-control"
                                                    id="AddNewEmployeePersonalEmail"
                                                    value="{{ $employee->personal_email }}"
                                                    placeholder="Personal Email">
                                            </div>
                                            @error('employee_personal_email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- ----------------------- --}}
                                        {{-- // END employee Personal Email --}}
                                        {{-- ----------------------- --}}

                                        {{-- ---------------- --}}
                                        {{-- employee Personal Mobile --}}
                                        {{-- ---------------- --}}
                                        <div class="col-6 form-group">
                                            <label class="sr-only" for="AddNewEmployeePersonalMobile">Personal
                                                Mobile</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Personal Mobile</div>
                                                </div>
                                                <input type="text" name='employee_personal_mobile' class="form-control"
                                                    id="AddNewEmployeePersonalMobile"
                                                    value="{{ $employee->personal_mobile }}"
                                                    placeholder="Personal Mobile">
                                            </div>
                                            @error('employee_personal_mobile')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- ----------------------- --}}
                                        {{-- // END employee Personal Mobile --}}
                                        {{-- ----------------------- --}}
                                    </div>

                                    <div class="row w-100">
                                        {{-- -------------------- --}}
                                        {{-- employee Orion Email --}}
                                        {{-- -------------------- --}}
                                        <div class="col-6 form-group">
                                            <label class="sr-only" for="AddNewEmployeeOrionEmail">Orion
                                                Email</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Orion Email</div>
                                                </div>
                                                <input type="email" name='employee_orion_email' class="form-control"
                                                    id="AddNewEmployeeOrionEmail" value="{{ $employee->orion_email }}"
                                                    placeholder="Orion Email">
                                            </div>
                                            @error('employee_orion_email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- ----------------------- --}}
                                        {{-- // END employee Orion Email --}}
                                        {{-- ----------------------- --}}
                                        <div class="col-6 form-group">
                                            @php
                                                $hireDate = $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('Y-m-d') : now()->format('Y-m-d');
                                            @endphp

                                            <label class="sr-only" for="AddNewEmployeeHireDate">Hire Date</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Hire Date</div>
                                                </div>
                                                <input type="date" name="hire_date" value="{{ $employee->hire_date }}" class="form-control"
                                                    id="AddNewEmployeeHireDate" placeholder="Hire Date">
                                            </div>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var hireDateInput = document.getElementById('AddNewEmployeeHireDate');
                                                    var hireDate = "{{ $hireDate }}";
                                                    hireDateInput.value = hireDate;
                                                });
                                            </script>
                                            @error('hire_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- ----------------------- --}}
                                        {{-- // END employee Orion Email --}}
                                        {{-- ----------------------- --}}


                                    </div>

                                    <div class="row w-100">
                                        <div class="col-12 col-md-4 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Employee
                                                Level</h6>
                                            <div class="input-group mb-2 w-100">
                                                <select name="type"
                                                    class="form-control  custom-select form-control custom-select-lg mt-15">
                                                    <option value="employee" {{ $employee->type == 'employee' ?
                                                        'selected' : '' }} >Employee</option>
                                                    <option value="labor" {{ $employee->type == 'labor' ? 'selected' :
                                                        '' }}>Laber</option>
                                                    <option value="manager" {{ $employee->type == 'manager' ? 'selected'
                                                        : '' }}>Manager</option>
                                                    <option value="owner" {{ $employee->type == 'owner' ? 'selected' :
                                                        '' }}>Owner</option>
                                                </select>
                                            </div>
                                            @error('type')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @livewire('department-position-select')
                                    </div>
                                    <br>
                                    <hr>
                                    <br>
                                    <hr>





                                    <div class="row w-100 mt-2">
                                        {{-- ---------------- --}}
                                        {{-- employee Orion Email --}}
                                        {{-- ---------------- --}}
                                        <div class="col-12 col-md-6 form-group">

                                            <h6 class="" for="AddNewEmployeeOrionEmail">Project
                                            </h6>
                                            <div class="input-group mb-2 w-100">
                                                <select name="employee_project"
                                                    class="form-control custom-select form-control custom-select-lg mt-15">
                                                    <option {{ $employee->project_id == null ? 'selected' : '' }}
                                                        value="">No Project</option>
                                                    @foreach ($projects as $project )
                                                    <option {{ $employee->project_id == $project->id ? 'selected' : ''
                                                        }} value="{{ $project->id }}">{{ $project->project_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('employee_project')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- ----------------------- --}}
                                        {{-- // END employee Orion Email --}}
                                        {{-- ----------------------- --}}
                                        {{-- ---------------- --}}
                                        {{-- employee Orion Email --}}
                                        {{-- ---------------- --}}
                                        <div class="col-12 col-md-6 form-group">
                                            <h6 class="" for="AddNewEmployeeOrionEmail">
                                                Direct Manager</h6>
                                            <div class="input-group mb-2 w-100">
                                                <select name="employee_manager"
                                                    class="form-control custom-select form-control custom-select-lg mt-15">
                                                    <option value="" {{ $employee->manager_id == null ? 'selected' : ''
                                                        }}>No Manager</option>
                                                    @foreach ( $managers as $manager )
                                                    <option {{ $employee->manager_id == $manager->id ? 'selected' : ''
                                                        }} value="{{ $manager->id }}">{{ $manager->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- ----------------------- --}}
                                        {{-- // END employee Orion Email --}}
                                        {{-- ----------------------- --}}
                                    </div>
                                    <div class="row w-100 mt-2 mx-10">
                                        <h6 class="" for="AddNewEmployeeOrionEmail">
                                            Notes</h6>
                                        <textarea name="notes" class="form-control mt-15 w-100 " rows="11"
                                            placeholder="Employee Notes">{{ $employee->notes }}</textarea>
                                    </div>
                                    <br>
                                    <div class="row mt-30">
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary mb-2">Save</button>
                                            <a href="{{ url()->previous() }}" type="button" class="btn btn-danger mb-2">Cancel</a>
                                        </div>
                                    </div>
                            </div>
                            </form>

                        </div>
                </div>
                </section>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
