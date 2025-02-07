@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Client Employees Management</h2>
            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title">Edit Client</h5>
                        <div class="row">
                            <div class="col-sm">
                                <form method="POST" action="{{ route('clientEmployee.update', $clientEmployee->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="clientEmployee_name">Name</label>
                                        <input type="text" name="clientEmployee_name" class="form-control"
                                            id="clientEmployee_name"
                                            value="{{ old('clientEmployee_name', $clientEmployee->name) }}">
                                        @error('clientEmployee_name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="client_id">Client</label>
                                        <select name="client_id" class="form-control custom-select" required>
                                            <option value="">Select</option>
                                            @foreach ($clients as $client)
                                            <option value="{{ $client->id }}" @selected(old('client_id',
                                                $clientEmployee->client_id) == $client->id)>{{ $client->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('client_id')
                                        <div class="alert alert-warning" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="clientEmployee_email">Email</label>
                                        <input type="email" name="clientEmployee_email" class="form-control"
                                            id="clientEmployee_email"
                                            value="{{ old('clientEmployee_email', $clientEmployee->email) }}">
                                        @error('clientEmployee_email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="clientEmployee_mobile">Mobile</label>
                                        <input type="text" name="clientEmployee_mobile" class="form-control"
                                            id="clientEmployee_mobile"
                                            value="{{ old('clientEmployee_mobile', $clientEmployee->mobile_number) }}">
                                        @error('clientEmployee_mobile')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="clientEmployee_position">Position</label>
                                        <input type="text" name="clientEmployee_position" class="form-control"
                                            id="clientEmployee_position"
                                            value="{{ old('clientEmployee_position', $clientEmployee->position) }}">
                                        @error('clientEmployee_position')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="project_id">Project</label>
                                        <select name="project_id" class="form-control custom-select" required>
                                            <option value="">Select</option>
                                            @foreach ($projects as $project)
                                            <option value="{{ $project->id }}" @selected(old('project_id',
                                                $clientEmployee->project_id) == $project->id)>{{ $project->project_name
                                                }} ({{ $project->project_code }})</option>
                                            @endforeach
                                        </select>
                                        @error('project_id')
                                        <div class="alert alert-warning" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('clientEmployee.index') }}" class="btn btn-danger">Cancel</a>
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
