@extends('layouts.app')
@section('content')
@php
    $nameParts = preg_split('/\s+/', trim(Auth::user()->name));
    $initials = strtoupper(mb_substr($nameParts[0] ?? '', 0, 1) . mb_substr($nameParts[1] ?? '', 0, 1));
    $department = Auth::user()->employee?->department?->name;
@endphp
<!-- Main Content -->
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">

        <div class="crystal-context-row">
            <div class="crystal-context-item">
                <span class="crystal-context-label">Signed in as</span>
                <span class="crystal-context-value">{{ Auth::user()->name }}</span>
            </div>
            @if($department)
            <div class="crystal-context-item">
                <span class="crystal-context-label">Department</span>
                <span class="crystal-context-value">{{ $department }}</span>
            </div>
            @endif
            <span class="crystal-avatar">{{ $initials }}</span>
        </div>

        <div class="hk-pg-header crystal-masthead">
            <div>
                <h1 class="crystal-masthead-title">System Management</h1>
                <p class="crystal-masthead-subtitle">Equipment, SIM, and personnel operations across the company.</p>
            </div>
            <div class="crystal-masthead-time">
                <span class="crystal-date" id="crystalDate"></span>
                <span class="crystal-clock" id="crystalClock"></span>
            </div>
        </div>

        <div>
            @if (Auth::user()->hasRole('o-super-admin') || Auth::user()->hasRole('o-admin'))

                <div class="crystal-section-label">Dispatch</div>
                <div class="row">
                    <div class="col-12 col-md-4 my-10">
                        <a href="{{ route('receive.create') }}" class="crystal-tile">
                            <span class="crystal-tile-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16.5 9.4 7.55 4.24"></path>
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    <polyline points="3.29 7 12 12 20.71 7"></polyline>
                                    <line x1="12" y1="22" x2="12" y2="12"></line>
                                </svg>
                            </span>
                            <span class="crystal-tile-title">Issue Equipment</span>
                            <span class="crystal-tile-subtitle">Start a new receiving</span>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 my-10">
                        <a href="{{ route('clearance.index') }}" class="crystal-tile">
                            <span class="crystal-tile-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                            </span>
                            <span class="crystal-tile-title">Process Clearance</span>
                            <span class="crystal-tile-subtitle">Record a return</span>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 my-10">
                        <a href="{{ route('employees.index') }}" class="crystal-tile">
                            <span class="crystal-tile-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <line x1="18" y1="8" x2="23" y2="13"></line>
                                    <line x1="23" y1="8" x2="18" y2="13"></line>
                                </svg>
                            </span>
                            <span class="crystal-tile-title">Process Resignation</span>
                            <span class="crystal-tile-subtitle">Offboard an employee</span>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 my-10">
                        <a href="{{ url('import-simcards') }}" class="crystal-tile">
                            <span class="crystal-tile-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                    <line x1="12" y1="18" x2="12.01" y2="18"></line>
                                </svg>
                            </span>
                            <span class="crystal-tile-title">Import SIM Roster</span>
                            <span class="crystal-tile-subtitle">Bulk upload from Excel</span>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 my-10">
                        <a href="{{ url('import-employees') }}" class="crystal-tile">
                            <span class="crystal-tile-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <line x1="20" y1="8" x2="20" y2="14"></line>
                                    <line x1="23" y1="11" x2="17" y2="11"></line>
                                </svg>
                            </span>
                            <span class="crystal-tile-title">Import Employee Roster</span>
                            <span class="crystal-tile-subtitle">Bulk upload from Excel</span>
                        </a>
                    </div>
                </div>

                <div class="crystal-section-label">Fleet &amp; Headcount</div>
                <div class="row">
                    <div class="col-6 col-md-4 col-xl-2 my-10">
                        <div class="crystal-stat">
                            <span class="crystal-stat-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </span>
                            <span class="crystal-stat-label">Employees</span>
                            <span class="crystal-stat-number">{{ $employees_count }}</span>
                            @if($employees_new_this_month > 0)
                                <span class="crystal-stat-delta crystal-up">+{{ $employees_new_this_month }} this month</span>
                            @else
                                <span class="crystal-stat-note">headcount</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2 my-10">
                        <div class="crystal-stat">
                            <span class="crystal-stat-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                            </span>
                            <span class="crystal-stat-label">Projects</span>
                            <span class="crystal-stat-number">{{ $project_count }}</span>
                            @if($project_new_this_month > 0)
                                <span class="crystal-stat-delta crystal-up">+{{ $project_new_this_month }} this month</span>
                            @else
                                <span class="crystal-stat-note">in progress</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2 my-10">
                        <div class="crystal-stat">
                            <span class="crystal-stat-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"></path><path d="M5 21V7l8-4v18"></path><path d="M19 21V11l-6-4"></path></svg>
                            </span>
                            <span class="crystal-stat-label">Departments</span>
                            <span class="crystal-stat-number">{{ $department_count }}</span>
                            <span class="crystal-stat-note">active</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2 my-10">
                        <div class="crystal-stat">
                            <span class="crystal-stat-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="10" rx="2" ry="2"></rect><line x1="6" y1="18" x2="6.01" y2="18"></line><line x1="10" y1="18" x2="10.01" y2="18"></line></svg>
                            </span>
                            <span class="crystal-stat-label">Routers</span>
                            <span class="crystal-stat-number">{{ $routers_count }}</span>
                            <span class="crystal-stat-note">in fleet</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2 my-10">
                        <div class="crystal-stat">
                            <span class="crystal-stat-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="2" y1="21" x2="22" y2="21"></line></svg>
                            </span>
                            <span class="crystal-stat-label">Laptops</span>
                            <span class="crystal-stat-number">{{ $laptop_count }}</span>
                            <span class="crystal-stat-note">in fleet</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2 my-10">
                        <div class="crystal-stat">
                            <span class="crystal-stat-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                            </span>
                            <span class="crystal-stat-label">Cameras</span>
                            <span class="crystal-stat-number">{{ $camera_count }}</span>
                            <span class="crystal-stat-note">in fleet</span>
                        </div>
                    </div>
                </div>

                <div class="crystal-section-label">Equipment Condition</div>
                <div class="crystal-condition-card">
                    <div class="crystal-condition-head">
                        <span>{{ $devices_tracked }} devices tracked, all categories</span>
                        <span class="crystal-condition-updated"><span class="crystal-live-dot"></span>Live</span>
                    </div>
                    @if($devices_tracked > 0)
                        <div class="crystal-condition-bar">
                            @foreach($healthBreakdown as $row)
                                <span class="crystal-condition-seg crystal-condition-{{ $row['color'] }}" style="width: {{ $row['percent'] }}%" title="{{ $row['label'] }}: {{ $row['percent'] }}%"></span>
                            @endforeach
                        </div>
                        <div class="crystal-condition-legend">
                            @foreach($healthBreakdown as $row)
                                <span class="crystal-condition-legend-item">
                                    <span class="crystal-condition-dot crystal-condition-{{ $row['color'] }}"></span>
                                    {{ $row['label'] }} {{ $row['percent'] }}%
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="crystal-stat-note mb-0">No devices recorded yet.</p>
                    @endif
                </div>

                <div class="crystal-section-label">Recent Activity</div>
                <div class="crystal-activity-card">
                    @forelse($recentActivity as $item)
                        <a href="{{ $item['url'] }}" class="crystal-activity-row">
                            <span class="crystal-activity-code">{{ $item['code'] }}</span>
                            <span class="crystal-activity-title">{{ $item['title'] }}</span>
                            <span class="crystal-activity-subtitle">{{ $item['subtitle'] }}</span>
                            <span class="crystal-activity-time">{{ $item['time_label'] }}</span>
                        </a>
                    @empty
                        <p class="crystal-stat-note mb-0">No activity recorded yet.</p>
                    @endforelse
                </div>

            @elseif(Auth::user()->hasRole('o-manager'))

                <div class="crystal-section-label">Dispatch</div>
                <div class="row">
                    <div class="col-12 col-md-4 my-10">
                        <a href="{{ route('manager.show', ['manager' => Auth::user()->employee_profile_id]) }}" class="crystal-tile">
                            <span class="crystal-tile-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <span class="crystal-tile-title">Show My Profile</span>
                            <span class="crystal-tile-subtitle">View your record</span>
                        </a>
                    </div>
                </div>

            @endif
        </div>

    </div>
    <!-- /Container -->

    <!-- Footer -->
    <div class="hk-footer-wrap container">
        <footer class="footer">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <p>Designed by <a href="https://orioncc.com/" class="text-dark" target="_blank">IT-Department</a> &copy; 2024</p>
                </div>
            </div>
        </footer>
    </div>
    <!-- /Footer -->
</div>
<!-- /Main Content -->
<script>
    (function () {
        var dateEl = document.getElementById('crystalDate');
        var clockEl = document.getElementById('crystalClock');
        if (!dateEl || !clockEl) return;
        function tick() {
            var now = new Date();
            dateEl.textContent = now.toLocaleDateString(undefined, { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' }).toUpperCase();
            clockEl.textContent = now.toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit' });
        }
        tick();
        setInterval(tick, 30000);
    })();
</script>
@endsection
