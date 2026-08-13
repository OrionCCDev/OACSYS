@extends('pdf.layout')

@php
    $pdfTitle = ($isResignation ? 'Resignation Clearance ' : 'Clearance ') . $clearance->clear_code;
    $documentType = $isResignation ? 'Resignation Clearance' : 'Clearance';
    $documentCode = '#' . $clearance->clear_code;
    $colorScheme = $isResignation ? 'ruby' : 'emerald';
@endphp

@section('content')

<h1 class="doc-title">{{ $isResignation ? 'Resignation Clearance' : 'Clearance Details' }}</h1>
<p class="doc-lede">
    @if ($isResignation)
        I, the undersigned, confirm my resignation from Orion Contracting Company and acknowledge
        that all company property listed below has been returned in the condition noted.
    @else
        I, the undersigned, confirm that the items listed below have been returned to
        Orion Contracting Company in the condition noted.
    @endif
</p>

@if ($receiver_type == 'project')
<table class="meta">
    <tr>
        <td class="k">Date</td>
        <td class="v">{{ now()->format('Y-m-d') }}</td>
        <td class="k">Project</td>
        <td class="v">{{ $project->project_name ?? '-' }}</td>
    </tr>
    <tr>
        <td class="k">Project Code</td>
        <td class="v mono">{{ $project->project_code ?? '-' }}</td>
        <td class="k">Project Manager</td>
        <td class="v">{{ $receiver->name ?? '-' }}</td>
    </tr>
</table>
@elseif ($receiver_type == 'department')
<table class="meta">
    <tr>
        <td class="k">Date</td>
        <td class="v">{{ now()->format('Y-m-d') }}</td>
        <td class="k">Department</td>
        <td class="v">{{ $department->name ?? '-' }}</td>
    </tr>
    <tr>
        <td class="k">Department Manager</td>
        <td class="v">{{ $receiver->name ?? '-' }}</td>
        <td class="k">Orion ID</td>
        <td class="v mono">{{ $receiver->employee_id ?? '-' }}</td>
    </tr>
</table>
@else
<table class="meta">
    <tr>
        <td class="k">Date</td>
        <td class="v">{{ now()->format('Y-m-d') }}</td>
        <td class="k">Name</td>
        <td class="v">{{ $receiver->name ?? '-' }}</td>
    </tr>
    @if ($receiver_type == 'employee')
    <tr>
        <td class="k">Orion ID</td>
        <td class="v mono">{{ $receiver->employee_id ?? '-' }}</td>
        <td class="k">Department</td>
        <td class="v">{{ $receiver->department->name ?? '-' }}</td>
    </tr>
    @endif
</table>
@endif

@if ($devicesData->count() > 0)
<div class="section-label">Devices Returned</div>
<table class="items">
    <thead>
        <tr><th>Code</th><th>Name</th><th>Type</th><th>Model</th></tr>
    </thead>
    <tbody>
        @foreach ($devicesData as $device)
        <tr>
            <td class="mono">{{ $device->device_code }}</td>
            <td>{{ $device->device_name }}</td>
            <td>{{ $device->device_type }}</td>
            <td>{{ $device->device_model }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@if ($simCardsData->count() > 0)
<div class="section-label">SIM Cards Returned</div>
<table class="items">
    <thead>
        <tr><th>Number</th><th>Plan</th><th>Provider</th></tr>
    </thead>
    <tbody>
        @foreach ($simCardsData as $sim)
        <tr>
            <td class="mono">{{ $sim->sim_number }}</td>
            <td>{{ $sim->sim_plan }}</td>
            <td>{{ $sim->sim_provider }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@if ($devicesData->count() == 0 && $simCardsData->count() == 0)
<p style="color:#8992A0; font-size:9.5px;">No devices or SIM cards were on record for this clearance.</p>
@endif

<div class="section-label">Terms and Conditions</div>
<div class="terms-box">
<ul class="terms">
    <li>All items above have been inspected and are accepted back into Orion Contracting Company inventory.</li>
    <li>Any pre-existing damage or missing accessories should be noted separately from this form.</li>
    @if ($isResignation)
    <li>Final settlement, if any, is contingent on the return of all company property listed above.</li>
    <li>This clearance does not itself constitute proof of final payment or release of other obligations.</li>
    @else
    <li>Returned devices remain Orion Contracting Company property and may be reissued to other staff.</li>
    @endif
</ul>
</div>

<table class="sigblock">
    <tr>
        <td><div class="line">{{ $isResignation ? 'Employee Signature' : 'Returning Signature' }}</div></td>
        <td><div class="line">IT Manager</div></td>
        @if ($receiver_type == 'project')
        <td><div class="line">Project Manager{{ ($receiver->name ?? null) ? ' — ' . $receiver->name : '' }}</div></td>
        @elseif ($receiver_type == 'department')
        <td><div class="line">Department Manager{{ ($receiver->name ?? null) ? ' — ' . $receiver->name : '' }}</div></td>
        @else
        <td><div class="line">Top Management</div></td>
        @endif
    </tr>
</table>

@endsection
