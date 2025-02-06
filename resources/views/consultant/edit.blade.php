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
                        <h5 class="hk-sec-title">Edit Consultant</h5>
                        <div class="row">
                            <div class="col-sm">
                                <form method="POST" action="{{ route('consultant.update', $consultant->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="consultant_name">Name</label>
                                        <input type="text" name="consultant_name" class="form-control" id="consultant_name" value="{{ old('consultant_name', $consultant->name) }}">
                                        @error('consultant_name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="consultant_name">Company</label>
                                        <input type="text" name="consultant_company" class="form-control" id="consultant_company" value="{{ old('consultant_company', $consultant->company_name) }}">
                                        @error('consultant_company')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="consultant_email">Email</label>
                                        <input type="email" name="consultant_email" class="form-control" id="consultant_email" value="{{ old('consultant_email', $consultant->email) }}">
                                        @error('consultant_email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="consultant_mobile">Mobile</label>
                                        <input type="text" name="consultant_mobile" class="form-control" id="consultant_mobile" value="{{ old('consultant_mobile', $consultant->mobile) }}">
                                        @error('consultant_mobile')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="consultant_position">Position</label>
                                        <input type="text" name="consultant_position" class="form-control" id="consultant_position" value="{{ old('consultant_position', $consultant->position) }}">
                                        @error('consultant_position')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="consultant_project_id">Project Work In</label>
                                        <select name="consultant_project_id" class="form-control custom-select form-control custom-select-md mt-15">
                                            <option value="">Select Project</option>
                                            @foreach ($allProjects as $project)
                                            <option value="{{ $project->id }}" {{ old('consultant_project_id', $consultant->project_id) == $project->id ? 'selected' : '' }}>
                                                {{ $project->project_name }} ({{ $project->project_code }})
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('consultant_project_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('consultant.index') }}" class="btn btn-danger">Cancel</a>
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
