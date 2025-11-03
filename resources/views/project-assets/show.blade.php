@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">{{ $project->project_name }} - Assets</h2>
                <p>Project Code: {{ $project->project_code }}</p>
            </div>
            <div class="d-flex">
                <a href="{{ route('project-assets.index') }}" class="btn btn-secondary btn-sm mr-2">
                    <i class="fa fa-arrow-left"></i> Back to Projects
                </a>
                @if($project->status == 'in-progress')
                <a href="{{ route('project-assets.receive.create', $project->id) }}" class="btn btn-success btn-sm mr-2">
                    <i class="fa fa-download"></i> Receive Assets
                </a>
                <a href="{{ route('project-assets.clearance.create', $project->id) }}" class="btn btn-danger btn-sm mr-2">
                    <i class="fa fa-upload"></i> Clear Assets
                </a>
                <a href="{{ route('project-assets.transfer.create', $project->id) }}" class="btn btn-warning btn-sm">
                    <i class="fa fa-exchange"></i> Transfer Assets
                </a>
                @endif
            </div>
        </div>

        <!-- Asset Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-primary">{{ $assetsCount['devices'] }}</h3>
                        <p class="mb-0">Devices</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-success">{{ $assetsCount['sim_cards'] }}</h3>
                        <p class="mb-0">SIM Cards</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-info">{{ $assetsCount['total'] }}</h3>
                        <p class="mb-0">Total Assets</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Devices Table -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Devices</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Device Name</th>
                                    <th>Device Code</th>
                                    <th>Type</th>
                                    <th>Model</th>
                                    <th>Serial Number</th>
                                    <th>Status</th>
                                    <th>Health</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($project->devices as $device)
                                <tr>
                                    <td>{{ $device->device_name }}</td>
                                    <td>{{ $device->device_code }}</td>
                                    <td>{{ $device->device_type }}</td>
                                    <td>{{ $device->device_model }}</td>
                                    <td>{{ $device->serial_number }}</td>
                                    <td>
                                        @if($device->status == 'In-Project-Site')
                                            <span class="badge badge-success">In Project Site</span>
                                        @elseif($device->status == 'available')
                                            <span class="badge badge-secondary">Available</span>
                                        @elseif($device->status == 'pending-receiving')
                                            <span class="badge badge-warning">Pending Receiving</span>
                                        @else
                                            <span class="badge badge-info">{{ $device->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($device->health == 'New')
                                            <span class="badge badge-success">New</span>
                                        @elseif($device->health == 'Mediam_use')
                                            <span class="badge badge-info">Medium Use</span>
                                        @elseif($device->health == 'Bad_use')
                                            <span class="badge badge-warning">Bad Use</span>
                                        @elseif($device->health == 'Scrap')
                                            <span class="badge badge-danger">Scrap</span>
                                        @else
                                            <span class="badge badge-warning">{{ $device->health }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No devices assigned to this project</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        <!-- SIM Cards Table -->
        <div class="row mt-4">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">SIM Cards</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>SIM Number</th>
                                    <th>SIM Serial</th>
                                    <th>Provider</th>
                                    <th>Plan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($project->simCards as $sim)
                                <tr>
                                    <td>{{ $sim->sim_number }}</td>
                                    <td>{{ $sim->sim_serial }}</td>
                                    <td>{{ $sim->sim_provider }}</td>
                                    <td>{{ $sim->sim_plan }}</td>
                                    <td>
                                        @if($sim->status == 'taken')
                                            <span class="badge badge-success">Taken</span>
                                        @elseif($sim->status == 'available')
                                            <span class="badge badge-secondary">Available</span>
                                        @else
                                            <span class="badge badge-info">{{ $sim->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No SIM cards assigned to this project</td>
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
                                @forelse($project->receives as $receive)
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
    </div>
</div>
@endsection
