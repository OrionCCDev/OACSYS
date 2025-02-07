@extends('layouts.app')

@section('content')

<div class="hk-pg-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 pa-0">


                <div class="tab-content mt-sm-60 mt-30">
                    <div class="" id="">
                        <div class="container">


                            <div class="hk-row">
                                <div class="col-12">
                                        <div class="card card-profile-feed">
                                            <div class="card-header card-header-action">
                                                <div class="media align-items-center">

                                                    <div class="media-body">
                                                        <div class="text-capitalize font-weight-500 text-dark">Client Info</div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="card-body">
                                                <div class="card">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Client</th>
                                                                <th>Mobile</th>
                                                                <th>Position</th>
                                                                <th>Project</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{ $clientEmployee->name ?? 'Not Assigned' }}</td>
                                                                <td>{{ $clientEmployee->email ?? 'Not Assigned' }}</td>
                                                                <td>{{ $clientEmployee->client->name ?? 'Not Assigned' }}</td>
                                                                <td>{{ $clientEmployee->mobile_number ?? 'Not Assigned' }}</td>
                                                                <td>{{ $clientEmployee->position ?? 'Not Assigned' }}</td>
                                                                <td>{{ $clientEmployee->project->project_name }} ( {{ $clientEmployee->project->project_code }} )</td>
                                                                <td>
                                                                    <a href="{{ route('clientEmployee.edit', $clientEmployee->id) }}" class="btn btn-info btn-sm">Edit</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-12">
                                    @if ($clientEmployee->devices->count() == 0)
                                    <div class="card card-profile-feed mt-4">
                                        <div class="card-header card-header-action">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <div class="text-capitalize font-weight-500 text-dark">Assigned Devices</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Device Name</th>
                                                            <th>Device img</th>
                                                            <th>Device Type</th>
                                                            <th>More Details</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($clientEmployee->devices as $device)
                                                        <tr>
                                                            <td>{{ $device->device_name }}</td>
                                                            <td>         <img
                                                                            class="img-fluid rounded"
                                                                            src="{{ asset('X-Files/Dash/imgs/devices/' . $device->main_image ) }}"
                                                                            width="50" height="50" alt="icon">
                                                            </td>
                                                            <td>{{ $device->device_type }}</td>
                                                            <td>
                                                                <a href="{{ route('device.show', $device->id) }}"
                                                                    class="btn btn-sm btn-brown" title="View Details">
                                                                    <i class="fa fa-eye" style="color: white"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if ($clientEmployee->sim_card->count() == 0)
                                    <div class="card card-profile-feed mt-4">
                                        <div class="card-header card-header-action">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <div class="text-capitalize font-weight-500 text-dark">Assigned SIM Cards</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Number</th>
                                                            <th>Provider</th>
                                                            <th>Plan</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($clientEmployee->sim_card as $simCard)
                                                        <tr>
                                                            <td>{{ $simCard->sim_number }}</td>
                                                            <td>{{ $simCard->sim_provider }}</td>
                                                            <td>{{ $simCard->sim_plan }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                </div>
                                <a href="{{ route('clientEmployee.index') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
