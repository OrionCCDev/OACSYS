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
@dd($user)
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
                                <li
                                    style="display: flex; justify-content: flex-center;align-items: center;margin-left:10px">
                                    <a href="{{ route('project.addEmployeeProject' , $project->id) }}"
                                        class="btn btn-gradient-success btn-wth-icon btn-rounded icon-right"><span
                                            class="btn-text">Add Employees To Project</span> <span class="icon-label"><span
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
                                                            class="d-block text-dark text-capitalize text-truncate mw-150p"><a href="{{ route('clientEmployee.show' , $client->id) }}">{{
                                                            $client->name }}</a></span>
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
                                                            class="d-block text-dark text-capitalize text-truncate mw-150p"><a href="{{ route('consultant.show' , $consultant->id) }}">{{
                                                            $consultant->name }}</a></span>
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

                </div>
            </div>
        </div>

    </div>

</div>
@endsection
