@extends('layouts.app')

@section('content')
@php
    $resigned = $filters['who'] === 'resigned';
    $query = array_filter(request()->only(['who', 'search', 'department', 'type', 'status']), fn ($v) => $v !== null && $v !== '');
    $badges = ['taken' => 'badge-success', 'pending-receiving' => 'badge-warning', 'pending-cancel' => 'badge-info'];
    $number = $employees->firstItem() ?? 0;
@endphp
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">
                    Devices With {{ $resigned ? 'Resigned' : 'Current' }} Employees
                </h2>
                <p style="text-transform:none">
                    @if($resigned)
                        Devices still recorded against people who have resigned. Each one was never collected, or never cleared.
                    @else
                        Every device a working employee has. People who have resigned are left out.
                    @endif
                </p>
            </div>
            <div>
                <a href="{{ route('reports.employee-devices.excel', $query) }}" class="btn btn-success mr-2">Export Excel</a>
                <a href="{{ route('reports.employee-devices.pdf', $query) }}" target="_blank" rel="noopener" class="btn btn-danger mr-2">Export PDF</a>
                <a href="{{ route('device.index') }}" class="btn btn-secondary">Devices</a>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <div class="d-flex flex-wrap align-items-center mb-20">
                            <a href="{{ route('reports.employee-devices') }}"
                               class="btn btn-sm mr-1 mb-1 {{ $resigned ? 'btn-secondary' : 'btn-primary' }}">Current employees</a>
                            <a href="{{ route('reports.employee-devices', ['who' => 'resigned']) }}"
                               class="btn btn-sm mr-3 mb-1 {{ $resigned ? 'btn-primary' : 'btn-secondary' }}">
                                Resigned, still holding
                                <span class="badge {{ $resignedHolding['devices'] ? 'badge-danger' : 'badge-light' }} ml-1">{{ $resignedHolding['devices'] }}</span>
                            </a>

                            <span class="mr-3 mb-1"><strong>{{ $totals['employees'] }}</strong> employees</span>
                            <span class="mr-3 mb-1"><strong>{{ $totals['devices'] }}</strong> devices</span>
                            @foreach($totals['by_type'] as $kind => $count)
                            <span class="badge badge-light mr-1 mb-1">{{ $kind }} {{ $count }}</span>
                            @endforeach
                        </div>

                        <form method="GET" action="{{ route('reports.employee-devices') }}" class="form-inline mb-20">
                            @if($resigned)
                            <input type="hidden" name="who" value="resigned">
                            @endif
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend"><div class="input-group-text">Search</div></div>
                                <input type="text" name="search" class="form-control" style="min-width:260px"
                                       placeholder="Name, Orion ID, device code, serial" value="{{ $filters['search'] }}">
                            </div>
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend"><div class="input-group-text">Department</div></div>
                                <select name="department" class="form-control">
                                    <option value="">All</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ $filters['department'] === $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend"><div class="input-group-text">Type</div></div>
                                <select name="type" class="form-control">
                                    <option value="">All</option>
                                    @foreach($types as $type)
                                    <option value="{{ $type }}" {{ $filters['type'] === $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend"><div class="input-group-text">Status</div></div>
                                <select name="status" class="form-control">
                                    <option value="">All</option>
                                    @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ $filters['status'] === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Filter</button>
                            @if($filters['search'] !== '' || $filters['department'] || $filters['type'] !== '' || $filters['status'] !== '')
                            <a href="{{ route('reports.employee-devices', $resigned ? ['who' => 'resigned'] : []) }}" class="btn btn-secondary mb-2 ml-2">Clear</a>
                            @endif
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Orion ID</th>
                                        <th>Employee</th>
                                        <th>Department</th>
                                        <th>Project</th>
                                        <th>Device Code</th>
                                        <th>Device</th>
                                        <th>Type</th>
                                        <th>Serial No</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($employees as $employee)
                                        @foreach($employee->devices as $device)
                                        <tr>
                                            @if($loop->first)
                                            @php $span = $employee->devices->count(); @endphp
                                            <td rowspan="{{ $span }}" class="text-muted">{{ $number++ }}</td>
                                            <td rowspan="{{ $span }}" style="font-family:Consolas,monospace">{{ $employee->employee_id ?: '-' }}</td>
                                            <td rowspan="{{ $span }}">
                                                <a href="{{ route('employees.show', $employee->id) }}">{{ $employee->name }}</a>
                                                @if($employee->registration_pending)
                                                <span class="badge badge-warning">not registered yet</span>
                                                @endif
                                                <small class="d-block text-muted">{{ $span }} {{ $span === 1 ? 'device' : 'devices' }}</small>
                                            </td>
                                            <td rowspan="{{ $span }}">{{ $employee->department?->name ?? '-' }}</td>
                                            <td rowspan="{{ $span }}">{{ $employee->project?->project_code ?? '-' }}</td>
                                            @endif
                                            <td style="font-family:Consolas,monospace">
                                                <a href="{{ route('device.show', $device->id) }}">{{ $device->device_code }}</a>
                                            </td>
                                            <td>{{ $device->device_name ?: '-' }}{{ $device->device_model ? ' / ' . $device->device_model : '' }}</td>
                                            <td>{{ $device->device_type ?: '-' }}</td>
                                            <td style="font-family:Consolas,monospace">{{ $device->serial_number ?: '-' }}</td>
                                            <td>
                                                <span class="badge {{ $badges[$device->status] ?? 'badge-secondary' }}">
                                                    {{ \App\Http\Controllers\EmployeeDeviceReportController::statusLabel($device->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center" style="text-transform:none">
                                            @if($resigned)
                                                No device is recorded against a resigned employee.
                                            @else
                                                No current employee has a device that matches.
                                            @endif
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $employees->links('pagination::bootstrap-4') }}
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
