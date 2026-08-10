@extends('pdf.layout')

@php
    $pdfTitle = 'Employee Profile - ' . $employee->name;
    $documentType = 'Employee Profile';
    $documentCode = '#' . $employee->employee_id;
@endphp

@push('pdf-styles')
<style>
    .profile-head {
        display: table;
        width: 100%;
        margin-bottom: 18px;
    }
    .profile-head .photo-cell,
    .profile-head .id-cell {
        display: table-cell;
        vertical-align: middle;
    }
    .profile-head .photo-cell { width: 74px; }
    .profile-photo {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        border: 1.5px solid #D8DEE2;
    }
    .profile-head h1 { margin: 0 0 3px; }
    .profile-head .role {
        font-size: 10px;
        color: #5B6672;
    }
    .no-data { color: #8992A0; font-style: italic; }
</style>
@endpush

@section('content')

<div class="profile-head">
    <div class="photo-cell">
        @php
            $photoPath = $employee->profile_image && file_exists(public_path('X-Files/Dash/imgs/EmployeeProfilePic/' . $employee->profile_image))
                ? public_path('X-Files/Dash/imgs/EmployeeProfilePic/' . $employee->profile_image)
                : public_path('X-Files/Dash/imgs/EmployeeProfilePic/default_employee.png');
        @endphp
        <img class="profile-photo" src="{{ $photoPath }}" alt="{{ $employee->name }}">
    </div>
    <div class="id-cell">
        <h1 class="doc-title">{{ $employee->name }}</h1>
        <div class="role">{{ $employee->position->name ?? 'No position on record' }} &middot; Orion ID {{ $employee->employee_id }}</div>
    </div>
</div>

<div class="section-label">Basic Information</div>
<table class="meta">
    <tr>
        <td class="k">Department</td>
        <td class="v">{{ $employee->department->name ?? '-' }}</td>
        <td class="k">Position</td>
        <td class="v">{{ $employee->position->name ?? '-' }}</td>
    </tr>
    <tr>
        <td class="k">Hire Date</td>
        <td class="v">{{ $hireDate ?? '-' }}</td>
        <td class="k">Service Duration</td>
        <td class="v">
            @if ($diff)
                {{ $diff->y }}y {{ $diff->m }}m {{ $diff->d }}d
            @else
                <span class="no-data">Not available</span>
            @endif
        </td>
    </tr>
</table>

<div class="section-label">Contact Information</div>
<table class="meta">
    <tr>
        <td class="k">Orion Mobile</td>
        <td class="v mono">
            @if ($employee->sim_card->count() > 0)
                {{ $employee->sim_card->pluck('sim_number')->join(', ') }}
            @else
                <span class="no-data">No SIM card assigned</span>
            @endif
        </td>
        <td class="k">Orion Email</td>
        <td class="v">{{ $employee->orion_email ?: '-' }}</td>
    </tr>
    <tr>
        <td class="k">Personal Mobile</td>
        <td class="v">{{ $employee->personal_mobile ?: '-' }}</td>
        <td class="k">Personal Email</td>
        <td class="v">{{ $employee->personal_email ?: '-' }}</td>
    </tr>
</table>

@if ($employee->project)
<div class="section-label">Project</div>
<table class="meta">
    <tr>
        <td class="k">Project Name</td>
        <td class="v">{{ $employee->project->project_name }}</td>
        <td class="k">Project Code</td>
        <td class="v mono">{{ $employee->project->project_code }}</td>
    </tr>
</table>
@endif

@if ($employee->notes)
<div class="section-label">Notes</div>
<p style="font-size:9.5px; color:#5B6672;">{{ $employee->notes }}</p>
@endif

@endsection
