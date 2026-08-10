@extends('pdf.layout')

@php
    $pdfTitle = 'Receiving ' . $receive->code;
    $documentType = 'Receiving';
    $documentCode = '#' . $receive->code;
    $colorScheme = 'sapphire';
@endphp

@section('content')

<h1 class="doc-title">Receiving Details</h1>
<p class="doc-lede">
    I, the undersigned, acknowledge that I have received the items listed below,
    and agree to the terms and conditions on this document.
</p>

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
        <td class="v mono">{{ $receiver->employee_id }}</td>
        <td class="k">Department</td>
        <td class="v">{{ $receiver->department->name ?? '-' }}</td>
    </tr>
    @endif
    @if (($receiver->project_id ?? null) != null)
    <tr>
        <td class="k">Project</td>
        <td class="v mono" colspan="3">{{ $receiver->project->project_code ?? '-' }}</td>
    </tr>
    @endif
</table>

@if ($devicesData->count() > 0)
<div class="section-label">Devices</div>
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
<div class="section-label">SIM Cards</div>
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

<div class="section-label">Terms and Conditions</div>
<div class="terms-box">
<ul class="terms">
    <li>Do not make any unauthorized modifications or repairs to the equipment.</li>
    <li>Handle all equipment with care to avoid damage.</li>
    <li>Use appropriate packaging and protective materials during transportation and storage.</li>
    <li>For any updates, modifications, or fixes, the equipment must be returned to the IT department.</li>
    <li>All received equipment must be used exclusively for work-related purposes; personal use is strictly prohibited.</li>
    <li>SIM cards provided are for business communications only; personal calls and messages are not permitted.</li>
    <li>Any damage caused to the equipment due to negligence or misuse is the responsibility of the receiver.</li>
</ul>
</div>

<table class="sigblock">
    <tr>
        <td><div class="line">Receiver Signature</div></td>
        <td><div class="line">IT Manager</div></td>
        <td><div class="line">Top Management</div></td>
    </tr>
</table>

@endsection
