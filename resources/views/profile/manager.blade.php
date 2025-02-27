@extends('layouts.app')
@section('custom_css')
<style>
    .customize-thumbnails-gallery {
    display: flex;
    justify-content: space-between;
    }
    .customize-thumbnails-gallery a img{
    width: 250px;
    height: 250px;
    }
</style>
@endsection
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.1/css/lightgallery.min.css" integrity="sha512-QMCloGTsG2vNSnHcsxYTapI6pFQNnUP6yNizuLL5Wh3ha6AraI6HrJ3ABBaw6SIUHqlSTPQDs/SydiR98oTeaQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="hk-pg-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 pa-0">
                <div class="profile-cover-wrap overlay-wrap" style="min-height: 370px">
                    <div class="profile-cover-img"
                        style="background-image:url('{{ asset('X-Files/Dash/imgs/profile-back.webp') }}')">
                    </div>
                    <div class="bg-overlay bg-trans-dark-60"></div>
                    <div class="container profile-cover-content py-50">

                    </div>
                </div>
                <div class="bg-white shadow-bottom">
                    <div class="container">
                        <div class="row">


                        </div>
                    </div>
                </div>
                <div class="container  mt-sm-60 mt-30">
                    <div class="hk-pg-header" style="justify-content: center;">
                        <div>
                            <h2 class="hk-pg-title font-weight-600">{{ $manager->name }}</h2>
                        </div>
                        <div class="d-flex mb-0 flex-wrap">
                            <div class="btn-group btn-group-sm btn-group-rounded mb-15 ml-15" role="group">
                                <button type="button" class="btn btn-primary">ID : </button>
                                <button type="button" class="btn btn-outline-primary">{{ $manager->employee_id
                                    }}</button>
                            </div>
                            {{-- <button
                                class="btn btn-sm btn-outline-primary btn-rounded btn-wth-icon icon-wthot-bg mb-15"><span
                                    class="icon-label"><span class="feather-icon"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg></span> </span><span class="btn-text">new projects</span></button> --}}
                        </div>
                    </div>
                </div>
                <div class="tab-content mt-sm-60 mt-30">
                    <div class="" id="">
                        <div class="container">
                            <div class="hk-row">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <span
                                                class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Receives</span>
                                            <div
                                                class="d-flex align-items-center justify-content-between position-relative">
                                                <div>
                                                    <span class="d-block display-5 font-weight-400 text-dark">{{ $manager?->receives?->count() ?? 0 }}</span>
                                                </div>
                                                <div class="position-absolute r-0">
                                                    {{-- عدد الموظقيين في المشروع --}}
                                                    <span id="pie_chart_1" class="d-flex easy-pie-chart"
                                                        data-percent="86">

                                                        <canvas height="62" width="62"
                                                            style="height: 50px; width: 50px;"></canvas></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <span
                                                class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Clearances</span>
                                            <div
                                                class="d-flex align-items-center justify-content-between position-relative">
                                                <div>
                                                    <span class="d-block">
                                                        <span class="display-5 font-weight-400 text-dark"><span
                                                                class="counter-anim">{{
                                                                $manager?->clearance?->count() ?? 0 }}
                                                            </span></span>
                                                    </span>
                                                </div>
                                                {{-- عدد الكاميرات في المشروع --}}
                                                <div class="position-absolute r-0">
                                                    <span id="pie_chart_2" class="d-flex easy-pie-chart"
                                                        data-percent="75">

                                                        <canvas height="62" width="62"
                                                            style="height: 50px; width: 50px;"></canvas></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <span
                                                class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Devices</span>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <div>
                                                    <span class="d-block">
                                                        <span class="display-5 font-weight-400 text-dark">{{
                                                            $manager?->devices?->count() ?? 0 }}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="hk-row">
                                <div class="col-12">

                                    <div class="row">
                                        <div class="col-12 col-md-6 offset-md-3">
                                            <div class="card card-profile-feed">
                                                <div class="card-body" style="background-color:#10516a;border-radius: 10px;">
                                                    <div class="card">
                                                        <div class="position-relative" style="position: relative">
                                                            <img class="card-img-top d-block" src="{{ asset('X-Files/Dash/imgs/EmployeeProfilePic/'.$manager->profile_image) }}" alt="Card image cap">
                                                            @if ($manager->resign_date != null)
                                                                <div class="resigned-sign" style="position: absolute;top: 50%;left: 25%;z-index: 999;">
                                                                    <img width="280" src="{{ asset('X-Files/Dash/imgs/resigned.png') }}" alt="">
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="card-body">
                                                            <span style="font-size: 20px" class=" badge badge-soft-success mt-15 mr-10"><h5>{{ $manager->department->name }} - </h5></span>
                                                            <span style="font-size: 20px" class="badge badge-soft-warning mt-15 mr-10"><h5>{{ $manager->position->name }}</h5></span>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="profile-tabs">
                                                <ul class="tab-nav" id="list-tab" role="tablist">
                                                    <li>
                                                        <button class="tab-button active" data-tab="personalData">
                                                            <i class="ion ion-md-person"></i>
                                                            Personal Info
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="tab-button" data-tab="list-of-devices">
                                                            <i class="ion ion-md-laptop"></i>
                                                            My Devices
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="tab-button" data-tab="list-of-emps">
                                                            <i class="ion ion-md-people"></i>
                                                            My Employees
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="tab-button" data-tab="list-of-req">
                                                            <i class="ion ion-md-paper"></i>
                                                            My Requests
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="tab-button" data-tab="account-settings">
                                                            <i class="ion ion-md-lock"></i>
                                                            Account Settings
                                                        </button>
                                                    </li>
                                                </ul>

                                                <div class="tab-content">
                                                    {{-- Personal Info Tab --}}
                                                    <div class="tab-pane active" id="personalData">
                                                        <div class="profile-card">
                                                            <div class="profile-stats">
                                                                <div class="stat-box">
                                                                    <div class="stat-value">Years: {{ $diff->y }}, Months: {{ $diff->m }}, Days: {{ $diff->d }}</div>
                                                                    <div class="stat-label">Working For</div>
                                                                </div>
                                                                <div class="stat-box">
                                                                    <div class="stat-value">{{ $manager->department->name }}</div>
                                                                    <div class="stat-label">Department</div>
                                                                </div>
                                                            </div>

                                                            <ul class="info-list">
                                                                <li class="info-item">
                                                                    <i class="ion ion-md-calendar"></i>
                                                                    <span class="info-label">Hire Date:</span>
                                                                    <span>{{ $hireDate }}</span>
                                                                </li>
                                                                <li class="info-item">
                                                                    <i class="ion ion-md-briefcase"></i>
                                                                    <span class="info-label">Branch:</span>
                                                                    <span>Ras AlKhaima</span>
                                                                </li>
                                                                <li class="info-item">
                                                                    <i class="ion ion-md-phone-portrait"></i>
                                                                    <span class="info-label">Orion Mobile:</span>
                                                                    <span>
                                                                        @if ($manager->sim_card->count() > 0)
                                                                            @foreach ($manager->sim_card as $sim)
                                                                                <span class="badge badge-success">{{ $sim->sim_number }}</span>
                                                                            @endforeach
                                                                        @else
                                                                            <span class="badge badge-danger">No Sim Found</span>
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                <li class="info-item">
                                                                    <i class="ion ion-md-mail"></i>
                                                                    <span class="info-label">Orion Email:</span>
                                                                    <span>{{ $manager->orion_email ?? 'No Email Assigned' }}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    {{-- Devices Tab --}}
                                                    <div class="tab-pane" id="list-of-devices">
                                                        <div class="profile-card">
                                                            <div class="card-header">
                                                                <h3>Devices and Items <span class="badge badge-success">{{ $manager->devices->count() }}</span></h3>
                                                            </div>
                                                            @if ($manager->devices->count() > 0)
                                                                <div class="device-grid">
                                                                    @foreach ($manager->devices as $device)
                                                                        <div class="device-card">
                                                                            <img src="{{ asset('X-Files/Dash/imgs/devices/' . $device->main_image) }}"
                                                                                 alt="{{ $device->device_name }}"
                                                                                 class="device-image">
                                                                            <div class="device-name">{{ $device->device_name }}</div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <div class="p-4 text-center text-gray-500">
                                                                    No devices found
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    {{-- Employees Tab --}}
                                                    <div class="tab-pane" id="list-of-emps">
                                                        @livewire('employee-list-on-manager-view', ['managerId' => $manager->id])
                                                    </div>

                                                    {{-- Requests Tab --}}
                                                    <div class="tab-pane" id="list-of-req">
                                                        @livewire('user-asset-requests-component')
                                                    </div>

                                                    <div class="tab-pane" id="account-settings">
                                                        <div class="profile-card">
                                                            <div class="card-header">
                                                                <h3>Change Password</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                @if(session('success'))
                                                                    <div class="alert alert-success">
                                                                        {{ session('success') }}
                                                                    </div>
                                                                @endif

                                                                <form method="POST" action="{{ route('password.Manager.update') }}" class="p-4">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group mb-3">
                                                                        <label for="current_password">Current Password</label>
                                                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                                                               id="current_password" name="current_password" required>
                                                                        @error('current_password')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label for="new_password">New Password</label>
                                                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                                                               id="new_password" name="new_password" required>
                                                                        @error('new_password')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label for="new_password_confirmation">Confirm New Password</label>
                                                                        <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                                                               id="new_password_confirmation" name="new_password_confirmation" required>
                                                                        @error('new_password_confirmation')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>

                                                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
    // Get tab from URL query parameter or fragment
    const urlParams = new URLSearchParams(window.location.search);
    const tabFromUrl = urlParams.get('tab');
    const fragmentFromUrl = window.location.hash ? window.location.hash.substring(1) : null;

    const tabButtons = document.querySelectorAll('.tab-button');
    const tabPanes = document.querySelectorAll('.tab-pane');

    // Determine which tab to activate
    let tabToActivate = null;

    // Check for validation errors in the account-settings form
    const hasPasswordErrors = document.querySelectorAll('#account-settings .invalid-feedback').length > 0;

    if (hasPasswordErrors) {
        // If there are password validation errors, activate the account-settings tab
        tabToActivate = 'account-settings';
    } else if (fragmentFromUrl) {
        // If there's a fragment in the URL, use that
        tabToActivate = fragmentFromUrl;
    } else if (tabFromUrl) {
        // If there's a tab parameter in the URL, use that
        tabToActivate = tabFromUrl;
    }

    // Activate the determined tab
    if (tabToActivate) {
        tabPanes.forEach(pane => pane.classList.remove('active'));
        tabButtons.forEach(btn => btn.classList.remove('active'));

        const targetPane = document.getElementById(tabToActivate);
        const targetButton = document.querySelector(`[data-tab="${tabToActivate}"]`);

        if (targetPane && targetButton) {
            targetPane.classList.add('active');
            targetButton.classList.add('active');
        }
    }

    // Regular tab switching functionality
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            button.classList.add('active');
            document.getElementById(button.dataset.tab).classList.add('active');

            // Optionally update URL fragment
            window.history.replaceState(null, null, `#${button.dataset.tab}`);
        });
    });
});
                                    </script>
                                    <style>
                                        /* Tab Styles */
                                        .profile-tabs {
                                            padding: 2rem;
                                            max-width: 1200px;
                                            margin: 0 auto;
                                            background-color: lightblue;
                                            border-radius: 15px;
                                        }

                                        .tab-nav {
                                            display: flex;
                                            border-bottom: 2px solid #e5e7eb;
                                            margin-bottom: 1.5rem;
                                            gap: 0.5rem;
                                        }

                                        .tab-button {
                                            padding: 0.75rem 1.5rem;
                                            border: none;
                                            background: none;
                                            color: #6b7280;
                                            font-weight: 500;
                                            cursor: pointer;
                                            display: flex;
                                            align-items: center;
                                            gap: 0.5rem;
                                            border-bottom: 2px solid transparent;
                                            margin-bottom: -2px;
                                            transition: all 0.2s;
                                        }

                                        .tab-button:hover {
                                            color: #4b5563;
                                            background-color: #f9fafb;
                                        }

                                        .tab-button.active {
                                            color: #2563eb;
                                            border-bottom-color: #2563eb;
                                        }

                                        .tab-button i {
                                            font-size: 1.25rem;
                                        }

                                        /* Card Styles */
                                        .profile-card {
                                            background: white;
                                            border-radius: 0.5rem;
                                            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                                            margin-bottom: 1.5rem;
                                        }

                                        .profile-stats {
                                            display: grid;
                                            grid-template-columns: repeat(2, 1fr);
                                            gap: 1.5rem;
                                            margin-bottom: 2rem;
                                            text-align: center;
                                        }

                                        .stat-box {
                                            background: #f9fafb;
                                            padding: 1.5rem;
                                            border-radius: 0.5rem;
                                        }

                                        .stat-value {
                                            font-size: 1.5rem;
                                            font-weight: 600;
                                            color: #1f2937;
                                            margin-bottom: 0.5rem;
                                        }

                                        .stat-label {
                                            color: #6b7280;
                                            font-size: 0.875rem;
                                        }

                                        .info-list {
                                            list-style: none;
                                            padding: 0;
                                            margin: 0;
                                        }

                                        .info-item {
                                            display: flex;
                                            align-items: center;
                                            padding: 1rem;
                                            background: #f9fafb;
                                            border-radius: 0.5rem;
                                            margin-bottom: 0.75rem;
                                        }

                                        .info-item i {
                                            color: #9ca3af;
                                            margin-right: 1rem;
                                            font-size: 1.25rem;
                                        }

                                        .info-label {
                                            font-weight: 500;
                                            margin-right: 0.5rem;
                                            color: #374151;
                                        }

                                        /* Device Grid */
                                        .device-grid {
                                            display: grid;
                                            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                                            gap: 1rem;
                                            padding: 1rem;
                                        }

                                        .device-card {
                                            background: #f9fafb;
                                            border-radius: 0.5rem;
                                            overflow: hidden;
                                            transition: transform 0.2s;
                                        }

                                        .device-card:hover {
                                            transform: scale(1.02);
                                        }

                                        .device-image {
                                            aspect-ratio: 1;
                                            width: 100%;
                                            object-fit: cover;
                                        }

                                        .device-name {
                                            padding: 0.75rem;
                                            text-align: center;
                                            font-size: 0.875rem;
                                            color: #374151;
                                        }

                                        /* Table Styles */
                                        .table-container {
                                            overflow-x: auto;
                                        }

                                        .profile-table {
                                            width: 100%;
                                            border-collapse: separate;
                                            border-spacing: 0;
                                        }

                                        .profile-table th,
                                        .profile-table td {
                                            padding: 0.75rem 1rem;
                                            text-align: left;
                                        }

                                        .profile-table th {
                                            background: #f9fafb;
                                            font-weight: 500;
                                            color: #374151;
                                        }

                                        .profile-table tr {
                                            transition: background-color 0.2s;
                                        }

                                        .profile-table tr:hover {
                                            background-color: #f9fafb;
                                        }

                                        .profile-table td {
                                            border-bottom: 1px solid #e5e7eb;
                                        }

                                        .badge {
                                            display: inline-block;
                                            padding: 0.25rem 0.75rem;
                                            border-radius: 9999px;
                                            font-size: 0.75rem;
                                            font-weight: 500;
                                        }

                                        .badge-success {
                                            background: #dcfce7;
                                            color: #166534;
                                        }

                                        .badge-danger {
                                            background: #fee2e2;
                                            color: #991b1b;
                                        }

                                        .btn {
                                            display: inline-flex;
                                            align-items: center;
                                            padding: 0.5rem 1rem;
                                            border-radius: 0.375rem;
                                            font-size: 0.875rem;
                                            font-weight: 500;
                                            transition: all 0.2s;
                                        }

                                        .btn-info {
                                            background: #2563eb;
                                            color: white;
                                        }

                                        .btn-info:hover {
                                            background: #1d4ed8;
                                        }

                                        /* Responsive Design */
                                        @media (max-width: 768px) {
                                            .profile-stats {
                                                grid-template-columns: 1fr;
                                            }

                                            .tab-button {
                                                padding: 0.5rem 1rem;
                                            }

                                            .profile-tabs {
                                                padding: 1rem;
                                            }
                                        }
                                        </style>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                // Tab switching functionality
                                                const tabButtons = document.querySelectorAll('.tab-button');
                                                const tabPanes = document.querySelectorAll('.tab-pane');

                                                tabButtons.forEach(button => {
                                                    button.addEventListener('click', () => {
                                                        // Remove active class from all buttons and panes
                                                        tabButtons.forEach(btn => btn.classList.remove('active'));
                                                        tabPanes.forEach(pane => pane.classList.remove('active'));

                                                        // Add active class to clicked button and corresponding pane
                                                        button.classList.add('active');
                                                        document.getElementById(button.dataset.tab).classList.add('active');
                                                    });
                                                });
                                            });
                                            </script>
                                    <div class="row mt-30">
                                        <div class="col-auto">

                                            {{-- <a href="{{ route('employees.index') }}" style="display: inline-flex;align-items:center;" class="btn  mb-2 btn-gradient-danger btn-wth-icon icon-wthot-bg btn-rounded icon-left btn-lg">
                                                <i class="icon-logout"></i>
                                                <span class="btn-text">Back</span>
                                            </a>
                                            <a href="{{ route('employees.edit' , $manager->id) }}" class="btn mb-2 btn-gradient-bunting btn-wth-icon icon-wthot-bg btn-rounded icon-right btn-lg">
                                                <span class="btn-text">Edit</span> <span class="icon-label"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></span> </span>
                                            </a> --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection
