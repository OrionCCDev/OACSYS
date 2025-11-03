@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Receive Assets to {{ $project->project_name }}</h2>
                <p>Select devices and SIM cards to receive to this project</p>
            </div>
            <div>
                <a href="{{ route('project-assets.show', $project->id) }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <form action="{{ route('project-assets.receive.store', $project->id) }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Available Devices -->
                            <div class="col-md-6">
                                <h5 class="hk-sec-title">Available Devices</h5>
                                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                    <table class="table table-sm table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="50">Select</th>
                                                <th>Device Name</th>
                                                <th>Code</th>
                                                <th>Type</th>
                                                <th>Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($availableDevices as $index => $device)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="devices[]" value="{{ $device->id }}" class="form-check-input">
                                                </td>
                                                <td>{{ $device->device_name }}</td>
                                                <td>{{ $device->device_code }}</td>
                                                <td>{{ $device->device_type }}</td>
                                                <td>
                                                    <input type="text" name="device_notes[{{ $index }}]" class="form-control form-control-sm" placeholder="Add notes (important details about this device)">
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No available devices</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Available SIM Cards -->
                            <div class="col-md-6">
                                <h5 class="hk-sec-title">Available SIM Cards</h5>
                                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                    <table class="table table-sm table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="50">Select</th>
                                                <th>SIM Number</th>
                                                <th>Provider</th>
                                                <th>Plan</th>
                                                <th>Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($availableSimCards as $index => $sim)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="sim_cards[]" value="{{ $sim->id }}" class="form-check-input">
                                                </td>
                                                <td>{{ $sim->sim_number }}</td>
                                                <td>{{ $sim->sim_provider }}</td>
                                                <td>{{ $sim->sim_plan }}</td>
                                                <td>
                                                    <input type="text" name="sim_notes[{{ $index }}]" class="form-control form-control-sm" placeholder="Add notes (important details about this SIM)">
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No available SIM cards</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <strong>Note:</strong> Adding notes is important! Please specify any important details about each device or SIM card being received (condition, special features, purpose, etc.).
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check"></i> Proceed to Signature
                                </button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
