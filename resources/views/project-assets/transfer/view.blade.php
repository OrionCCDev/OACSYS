@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Transfer Details - {{ $transfer->transfer_code }}</h2>
                <p>
                    <strong>From:</strong> {{ $transfer->fromProject->project_name }}
                    <strong class="ml-3">To:</strong> {{ $transfer->toProject->project_name }}
                </p>
            </div>
            <div>
                <a href="{{ route('project-assets.show', $transfer->from_project_id) }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <strong>Transfer Code:</strong><br>
                            {{ $transfer->transfer_code }}
                        </div>
                        <div class="col-md-3">
                            <strong>Status:</strong><br>
                            @if($transfer->status == 'completed')
                                <span class="badge badge-success">Completed</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <strong>Transferred By:</strong><br>
                            {{ $transfer->transferredBy->name ?? 'N/A' }}
                        </div>
                        <div class="col-md-3">
                            <strong>Transfer Date:</strong><br>
                            {{ $transfer->transferred_at ? $transfer->transferred_at->format('Y-m-d H:i') : 'Pending' }}
                        </div>
                    </div>

                    @php
                        $devices = $allTransfers->filter(function($t) { return $t->device_id != null; });
                        $simCards = $allTransfers->filter(function($t) { return $t->sim_card_id != null; });
                    @endphp

                    <!-- Devices -->
                    @if($devices->count() > 0)
                    <h5 class="hk-sec-title mt-4">Devices Transferred</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Device Name</th>
                                    <th>Device Code</th>
                                    <th>Type</th>
                                    <th>Model</th>
                                    <th>Transfer Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($devices as $transferRecord)
                                <tr>
                                    <td>{{ $transferRecord->device->device_name }}</td>
                                    <td>{{ $transferRecord->device->device_code }}</td>
                                    <td>{{ $transferRecord->device->device_type }}</td>
                                    <td>{{ $transferRecord->device->device_model }}</td>
                                    <td>{{ $transferRecord->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <!-- SIM Cards -->
                    @if($simCards->count() > 0)
                    <h5 class="hk-sec-title mt-4">SIM Cards Transferred</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>SIM Number</th>
                                    <th>Provider</th>
                                    <th>Plan</th>
                                    <th>Transfer Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($simCards as $transferRecord)
                                <tr>
                                    <td>{{ $transferRecord->simCard->sim_number }}</td>
                                    <td>{{ $transferRecord->simCard->sim_provider }}</td>
                                    <td>{{ $transferRecord->simCard->sim_plan }}</td>
                                    <td>{{ $transferRecord->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <!-- Signature -->
                    @if($transfer->status == 'completed' && $transfer->transfer_image)
                    <div class="row mt-4">
                        <div class="col-md-6 offset-md-3">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Transfer Signature</h5>
                                </div>
                                <div class="card-body text-center">
                                    <img src="{{ asset('X-Files/Dash/imgs/transfers/' . $transfer->transfer_image) }}" alt="Transfer Signature" class="img-fluid" style="max-height: 400px; border: 1px solid #ddd; padding: 10px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
