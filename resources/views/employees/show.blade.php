@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">
                    {{ $employee->name }}
                    <span class="badge {{ $employee->resign_date ? 'badge-danger' : 'badge-success' }} ml-2" style="vertical-align: middle;">
                        {{ $employee->resign_date ? 'Resigned' : 'Active' }}
                    </span>
                </h2>
                <p>
                    <span class="badge badge-purple mr-1">{{ $employee->employee_id }}</span>
                    @if($employee->type)
                        <span class="badge badge-info">{{ ucfirst($employee->type) }}</span>
                    @endif
                </p>
            </div>
            <div class="d-flex">
                <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-sm mr-2">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <a href="{{ route('employee.history', $employee->id) }}" class="btn btn-primary btn-sm mr-2">
                    <i class="fa fa-clock-o"></i> Full History
                </a>
                @if(Auth::user()->hasRole(['o-hr', 'o-super-admin', 'o-admin']))
                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-info btn-sm mr-2">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <a href="{{ route('employees.print', $employee->id) }}" target="_blank" class="btn btn-dark btn-sm">
                    <i class="fa fa-print"></i> Print Profile
                </a>
                @endif
            </div>
        </div>

        @if($employee->resign_date)
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-triangle"></i>
            This employee resigned on {{ \Carbon\Carbon::parse($employee->resign_date)->format('Y-m-d') }}.
        </div>
        @endif

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-primary">{{ $employee->receives->count() }}</h3>
                        <p class="mb-0">Receives</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-danger">{{ $employee->clearance->count() }}</h3>
                        <p class="mb-0">Clearances</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-success">{{ $employee->devices->count() }}</h3>
                        <p class="mb-0">Devices</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-info">{{ $employee->sim_card->count() }}</h3>
                        <p class="mb-0">SIM Cards</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Profile Photo -->
            <div class="col-md-4 mb-4">
                <section class="hk-sec-wrapper text-center">
                    <img class="img-fluid rounded mb-3" style="max-width: 220px;"
                        src="{{ asset('X-Files/Dash/imgs/EmployeeProfilePic/' . $employee->profile_image) }}" alt="{{ $employee->name }}">
                    <h5 class="hk-sec-title mb-1">{{ $employee->name }}</h5>
                    <p class="text-muted mb-2">{{ $employee->position->name ?? 'No Position Assigned' }}</p>
                    <p class="mb-0">
                        <span class="badge badge-soft-success">{{ $employee->department->name ?? 'No Department Assigned' }}</span>
                    </p>
                </section>
            </div>

            <!-- Key Info -->
            <div class="col-md-8 mb-4">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Details</h5>
                    <div class="row text-center mb-3">
                        <div class="col-6 border-right">
                            <span class="d-block display-6">{{ $diff->y }}y {{ $diff->m }}m {{ $diff->d }}d</span>
                            <span class="d-block text-capitalize font-14">{{ $employee->resign_date ? 'Worked For' : 'Working For' }}</span>
                        </div>
                        <div class="col-6">
                            <span class="d-block display-6">{{ $hireDate }}</span>
                            <span class="d-block text-capitalize font-14">Hire Date</span>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="ion ion-md-briefcase mr-2"></i>Orion Email:
                            <span class="ml-2">
                                @if($employee->orion_email)
                                    {{ $employee->orion_email }}
                                @else
                                    <span class="badge badge-danger">Not Assigned</span>
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item">
                            <i class="ion ion-md-briefcase mr-2"></i>Orion Mobile:
                            <span class="ml-2">
                                @forelse($employee->sim_card as $sim)
                                    <span class="badge badge-success mr-1">{{ $sim->sim_number }}</span>
                                @empty
                                    <span class="badge badge-danger">No SIM Assigned</span>
                                @endforelse
                            </span>
                        </li>
                        <li class="list-group-item">
                            <i class="ion ion-md-briefcase mr-2"></i>Personal Mobile:
                            <span class="ml-2">{{ $employee->personal_mobile ?? 'Not Found' }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="ion ion-md-briefcase mr-2"></i>Personal Email:
                            <span class="ml-2">{{ $employee->personal_email ?? 'Not Found' }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="ion ion-md-person mr-2"></i>Direct Manager:
                            <span class="ml-2">{{ $employee->manager->name ?? 'No Manager Assigned' }}</span>
                        </li>
                        @if($project)
                        <li class="list-group-item">
                            <i class="ion ion-md-briefcase mr-2"></i>Project:
                            <span class="ml-2">{{ $project->project_name }} ({{ $project->project_code }})</span>
                        </li>
                        @endif
                        @if($employee->notes)
                        <li class="list-group-item">
                            <i class="ion ion-md-document mr-2"></i>Notes:
                            <span class="ml-2">{{ $employee->notes }}</span>
                        </li>
                        @endif
                    </ul>
                </section>
            </div>
        </div>

        <!-- Devices -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Devices</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Device Name</th>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Model</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employee->devices as $device)
                                <tr>
                                    <td>{{ $device->device_name }}</td>
                                    <td>{{ $device->device_code }}</td>
                                    <td>{{ $device->device_type }}</td>
                                    <td>{{ $device->device_model }}</td>
                                    <td>
                                        <a href="{{ route('device.show', $device->id) }}" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No devices assigned to this employee</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        <!-- SIM Cards -->
        <div class="row mt-4">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">SIM Cards</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>SIM Number</th>
                                    <th>Provider</th>
                                    <th>Plan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employee->sim_card as $sim)
                                <tr>
                                    <td>{{ $sim->sim_number }}</td>
                                    <td>{{ $sim->sim_provider }}</td>
                                    <td>{{ $sim->sim_plan }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">No SIM cards assigned to this employee</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        <!-- Receive History -->
        <div class="row mt-4">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Receive History</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Receive Code</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employee->receives->sortByDesc('created_at') as $receive)
                                <tr>
                                    <td>{{ $receive->code }}</td>
                                    <td>{{ $receive->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if($receive->status == 'received')
                                            <span class="badge badge-success">Received</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('receive.show', $receive->id) }}" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No receive history</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        <!-- Clearance History -->
        <div class="row mt-4">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Clearance History</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Clearance Code</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employee->clearance->sortByDesc('created_at') as $clearance)
                                <tr>
                                    <td>{{ $clearance->clear_code }}</td>
                                    <td>{{ $clearance->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if($clearance->status == 'finished')
                                            <span class="badge badge-success">Finished</span>
                                        @elseif(in_array($clearance->status, ['pending_resign', 'resigned']))
                                            <span class="badge badge-danger">Resignation</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('clearance.show', $clearance->id) }}" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No clearance history</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
