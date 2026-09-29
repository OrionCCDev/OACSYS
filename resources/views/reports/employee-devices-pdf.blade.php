@extends('pdf.layout')

@php
    $resigned = $filters['who'] === 'resigned';
    $pdfTitle = 'Devices with ' . ($resigned ? 'resigned' : 'current') . ' employees';
    $documentType = 'Report';
    $documentCode = now()->format('Y-m-d');
    $colorScheme = $resigned ? 'ruby' : 'sapphire';
@endphp

@section('content')

<h1 class="doc-title">Devices With {{ $resigned ? 'Resigned' : 'Current' }} Employees</h1>
<p class="doc-lede" style="max-width:none">
    {{ $describe }}<br>
    {{ $totals['employees'] }} employees, {{ $totals['devices'] }} devices
    @if(count($totals['by_type']))
        ({{ collect($totals['by_type'])->map(fn ($count, $kind) => $kind . ' ' . $count)->implode(', ') }})
    @endif
</p>

<table class="items">
    <thead>
        <tr>
            <th style="width:4%">SL</th>
            <th style="width:9%">Orion ID</th>
            <th style="width:14%">Employee</th>
            <th style="width:11%">Position</th>
            <th style="width:9%">Department</th>
            <th style="width:7%">Project</th>
            <th style="width:11%">Device Code</th>
            <th style="width:13%">Device</th>
            <th style="width:6%">Type</th>
            <th style="width:9%">Serial No</th>
            <th style="width:8%">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rows as $row)
        <tr>
            <td>{{ $row['sl_no'] }}</td>
            <td class="mono">{{ $row['orion_id'] ?: '-' }}</td>
            <td>{{ $row['employee'] }}</td>
            <td>{{ $row['position'] ?: '-' }}</td>
            <td>{{ $row['department'] ?: '-' }}</td>
            <td class="mono">{{ $row['project'] ?: '-' }}</td>
            <td class="mono">{{ $row['device_code'] }}</td>
            <td>{{ $row['device_name'] ?: '-' }}{{ $row['device_model'] ? ' / ' . $row['device_model'] : '' }}</td>
            <td>{{ $row['device_type'] ?: '-' }}</td>
            <td class="mono">{{ $row['serial_number'] ?: '-' }}</td>
            <td>{{ $row['status'] }}</td>
        </tr>
        @empty
        <tr><td colspan="11" style="text-align:center">No devices to list.</td></tr>
        @endforelse
    </tbody>
</table>

<table class="sigblock">
    <tr>
        <td><div class="line">IT Manager</div></td>
    </tr>
</table>

@endsection
