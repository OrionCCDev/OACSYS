@extends('layouts.app')
@section('sweetalert')
<script>
  @if(session('success'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    @endif
</script>
@endsection
@section('content')
<div class="hk-pg-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 pa-0">
                <div class="profile-cover-wrap overlay-wrap">
                    <div class="profile-cover-img"
                        style="background-image:url('{{ asset('X-Files/Dash/imgs/' . $project->project_main_image) }}')">
                    </div>
                    <div class="bg-overlay bg-trans-dark-60"></div>
                    <div class="container profile-cover-content py-50">
                        <div class="hk-row">
                            <div class="col-lg-6">
                                <div class="media align-items-center">
                                    <div class="media-img-wrap  d-flex">
                                        <div class="avatar" style='width: 130px; height: 130px;'>
                                            <img src="{{ asset('X-Files/Dash/imgs/EmployeeProfilePic/'.$project->manager->profile_image) }}"
                                                alt="user" class="avatar-img rounded-circle" style="object-fit: cover;object-position: top;">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="text-white text-capitalize display-6 mb-5 font-weight-400">{{
                                            $project->manager->name }}</div>
                                        <div class="font-14 text-white"><span class="mr-5">Project Manager</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-bottom">
                    <div class="container">
                        <div class="row">
                            <ul class="nav nav-light nav-tabs col-6" id="list-tab" role="tablist">
                                <li class="nav-item">
                                    <a href="#data" id="list-of-data" data-toggle="list" role="tab"
                                        aria-controls="list-of-data"
                                        class="d-flex h-60p align-items-center nav-link active">Data</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#device" id="list-of-devices" data-toggle="list" role="tab"
                                        aria-controls="list-of-devices"
                                        class="d-flex h-60p align-items-center nav-link">Devices</a>
                                </li>

                                {{-- <li class="nav-item">
                                    <a href="#gallary" id="list-of-gallary" data-toggle="list" role="tab"
                                        aria-controls="list-of-gallary"
                                        class="d-flex h-60p align-items-center nav-link">Gallary</a>
                                </li> --}}
                            </ul>
                            <ul class="nav nav-light nav-tabs col-6 justify-content-end">
                                <li
                                    style="display: flex; justify-content: flex-center;align-items: center;margin-right:10px">
                                    <a href="{{ route('project.addDevice' , $project->id) }}"
                                        class="btn btn-gradient-info btn-wth-icon btn-rounded icon-right"><span
                                            class="btn-text">Add Devices Here</span> <span class="icon-label"><span
                                                class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-arrow-right-circle">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <polyline points="12 16 16 12 12 8"></polyline>
                                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                                </svg></span> </span>
                                    </a>
                                </li>
                                {{-- <li
                                    style="display: flex; justify-content: flex-center;align-items: center;margin-left:10px">
                                    <a href="{{ route('project.index') }}"
                                        class="btn btn-gradient-success btn-wth-icon btn-rounded icon-right"><span
                                            class="btn-text">Add New Project</span> <span class="icon-label"><span
                                                class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-arrow-right-circle">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <polyline points="12 16 16 12 12 8"></polyline>
                                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                                </svg></span> </span>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="container  mt-sm-60 mt-30">
                    <div class="hk-pg-header" style="justify-content: center;">
                        <div>
                            <h2 class="hk-pg-title font-weight-600">{{ $project->project_name }}</h2>
                        </div>
                        <div class="d-flex mb-0 flex-wrap">
                            <div class="btn-group btn-group-sm btn-group-rounded mb-15 ml-15" role="group">
                                <button type="button" class="btn btn-primary">Code</button>
                                <button type="button" class="btn btn-outline-primary">{{ $project->project_code
                                    }}</button>
                            </div>
                            {{-- <button
                                class="btn btn-sm btn-outline-primary btn-rounded btn-wth-icon icon-wthot-bg mb-15"><span
                                    class="icon-label"><span class="feather-icon"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg></span> </span><span class="btn-text">new projects</span></button> --}}
                        </div>
                    </div>
                </div>
                <div class="tab-content mt-sm-60 mt-30">
                    <div class="tab-pane fade show active" id="data" aria-labelledby="list-of-data" role="tabpanel">
                        <div class="container">
                            <div class="hk-row">
                                <div class="col-lg-3 col-sm-6">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <span
                                                class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Employees</span>
                                            <div
                                                class="d-flex align-items-center justify-content-between position-relative">
                                                <div>
                                                    <span class="d-block display-5 font-weight-400 text-dark">{{
                                                        $projectEmployeesCount }}</span>
                                                </div>
                                                <div class="position-absolute r-0">
                                                    {{-- عدد الموظقيين في المشروع --}}
                                                    <span id="pie_chart_1" class="d-flex easy-pie-chart"
                                                        data-percent="86">

                                                        <canvas height="62" width="62"
                                                            style="height: 50px; width: 50px;"></canvas></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <span
                                                class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Camera
                                                Number</span>
                                            <div
                                                class="d-flex align-items-center justify-content-between position-relative">
                                                <div>
                                                    <span class="d-block">
                                                        <span class="display-5 font-weight-400 text-dark"><span
                                                                class="counter-anim">{{
                                                                $project->devices->where('device_type',
                                                                'Camera')->count() }}
                                                            </span></span>
                                                    </span>
                                                </div>
                                                {{-- عدد الكاميرات في المشروع --}}
                                                <div class="position-absolute r-0">
                                                    <span id="pie_chart_2" class="d-flex easy-pie-chart"
                                                        data-percent="75">

                                                        <canvas height="62" width="62"
                                                            style="height: 50px; width: 50px;"></canvas></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <span
                                                class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">PCs
                                                & Laptops</span>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <div>
                                                    <span class="d-block">
                                                        <span class="display-5 font-weight-400 text-dark">{{
                                                            $project->devices->whereIn('device_type', ['pc',
                                                            'Laptop'])->count() }}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <span
                                                class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Printers</span>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <div>
                                                    <span class="d-block">
                                                        <span class="display-5 font-weight-400 text-dark">{{
                                                            $project->devices->where('device_type', 'Printer')->count()
                                                            }}</span>
                                                    </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="hk-row">
                                <div class="col-lg-12">
                                    <div class="card card-profile-feed">
                                        <div class="card">
                                            <div class="card-body pa-0">
                                                <div class="table-wrap">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-hover mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Name</th>
                                                                    <th>Department</th>
                                                                    <th>Position</th>
                                                                    <th>Devices</th>
                                                                    <th>Manage</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($project->employees as $employee )
                                                                <tr>

                                                                    <td>{{ $employee->employee_id }}</td>
                                                                    <td>{{ $employee->name }}</td>
                                                                    <td>{{ $employee->department->name }}</td>
                                                                    <td>{{ $employee->position->name }}</td>
                                                                    <td>{{ $employee->devices->count() }}
                                                                    </td>
                                                                    <td class="">
                                                                        <div class="d-flex align-items-center btn-group btn-group-rounded mr-10"
                                                                            role="group" aria-label="Basic example">
                                                                            <button type="button" data-toggle="modal"
                                                                                data-target="#transferEmpModal{{ $employee->id }}"
                                                                                class="btn btn-outline-warning  btn-warning ">Transfer
                                                                                To Project</button>
                                                                            <div class="modal fade"
                                                                                id="transferEmpModal{{ $employee->id }}"
                                                                                tabindex="-1" role="dialog"
                                                                                aria-labelledby="transferEmpModalLabel"
                                                                                aria-hidden="true">
                                                                                <div class="modal-dialog"
                                                                                    role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title"
                                                                                                id="exampleModalLabel{{ $employee->id }}">
                                                                                                Transfer Employee To
                                                                                                Another Project</h5>
                                                                                            <button type="button"
                                                                                                class="close"
                                                                                                data-dismiss="modal"
                                                                                                aria-label="Close">
                                                                                                <span
                                                                                                    aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <p>Choose Project Which You
                                                                                                Want To Transffer
                                                                                                <strong> {{
                                                                                                    $employee->name }}
                                                                                                </strong>
                                                                                            </p>
                                                                                            <form
                                                                                                action="{{ route('employee.transfer') }}"
                                                                                                method="post">
                                                                                                @csrf
                                                                                                @method('PUT')

                                                                                                <input type="hidden"
                                                                                                    name="employee_id"
                                                                                                    value="{{ $employee->id }}">

                                                                                                <select name="project_id"
                                                                                                    class="form-control custom-select form-control custom-select-lg mt-15">
                                                                                                    <option selected="">
                                                                                                        Select a Project
                                                                                                    </option>
                                                                                                    @foreach ($projects
                                                                                                    as $pro )
                                                                                                    <option
                                                                                                        value="{{ $pro->id }}">
                                                                                                        {{
                                                                                                        $pro->project_name
                                                                                                        }} @ {{
                                                                                                        $pro->project_code
                                                                                                        }}
                                                                                                    </option>
                                                                                                    @endforeach

                                                                                                </select>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="submit"
                                                                                                class="btn btn-primary">Save
                                                                                                changes</button>
                                                                                            </form>

                                                                                            <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <a href="{{ route('employees.show' , ['employee' => $employee->id]) }}"
                                                                                type="button"
                                                                                class="btn btn-outline-info ">Show
                                                                                Info</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                        {{ $project->employees->links('pagination::bootstrap-4') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="card card-profile-feed">
                                        <div class="card-header card-header-action">
                                            <h6><span>Clients <span class="badge badge-soft-primary ml-5">{{
                                                        $clientsCount }}</span></span></h6>

                                            <div class="d-flex align-items-center card-action-wrap">
                                                <div class="inline-block dropdown">
                                                    <div class="d-flex align-items-center card-action-wrap">
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addClientModal">
                                                            Assign Client Employee
                                                        </button>
                                                    </div>
                                                    <div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="addClientModalLabel">Add Client to Project</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('project.addClient', $project->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label>Select Client</label>
                                                                            <select name="client_employee_id" class="form-control">
                                                                                <option value="">Select Client</option>
                                                                                @foreach($clientEmployees as $clientEmployee)
                                                                                    <option value="{{ $clientEmployee->id }}">
                                                                                        {{ $clientEmployee->name }} - {{ $clientEmployee->client->name }} @if($clientEmployee->project_id != null) <span style="background-color: yellowgreen"> - {{ $clientEmployee->project->project_name }}</span>    @endif
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Add Client</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            @foreach ($project->clients as $client )
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <span
                                                                class="avatar-text avatar-text-inv-pink rounded-circle">
                                                                <span class="initial-wrap"><span>{{
                                                                        strtoupper(substr($client->name, 0, 1))
                                                                        }}</span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span
                                                            class="d-block text-dark text-capitalize text-truncate mw-150p">{{
                                                            $client->name }}</span>
                                                    </div>
                                                    <button type="button" class="btn btn-warning mx-2" data-toggle="modal" data-target="#transferClientModal{{ $client->id }}">
                                                        Transfer
                                                    </button>

                                                    <!-- Transfer Modal -->
                                                    <div class="modal fade" id="transferClientModal{{ $client->id }}" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Transfer {{ $client->name }} to Another Project</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('project.transferClient', $client->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <select name="project_id" class="form-control" required>
                                                                            <option value="">Select Project</option>
                                                                            @foreach($projects->where('id', '!=', $project->id) as $proj)
                                                                                <option value="{{ $proj->id }}">{{ $proj->project_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Transfer</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('project.removeClient', $client->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card card-profile-feed">
                                        <div class="card-header card-header-action">
                                            <h6><span>Consultants <span class="badge badge-soft-primary ml-5">{{
                                                        $consultantsCount }}</span></span></h6>
                                            <div class="d-flex align-items-center card-action-wrap">
                                                <div class="inline-block dropdown">
                                                    <div class="d-flex align-items-center card-action-wrap">
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addClientModal12">
                                                            Assign Consultant Employee
                                                        </button>
                                                    </div>
                                                    <div class="modal fade" id="addClientModal12" tabindex="-1" role="dialog" aria-labelledby="addClientModal12Label" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="addClientModal12Label">Add Consultant to Project</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('project.addConsultant', $project->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label>Select Consultant</label>
                                                                            <select name="consultantEmployee" class="form-control">
                                                                                <option value="">Select Consultant</option>
                                                                                @foreach($consultants as $Ce)
                                                                                    <option value="{{ $Ce->id }}">
                                                                                        {{ $Ce->name }} - {{ $Ce->company_name }} @if($Ce->project_id != null) <span style="background-color: yellowgreen"> - {{ $Ce->project->project_name }}</span>    @endif
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Add Consultant</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            @foreach ($project->consultants as $consultant )
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <span
                                                                class="avatar-text avatar-text-inv-pink rounded-circle"><span
                                                                    class="initial-wrap"><span>{{
                                                                        strtoupper(substr($consultant->name, 0, 1))
                                                                        }}</span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span
                                                            class="d-block text-dark text-capitalize text-truncate mw-150p">{{
                                                            $consultant->name }}</span>
                                                        <span class="d-block font-13 text-truncate mw-150p">{{
                                                            $consultant->company_name }}</span>
                                                    </div>
                                                    <button type="button" class="btn btn-warning mx-2" data-toggle="modal" data-target="#transferClientModal{{ $consultant->id }}">
                                                        Transfer
                                                    </button>

                                                    <!-- Transfer Modal -->
                                                    <div class="modal fade" id="transferClientModal{{ $consultant->id }}" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Transfer {{ $consultant->name }} to Another Project</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('project.transferConsultant', $consultant->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <select name="project_id" class="form-control" required>
                                                                            <option value="">Select Project</option>
                                                                            @foreach($projects->where('id', '!=', $project->id) as $proj)
                                                                                <option value="{{ $proj->id }}">{{ $proj->project_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Transfer</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('project.removeConsultant', $consultant->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show " id="device" aria-labelledby="list-of-device" role="tabpanel">
                        <div class="container">
                            <div class="hk-row">
                                <div class="col-lg-12">
                                    <div class="row">


                                    @foreach ( $project->devices as $device )
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="card mb-20">
                                            <a href="{{ route('device.show', $device->id) }}">
                                                <img class="card-img-top" src="{{ asset('X-Files/Dash/imgs/devices/' . $device->main_image) }}" alt="Card image cap">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $device->device_name }}</h5>
                                                    <p class="card-text">{{ $device->device_model }} -- {{ $device->device_type }} -- {{ $device->short_description }}</p>
                                                    <p class="card-text"><small class="text-muted">{{ $device->device_code }}</small></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- <div class="tab-pane fade show " id="gallary" aria-labelledby="list-of-gallary" role="tabpanel">
                        <div class="container">
                            <div class="hk-row">
                                <div class="col-lg-8">
                                    <div class="card card-profile-feed">
                                        <div class="card-header card-header-action">
                                            <div class="media align-items-center">
                                                <div class="media-img-wrap d-flex mr-10">
                                                    <div class="avatar avatar-sm">
                                                        <img src="dist/img/avatar2.jpg" alt="user"
                                                            class="avatar-img rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-capitalize font-weight-500 text-dark">Madelyn
                                                        Rascon</div>
                                                    <div class="font-13">25 min</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center card-action-wrap">
                                                <div class="inline-block dropdown">
                                                    <a class="dropdown-toggle no-caret" data-toggle="dropdown" href="#"
                                                        aria-expanded="false" role="button"><i
                                                            class="ion ion-ios-more"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#">Separated link</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text mb-30">There was that time artists at Sequence opted to
                                                hand-Sharpie the lorem ipsum passage on a line of paper bags they
                                                designed for Chipotle.</p>
                                            <div class="card">
                                                <div class="position-relative">
                                                    <img class="card-img-top d-block" src="dist/img/cropper.jpg"
                                                        alt="Card image cap">
                                                    <a href="#"
                                                        class="btn btn-dark btn-wth-icon icon-wthot-bg btn-rounded btn-pg-link"><span
                                                            class="icon-label"><i
                                                                class="ion ion-md-link"></i></span><span
                                                            class="btn-text">website</span></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Bacon chicken turducken spare ribs.</h5>
                                                    <p class="card-text">Of course, we'd be remiss not to include the
                                                        veritable cadre of lorem ipsum knock offs featuring: Bacon
                                                        Ipsum, Hipster Ipsum, Corporate Ipsum, Legal Ipsum.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer justify-content-between">
                                            <div>
                                                <a href="#"><i class="ion ion-md-heart text-primary"></i>30K</a>
                                            </div>
                                            <div>
                                                <a href="#">1K comments</a>
                                                <a href="#">12 shares</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-columns card-column-1">
                                        <div class="card card-profile-feed mb-0 rounded-bottom-0">
                                            <div class="card-header card-header-action">
                                                <div class="media align-items-center">
                                                    <div class="media-img-wrap d-flex mr-10">
                                                        <div class="avatar avatar-sm">
                                                            <img src="dist/img/avatar3.jpg" alt="user"
                                                                class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="text-capitalize font-weight-500 text-dark">Mitsoku
                                                            Heid</div>
                                                        <div class="font-13">3 hrs</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center card-action-wrap">
                                                    <div class="inline-block dropdown">
                                                        <a class="dropdown-toggle no-caret" data-toggle="dropdown"
                                                            href="#" aria-expanded="false" role="button"><i
                                                                class="ion ion-ios-more"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#">Action</a>
                                                            <a class="dropdown-item" href="#">Another action</a>
                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#">Separated link</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text mb-30">Not to mention, Cupcake Ipsum, Bob Ross Ipsum
                                                    (“happy little clouds”), and the furry Cat Ipsum.</p>
                                                <div class="feed-img-layout">
                                                    <div class="row h-200p">
                                                        <div class="col-6 h-100">
                                                            <div class="feed-img h-100"
                                                                style="background-image:url(dist/img/slide4.jpg);">
                                                            </div>
                                                        </div>
                                                        <div class="col-6 h-100">
                                                            <div class="row h-100">
                                                                <div class="col-sm-12 h-95p mb-10">
                                                                    <div class="feed-img h-100"
                                                                        style="background-image:url(dist/img/slide1.jpg);">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 h-95p">
                                                                    <div class="row h-100">
                                                                        <div class="col-6 h-100">
                                                                            <div class="feed-img h-100"
                                                                                style="background-image:url(dist/img/slide2.jpg);">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6 h-100">
                                                                            <div class="feed-img h-100"
                                                                                style="background-image:url(dist/img/slide3.jpg);">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer justify-content-between">
                                                <div>
                                                    <a href="#"><i class="ion ion-md-heart text-primary"></i>94</a>
                                                </div>
                                                <div>
                                                    <a href="#">1.5K comments</a>
                                                    <a href="#">18 shares</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-profile-feed border-top-0 rounded-top-0">
                                            <div class="card-body">
                                                <button class="btn btn-light btn-sm btn-block mb-25">Hide
                                                    comments</button>
                                                <div class="media">
                                                    <div class="media-img-wrap d-flex mr-10">
                                                        <div class="avatar avatar-xs">
                                                            <img src="dist/img/avatar5.jpg" alt="user"
                                                                class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="text-capitalize font-14 font-weight-500 text-dark">
                                                            Eziquiel Merideth</div>
                                                        <div class="font-15">
                                                            <p>So there you have it. The nonsense words unable to fully
                                                                escape meaning.</p>
                                                        </div>
                                                        <div class="d-flex mt-10">
                                                            <span class="font-14 text-light mr-15">1 hr</span>
                                                            <a href="#"
                                                                class="font-14 text-light text-capitalize font-weight-500">reply</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="media w-100 align-items-center">
                                                    <div class="media-img-wrap d-flex mr-15">
                                                        <div class="avatar avatar-xs">
                                                            <img src="dist/img/avatar11.jpg" alt="user"
                                                                class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <textarea class="form-control filled-input bg-transparent"
                                                            rows="1" placeholder="Leave a comment..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-profile-feed">
                                        <div class="card-header card-header-action">
                                            <div class="media align-items-center">
                                                <div class="media-img-wrap d-flex mr-10">
                                                    <div class="avatar avatar-sm">
                                                        <img src="dist/img/avatar6.jpg" alt="user"
                                                            class="avatar-img rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-capitalize font-weight-500 text-dark">Johnie
                                                        Metoyer</div>
                                                    <div class="font-13">11 hrs</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center card-action-wrap">
                                                <div class="inline-block dropdown">
                                                    <a class="dropdown-toggle no-caret" data-toggle="dropdown" href="#"
                                                        aria-expanded="false" role="button"><i
                                                            class="ion ion-ios-more"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#">Separated link</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text mb-30">Below are the original Latin passages from which
                                                Lorem Ipsum was derived, paired with their 1914 translations by H.
                                                Rackham.</p>
                                            <div class="card">
                                                <div class="position-relative">
                                                    <img class="card-img-top rounded d-block" src="dist/img/slide7.jpg"
                                                        alt="Card image cap">
                                                    <a href="#" class="btn-video-link"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer justify-content-between">
                                            <div>
                                                <a href="#"><i class="ion ion-md-heart text-primary"></i>142</a>
                                            </div>
                                            <div>
                                                <a href="#">751 comments</a>
                                                <a href="#">2 shares</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card card-profile-feed">
                                        <div class="card-header card-header-action">
                                            <div class="media align-items-center">
                                                <div class="media-img-wrap d-flex mr-10">
                                                    <div class="avatar avatar-sm">
                                                        <img src="dist/img/avatar7.jpg" alt="user"
                                                            class="avatar-img rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-capitalize font-weight-500 text-dark">Angelic
                                                        Lauver</div>
                                                    <div class="font-13">Business Manager</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center card-action-wrap">
                                                <div class="inline-block dropdown">
                                                    <a class="dropdown-toggle no-caret" data-toggle="dropdown" href="#"
                                                        aria-expanded="false" role="button"><i
                                                            class="ion ion-ios-settings"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#">Separated link</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row text-center">
                                            <div class="col-4 border-right pr-0">
                                                <div class="pa-15">
                                                    <span class="d-block display-6 text-dark mb-5">154</span>
                                                    <span class="d-block text-capitalize font-14">photos</span>
                                                </div>
                                            </div>
                                            <div class="col-4 border-right px-0">
                                                <div class="pa-15">
                                                    <span class="d-block display-6 text-dark mb-5">65</span>
                                                    <span class="d-block text-capitalize font-14">followers</span>
                                                </div>
                                            </div>
                                            <div class="col-4 pl-0">
                                                <div class="pa-15">
                                                    <span class="d-block display-6 text-dark mb-5">433</span>
                                                    <span class="d-block text-capitalize font-14">views</span>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><span><i
                                                        class="ion ion-md-calendar font-18 text-light-20 mr-10"></i><span>Went
                                                        to:</span></span><span class="ml-5 text-dark">Oh, Canada</span>
                                            </li>
                                            <li class="list-group-item"><span><i
                                                        class="ion ion-md-briefcase font-18 text-light-20 mr-10"></i><span>Worked
                                                        at:</span></span><span class="ml-5 text-dark">Companey</span>
                                            </li>
                                            <li class="list-group-item"><span><i
                                                        class="ion ion-md-home font-18 text-light-20 mr-10"></i><span>Lives
                                                        in:</span></span><span class="ml-5 text-dark">San Francisco,
                                                    CA</span></li>
                                            <li class="list-group-item"><span><i
                                                        class="ion ion-md-pin font-18 text-light-20 mr-10"></i><span>From:</span></span><span
                                                    class="ml-5 text-dark">Settle, WA</span></li>
                                        </ul>
                                    </div>
                                    <div class="card card-profile-feed">
                                        <div class="card-header card-header-action">
                                            <h6>You know these people ?</h6>
                                            <div class="d-flex align-items-center card-action-wrap">
                                                <div class="inline-block dropdown">
                                                    <a class="dropdown-toggle no-caret" data-toggle="dropdown" href="#"
                                                        aria-expanded="false" role="button"><i
                                                            class="ion ion-ios-more"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#">Separated link</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <img src="dist/img/avatar1.jpg" alt="user"
                                                                class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="d-block text-dark text-capitalize">Evie Ono</span>
                                                        <span class="d-block font-13">Apple Inc</span>
                                                    </div>
                                                    <a href="#" class="text-light-40 ml-auto"><i
                                                            class="ion ion-md-add font-24"></i></a>
                                                </div>
                                            </li>
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <img src="dist/img/avatar2.jpg" alt="user"
                                                                class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="d-block text-dark text-capitalize">Clay
                                                            Masse</span>
                                                        <span class="d-block font-13">Hencework.com</span>
                                                    </div>
                                                    <a href="#" class="text-light-40 ml-auto"><i
                                                            class="ion ion-md-add font-24"></i></a>
                                                </div>
                                            </li>
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <img src="dist/img/avatar3.jpg" alt="user"
                                                                class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="d-block text-dark text-capitalize">Madelyn
                                                            Rascon</span>
                                                        <span class="d-block font-13">Godaddy.co.in</span>
                                                    </div>
                                                    <a href="#" class="text-success ml-auto"><i
                                                            class="ion ion-md-checkmark font-20"></i></a>
                                                </div>
                                            </li>
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <img src="dist/img/avatar4.jpg" alt="user"
                                                                class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="d-block text-dark text-capitalize">Mitsoku
                                                            Heid</span>
                                                        <span class="d-block font-13">Flipkart</span>
                                                    </div>
                                                    <a href="#" class="text-success ml-auto"><i
                                                            class="ion ion-md-checkmark font-20"></i></a>
                                                </div>
                                            </li>
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <img src="dist/img/avatar5.jpg" alt="user"
                                                                class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="d-block text-dark text-capitalize">Eziquiel
                                                            Merideth</span>
                                                        <span class="d-block font-13">Paypal</span>
                                                    </div>
                                                    <a href="#" class="text-light-40 ml-auto"><i
                                                            class="ion ion-md-add font-24"></i></a>
                                                </div>
                                            </li>
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <img src="dist/img/avatar6.jpg" alt="user"
                                                                class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="d-block text-dark text-capitalize">Johnie
                                                            Metoyer</span>
                                                        <span class="d-block font-13">Robocon</span>
                                                    </div>
                                                    <a href="#" class="text-success ml-auto"><i
                                                            class="ion ion-md-checkmark font-20"></i></a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card card-profile-feed">
                                        <div class="card-header card-header-action">
                                            <h6><span>Friends <span
                                                        class="badge badge-soft-primary ml-5">212</span></span></h6>
                                            <a href="#" class="font-14 ml-auto">View all</a>
                                        </div>
                                        <div class="card-body pb-5">
                                            <div class="hk-row text-center">
                                                <div class="col-3 mb-15">
                                                    <div class="w-100">
                                                        <img src="dist/img/avatar1.jpg" alt="user"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <span class="d-block font-14 text-truncate">Evie Ono</span>
                                                </div>
                                                <div class="col-3 mb-15">
                                                    <div class="w-100">
                                                        <img src="dist/img/avatar2.jpg" alt="user"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <span class="d-block font-14 text-truncate">Clay Masse</span>
                                                </div>
                                                <div class="col-3 mb-15">
                                                    <div class="w-100">
                                                        <img src="dist/img/avatar3.jpg" alt="user"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <span class="d-block font-14 text-truncate">Madelyn Rascon</span>
                                                </div>
                                                <div class="col-3 mb-15">
                                                    <div class="w-100">
                                                        <img src="dist/img/avatar4.jpg" alt="user"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <span class="d-block font-14 text-truncate">Mitsoku Heid</span>
                                                </div>
                                                <div class="col-3 mb-15">
                                                    <div class="w-100">
                                                        <img src="dist/img/avatar5.jpg" alt="user"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <span class="d-block font-14 text-truncate">Eziquiel Merideth</span>
                                                </div>
                                                <div class="col-3 mb-15">
                                                    <div class="w-100">
                                                        <img src="dist/img/avatar6.jpg" alt="user"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <span class="d-block font-14 text-truncate">Johnie Metoyer</span>
                                                </div>
                                                <div class="col-3 mb-15">
                                                    <div class="w-100">
                                                        <img src="dist/img/avatar7.jpg" alt="user"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <span class="d-block font-14 text-truncate">Angelic Lauver</span>
                                                </div>
                                                <div class="col-3 mb-15">
                                                    <div class="w-100">
                                                        <img src="dist/img/avatar8.jpg" alt="user"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <span class="d-block font-14 text-truncate">Cecilia Rios</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-profile-feed">
                                        <div class="card-header card-header-action">
                                            <h6><span>Groups <span
                                                        class="badge badge-soft-success ml-5">12</span></span></h6>
                                            <a href="#" class="font-14 ml-auto">View all</a>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <img src="dist/img/slide1.jpg" alt="user"
                                                                class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="d-block text-dark text-capitalize">Landscape
                                                            Group</span>
                                                        <span class="d-block font-13">1.25K Members</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <img src="dist/img/slide2.jpg" alt="user"
                                                                class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="d-block text-dark text-capitalize">Josh Groben
                                                            Fanclub</span>
                                                        <span class="d-block font-13">2M Members</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <img src="dist/img/avatar12.jpg" alt="user"
                                                                class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="d-block text-dark text-capitalize">UI/UX
                                                            Lead</span>
                                                        <span class="d-block font-13">8K Members</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <img src="dist/img/slide3.jpg" alt="user"
                                                                class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="d-block text-dark text-capitalize">Design
                                                            Yatra</span>
                                                        <span class="d-block font-13">14K Members</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="card card-profile-feed">
                                        <div class="card-header card-header-action">
                                            <h6><span>Links <span class="badge badge-soft-warning ml-5">7</span></span>
                                            </h6>
                                            <div class="d-flex align-items-center card-action-wrap">
                                                <div class="inline-block dropdown">
                                                    <a class="dropdown-toggle no-caret" data-toggle="dropdown" href="#"
                                                        aria-expanded="false" role="button"><i
                                                            class="ion ion-ios-more"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#">Separated link</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <span
                                                                class="avatar-text avatar-text-inv-pink rounded-circle"><span
                                                                    class="initial-wrap"><span>G</span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span
                                                            class="d-block text-dark text-capitalize text-truncate mw-150p">Google.com</span>
                                                        <span
                                                            class="d-block font-13 text-truncate mw-150p">google.com</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <span
                                                                class="avatar-text avatar-text-inv-primary rounded-circle"><span
                                                                    class="initial-wrap"><span>PR</span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span
                                                            class="d-block text-dark text-capitalize text-truncate mw-150p">Improve
                                                            your business</span>
                                                        <span
                                                            class="d-block font-13 text-truncate mw-150p">yahoo.com</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <span
                                                                class="avatar-text avatar-text-inv-success rounded-circle"><span
                                                                    class="initial-wrap"><span>AB</span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span
                                                            class="d-block text-dark text-capitalize text-truncate mw-150p">Cast
                                                            the cookware</span>
                                                        <span
                                                            class="d-block font-13 text-truncate mw-150p">yahoo.com</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item border-0">
                                                <div class="media align-items-center">
                                                    <div class="d-flex media-img-wrap mr-15">
                                                        <div class="avatar avatar-sm">
                                                            <span
                                                                class="avatar-text avatar-text-inv-danger rounded-circle"><span
                                                                    class="initial-wrap"><span>LR</span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <span
                                                            class="d-block text-dark text-capitalize text-truncate mw-150p">The
                                                            universe thought sds sa</span>
                                                        <span
                                                            class="d-block font-13 text-truncate mw-150p">facebook.com</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="card bg-primary text-center border-0">
                                        <div class="twitter-slider-wrap card-body">
                                            <div class="twitter-icon text-center mb-15">
                                                <i class="fa fa-twitter"></i>
                                            </div>
                                            <div id="tweets_fetch" class="owl-carousel owl-theme"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
