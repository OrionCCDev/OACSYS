@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Consultant Management</h2>
            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title">Add New Consultant</h5>
                        <div class="row">
                            <div class="col-sm">
                                <form method="post" enctype="multipart/form-data" action="{{ route('consultant.store') }}"
                                    class="form-inline">
                                    @csrf
                                    <div class="row w-100">
                                        <div class="col-12 col-md-6 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Project Work In</h6>
                                            <div class="input-group mb-2 w-100">
                                                <select name="consultant_project_id"
                                                    class="form-control custom-select form-control custom-select-md mt-15">
                                                    <option value="">Select Project</option>
                                                    @foreach ( $allProjects as $project )
                                                    <option value="{{ $project->id }}" {{ old('consultant_project_id') == $project->id ? 'selected' : '' }}>{{ $project->project_name }}( {{ $project->project_code }} )</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            @error('consultant_project_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Consultant Name</h6>
                                            <label class="sr-only" for="AddNewEmployeeCode">Consultant Name</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Name</div>
                                                </div>
                                                <input type="text" name="consultant_name" class="form-control"
                                                    id="AddNewEmployeeCode" placeholder="Name Of Consultant" value="{{ old('consultant_name') }}">
                                            </div>
                                            @error('consultant_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="row w-100">
                                        <div class="col-12 col-md-6 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Consultant Company</h6>
                                            <label class="sr-only" for="AddNewEmployeePersonalMobile">Consultant Company</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Consultant Company</div>
                                                </div>
                                                <input type="text" name='consultant_company' class="form-control"
                                                    id="AddNewEmployeePersonalMobile" placeholder="Consultant Company" value="{{ old('consultant_company') }}">
                                            </div>
                                            @error('consultant_company')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Consultant Email</h6>
                                            <label class="sr-only" for="AddNewEmployeePersonalMobile">Consultant Email</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Consultant Email</div>
                                                </div>
                                                <input type="email" name='consultant_email' class="form-control"
                                                    id="AddNewEmployeePersonalMobile" placeholder="Consultant Email" value="{{ old('consultant_email') }}">
                                            </div>
                                            @error('consultant_email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row w-100">
                                        <div class="col-6 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Consultant Mobile</h6>
                                            <label class="sr-only" for="AddNewEmployeePersonalMobile1">Consultant Mobile</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Consultant Mobile</div>
                                                </div>
                                                <input type="text" name='consultant_mobile' class="form-control"
                                                    id="AddNewEmployeePersonalMobile1" placeholder="Consultant Mobile" value="{{ old('consultant_mobile') }}">
                                            </div>
                                            @error('consultant_mobile')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-6 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Consultant Position</h6>
                                            <label class="sr-only" for="AddNewEmployeePersonalMobile1">Consultant Position</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Consultant Position</div>
                                                </div>
                                                <input type="text" name='consultant_position' class="form-control"
                                                    id="AddNewEmployeePersonalposition1" placeholder="Consultant position" value="{{ old('consultant_position') }}">
                                            </div>
                                            @error('consultant_position')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <br>
                                    <div class="row mt-30">
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary mb-2">Save</button>
                                            <a href="{{ route('consultant.index') }}"  class="btn btn-danger mb-2">Cancel</a>
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
