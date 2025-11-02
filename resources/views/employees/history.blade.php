@extends('layouts.app')

@section('custom_css')
<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        position: relative;
        padding-left: 60px;
        padding-bottom: 30px;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: -30px;
        width: 2px;
        background: #e0e0e0;
    }

    .timeline-item:last-child::before {
        display: none;
    }

    .timeline-icon {
        position: absolute;
        left: 0;
        top: 5px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        z-index: 1;
    }

    .timeline-icon.receive {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .timeline-icon.clearance {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .timeline-content {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-received, .status-finished {
        background-color: #d4edda;
        color: #155724;
    }

    .status-pending_resign {
        background-color: #f8d7da;
        color: #721c24;
    }

    .status-resigned {
        background-color: #d6d8db;
        color: #383d41;
    }

    .item-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }

    .item-badge {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 13px;
    }

    .item-badge.device {
        border-left: 4px solid #007bff;
    }

    .item-badge.simcard {
        border-left: 4px solid #28a745;
    }

    .summary-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
    }

    .summary-item {
        text-align: center;
    }

    .summary-number {
        font-size: 36px;
        font-weight: 700;
        display: block;
    }

    .summary-label {
        font-size: 14px;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>
@endsection

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="row">
            <div class="col-12">
                <section class="hk-sec-wrapper">
                    <div class="d-flex justify-content-between align-items-center mb-20">
                        <div>
                            <h5 class="hk-sec-title">Employee Asset History</h5>
                            <p class="mb-0">{{ $employee->name }} (ID: {{ $employee->employee_id }})</p>
                        </div>
                        <div>
                            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-outline-secondary btn-rounded">
                                <i class="icon-arrow-left"></i> Back to Profile
                            </a>
                        </div>
                    </div>
                </section>

                <!-- Summary Cards -->
                <div class="summary-card">
                    <div class="row">
                        <div class="col-md-3 summary-item">
                            <span class="summary-number">{{ $employee->devices->count() }}</span>
                            <span class="summary-label">Current Devices</span>
                        </div>
                        <div class="col-md-3 summary-item">
                            <span class="summary-number">{{ $employee->sim_card->count() }}</span>
                            <span class="summary-label">Current SIM Cards</span>
                        </div>
                        <div class="col-md-3 summary-item">
                            <span class="summary-number">{{ $employee->receives->count() }}</span>
                            <span class="summary-label">Total Receives</span>
                        </div>
                        <div class="col-md-3 summary-item">
                            <span class="summary-number">{{ $employee->clearance->count() }}</span>
                            <span class="summary-label">Total Clearances</span>
                        </div>
                    </div>
                </div>

                <!-- Current Assets -->
                @if($employee->devices->count() > 0 || $employee->sim_card->count() > 0)
                <section class="hk-sec-wrapper mb-30">
                    <h6 class="mb-15">Current Assets</h6>
                    <div class="card">
                        <div class="card-body">
                            @if($employee->devices->count() > 0)
                            <div class="mb-20">
                                <h6 class="text-primary mb-10"><i class="icon-monitor mr-5"></i> Devices</h6>
                                <div class="item-list">
                                    @foreach($employee->devices as $device)
                                    <div class="item-badge device">
                                        <strong>{{ $device->device_name }}</strong><br>
                                        <small>{{ $device->device_type }} - {{ $device->device_code }}</small>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($employee->sim_card->count() > 0)
                            <div>
                                <h6 class="text-success mb-10"><i class="icon-phone mr-5"></i> SIM Cards</h6>
                                <div class="item-list">
                                    @foreach($employee->sim_card as $sim)
                                    <div class="item-badge simcard">
                                        <strong>{{ $sim->sim_number }}</strong><br>
                                        <small>{{ $sim->sim_provider }} - {{ $sim->sim_plan }}</small>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </section>
                @endif

                <!-- History Timeline -->
                <section class="hk-sec-wrapper">
                    <h6 class="mb-20">Complete History Timeline</h6>

                    @if($history->isEmpty())
                    <div class="card">
                        <div class="card-body text-center py-50">
                            <i class="icon-info font-50 text-muted mb-20"></i>
                            <p class="text-muted">No history records found for this employee.</p>
                        </div>
                    </div>
                    @else
                    <div class="timeline">
                        @foreach($history as $record)
                        <div class="timeline-item">
                            <div class="timeline-icon {{ $record->type }}">
                                @if($record->type == 'receive')
                                    <i class="icon-download"></i>
                                @else
                                    <i class="icon-upload"></i>
                                @endif
                            </div>

                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-start mb-15">
                                    <div>
                                        <h6 class="mb-5">
                                            @if($record->type == 'receive')
                                                <i class="icon-download text-primary mr-5"></i> Asset Receipt
                                            @else
                                                <i class="icon-upload text-danger mr-5"></i> Asset Clearance
                                            @endif
                                        </h6>
                                        <small class="text-muted">
                                            <i class="icon-calendar mr-5"></i>
                                            {{ $record->created_at->format('F j, Y - g:i A') }}
                                        </small>
                                    </div>
                                    <div>
                                        <span class="status-badge status-{{ str_replace('-', '_', $record->status) }}">
                                            {{ $record->status }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-10">
                                    <strong>Code:</strong>
                                    @if($record->type == 'receive')
                                        <code>{{ $record->code }}</code>
                                    @else
                                        <code>{{ $record->clear_code }}</code>
                                    @endif
                                </div>

                                @if($record->devices_list->count() > 0)
                                <div class="mb-15">
                                    <h6 class="text-primary mb-10"><i class="icon-monitor mr-5"></i> Devices ({{ $record->devices_list->count() }})</h6>
                                    <div class="item-list">
                                        @foreach($record->devices_list as $device)
                                        <div class="item-badge device">
                                            <strong>{{ $device->device_name }}</strong><br>
                                            <small>{{ $device->device_type }} - {{ $device->device_code }}</small>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if($record->simcards_list->count() > 0)
                                <div class="mb-15">
                                    <h6 class="text-success mb-10"><i class="icon-phone mr-5"></i> SIM Cards ({{ $record->simcards_list->count() }})</h6>
                                    <div class="item-list">
                                        @foreach($record->simcards_list as $sim)
                                        <div class="item-badge simcard">
                                            <strong>{{ $sim->sim_number }}</strong><br>
                                            <small>{{ $sim->sim_provider }}</small>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <div class="mt-15">
                                    @if($record->type == 'receive')
                                        <a href="{{ route('employee.receive.detail', $record->id) }}" class="btn btn-sm btn-primary btn-rounded">
                                            <i class="icon-eye mr-5"></i> View Details
                                        </a>
                                    @else
                                        <a href="{{ route('employee.clearance.detail', $record->id) }}" class="btn btn-sm btn-danger btn-rounded">
                                            <i class="icon-eye mr-5"></i> View Details
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </section>

                <!-- Statistics -->
                <section class="hk-sec-wrapper mt-30">
                    <h6 class="mb-20">Statistics</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="text-primary mb-15">Receives Breakdown</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td>Received</td>
                                            <td class="text-right"><span class="badge badge-success">{{ $employee->receives->where('status', 'received')->count() }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Pending</td>
                                            <td class="text-right"><span class="badge badge-warning">{{ $employee->receives->where('status', 'pending')->count() }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td class="text-right"><strong>{{ $employee->receives->count() }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="text-danger mb-15">Clearances Breakdown</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td>Finished</td>
                                            <td class="text-right"><span class="badge badge-success">{{ $employee->clearance->where('status', 'finished')->count() }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Pending</td>
                                            <td class="text-right"><span class="badge badge-warning">{{ $employee->clearance->where('status', 'pending')->count() }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Resignation</td>
                                            <td class="text-right"><span class="badge badge-secondary">{{ $employee->clearance->whereIn('status', ['pending_resign', 'resigned'])->count() }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td class="text-right"><strong>{{ $employee->clearance->count() }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="row mt-30">
                    <div class="col-auto">
                        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-gradient-secondary btn-wth-icon icon-wthot-bg btn-rounded icon-left btn-lg">
                            <i class="icon-arrow-left"></i>
                            <span class="btn-text">Back to Profile</span>
                        </a>
                        <a href="{{ route('employees.index') }}" class="btn btn-gradient-primary btn-wth-icon icon-wthot-bg btn-rounded icon-right btn-lg">
                            <span class="btn-text">All Employees</span>
                            <i class="icon-users"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
