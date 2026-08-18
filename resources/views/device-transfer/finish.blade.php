@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Complete Transfer</h2>
                <p>{{ $clearance->employee->name ?? '-' }} &rarr; {{ $receive->employee->name ?? '-' }}</p>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Devices Being Transferred</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Device Name</th>
                                    <th>Device Code</th>
                                    <th>Type</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deviceRecords as $record)
                                <tr>
                                    <td>{{ $record->device->device_name }}</td>
                                    <td>{{ $record->device->device_code }}</td>
                                    <td>{{ $record->device->device_type }}</td>
                                    <td>{{ $record->notes ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No devices in this transfer</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        @if($simRecords->isNotEmpty())
        <div class="row mt-3">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">SIM Cards Being Transferred</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>SIM Number</th>
                                    <th>Provider</th>
                                    <th>Plan</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($simRecords as $record)
                                <tr>
                                    <td>{{ $record->simCard->sim_number }}</td>
                                    <td>{{ $record->simCard->sim_provider }}</td>
                                    <td>{{ $record->simCard->sim_plan }}</td>
                                    <td>{{ $record->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
        @endif

        <div class="row mt-4">
            <!-- Clearance side -->
            <div class="col-md-6">
                <section class="hk-sec-wrapper h-100">
                    <h5 class="hk-sec-title">Step 1a &mdash; Releasing Employee Clearance</h5>
                    <p class="text-muted">{{ $clearance->employee->name ?? '-' }} ({{ $clearance->clear_code }})</p>

                    @if($clearance->status == 'finished')
                        <div class="alert alert-success mb-0">
                            <i class="fa fa-check"></i> Clearance signed.
                        </div>
                    @else
                        <a href="{{ route('clearance.pdf', $clearance->id) }}" target="_blank" class="btn btn-info btn-block mb-3">
                            <i class="fa fa-print"></i> Print Clearance Document
                        </a>

                        <form action="{{ route('device-transfer.clearance.complete', $clearance->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Signed Clearance Document <span class="text-danger">*</span></label>
                                <input type="file" name="clearing_signature" class="form-control" accept="image/*,application/pdf" required>
                            </div>
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-upload"></i> Upload &amp; Sign Clearance
                            </button>
                        </form>
                    @endif
                </section>
            </div>

            <!-- Receive side -->
            <div class="col-md-6">
                <section class="hk-sec-wrapper h-100">
                    <h5 class="hk-sec-title">Step 1b &mdash; Receiving Employee Receive</h5>
                    <p class="text-muted">{{ $receive->employee->name ?? '-' }} ({{ $receive->code }})</p>

                    @if($receive->status == 'received')
                        <div class="alert alert-success mb-0">
                            <i class="fa fa-check"></i> Receive signed &mdash; assets now belong to {{ $receive->employee->name ?? 'the new employee' }}.
                        </div>
                    @else
                        <a href="{{ route('receive.pdf', $receive->id) }}" target="_blank" class="btn btn-info btn-block mb-3">
                            <i class="fa fa-print"></i> Print Receiving Document
                        </a>

                        <form action="{{ route('device-transfer.receive.complete', $receive->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Signed Receiving Document <span class="text-danger">*</span></label>
                                <input type="file" name="receiving_signature" class="form-control" accept="image/*,application/pdf" required>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-upload"></i> Upload &amp; Sign Receive
                            </button>
                        </form>
                    @endif
                </section>
            </div>
        </div>

        @if($clearance->status == 'finished' && $receive->status == 'received')
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('device.index') }}" class="btn btn-primary btn-lg">
                    <i class="fa fa-check"></i> Transfer Complete &mdash; Back to Devices
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
