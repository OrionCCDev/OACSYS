@extends('layouts.app')

@section('content')
<style>
    .device-checkbox, .sim-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
        margin: 0;
    }
    
    .table td {
        vertical-align: middle;
    }
</style>
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Transfer Assets from {{ $project->project_name }}</h2>
                <p>Select devices and SIM cards to transfer to another project</p>
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
                    <form action="{{ route('project-assets.transfer.store', $project->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="from_project_id" value="{{ $project->id }}">

                        <!-- Select Target Project -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="to_project_id">Transfer To Project <span class="text-danger">*</span></label>
                                    <select name="to_project_id" id="to_project_id" class="form-control @error('to_project_id') is-invalid @enderror" required>
                                        <option value="">Select Project</option>
                                        @foreach($otherProjects as $otherProject)
                                        <option value="{{ $otherProject->id }}">{{ $otherProject->project_name }} ({{ $otherProject->project_code }})</option>
                                        @endforeach
                                    </select>
                                    @error('to_project_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Project Devices -->
                            <div class="col-md-6">
                                <h5 class="hk-sec-title">Devices to Transfer</h5>
                                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                    <table class="table table-sm table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="50" class="text-center">Select</th>
                                                <th>Device Name</th>
                                                <th>Code</th>
                                                <th>Type</th>
                                                <th>Transfer Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($projectDevices as $index => $device)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" name="devices[]" value="{{ $device->id }}" class="device-checkbox">
                                                </td>
                                                <td>{{ $device->device_name }}</td>
                                                <td>{{ $device->device_code }}</td>
                                                <td>{{ $device->device_type }}</td>
                                                <td>
                                                    <input type="text" name="device_notes[{{ $index }}]" class="form-control form-control-sm" placeholder="Reason for transfer, condition, etc.">
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No devices available for transfer</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Project SIM Cards -->
                            <div class="col-md-6">
                                <h5 class="hk-sec-title">SIM Cards to Transfer</h5>
                                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                    <table class="table table-sm table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="50" class="text-center">Select</th>
                                                <th>SIM Number</th>
                                                <th>Provider</th>
                                                <th>Plan</th>
                                                <th>Transfer Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($projectSimCards as $index => $sim)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" name="sim_cards[]" value="{{ $sim->id }}" class="sim-checkbox">
                                                </td>
                                                <td>{{ $sim->sim_number }}</td>
                                                <td>{{ $sim->sim_provider }}</td>
                                                <td>{{ $sim->sim_plan }}</td>
                                                <td>
                                                    <input type="text" name="sim_notes[{{ $index }}]" class="form-control form-control-sm" placeholder="Reason for transfer, condition, etc.">
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No SIM cards available for transfer</td>
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
                                    <strong>Note:</strong> Please add transfer notes to track why assets are being moved between projects. This helps with audit trails and accountability.
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fa fa-exchange"></i> Proceed to Signature
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
