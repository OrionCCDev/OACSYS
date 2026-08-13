<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Orion Sys Control</title>
    <meta name="description" content="IT - Department Dashboard Sys Control" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('X-Files/Dash/loader.png') }}">
    <link rel="icon" href="{{ asset('X-Files/Dash/loader.png') }}" type="image/x-icon">

    <!-- vector map CSS -->
    <link href="{{ asset('X-Files/Dash/vendors/vectormap/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Toggles CSS -->
    <link href="{{ asset('X-Files/Dash/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('X-Files/Dash/vendors/jquery-toggles/css/toggles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('X-Files/Dash/vendors/jquery-toggles/css/themes/toggles-light.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('X-Files/Dash/vendors/jquery-toggles/css/toggles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('X-Files/Dash/vendors/jquery-toggles/css/themes/toggles-light.css') }}" rel="stylesheet"
        type="text/css">
    <!-- Toastr CSS -->
    <link href="{{ asset('X-Files/Dash/vendors/jquery-toast-plugin/dist/jquery.toast.min.css') }}" rel="stylesheet"
        type="text/css">

    <!-- Font Awesome (bundled with the template but never linked - fa-* icons across the app were invisible) -->
    <link href="{{ asset('X-Files/Dash/dist/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="{{ asset('X-Files/Dash/dist/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('X-Files/Dash/dist/css/crystal-dark.css') }}" rel="stylesheet" type="text/css">
    @yield('custom_css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles()
    <style>
        .dropdown-notifications .badge-indicator {
        position: absolute;
        top: 5px;
        right: 2px;
        font-size: 20px;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .notification-dropdown {
        width: 300px;
        max-height: 400px;
        overflow-y: auto;
    }

    .notifications-wrap {
        max-height: 250px;
        overflow-y: auto;
    }

    .notifications-text {
        font-size: 14px;
        line-height: 1.3;
    }

    .notifications-time {
        font-size: 12px;
    }

    .notification-number-requests {
            animation: flash 1s infinite;
        }
    </style>
</head>

<body>


    <!-- Preloader -->
    <div class="preloader-it">
        <div class="loader-pendulums"></div>
    </div>
    <!-- /Preloader -->

    <!-- HK Wrapper -->
    <div class="hk-wrapper hk-vertical-nav">

        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-xl navbar-dark fixed-top hk-navbar">
            <a id="navbar_toggle_btn" class="navbar-toggle-btn nav-link-hover" href="javascript:void(0);"><span
                    class="feather-icon"><i data-feather="menu"></i></span></a>
            <a class="navbar-brand" href="{{ url('/') }}">
                <img class="brand-img d-inline-block" src="{{ asset('X-Files/Dash/logo-white.webp') }}" width="115px"
                    height="85px" alt="brand" />
            </a>
            @if (Auth::user()->hasRole('o-super-admin') || Auth::user()->hasRole('o-admin'))
                <ul class="navbar-nav hk-navbar-content">

                    <li class="nav-item dropdown dropdown-notifications">
                        <a class="nav-link dropdown-toggle no-caret d-flex crystal-navbar-icon" href="{{ route('asset-request.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                            @if(App\Http\Controllers\AssetRequestController::getPendingRequestsCount() > 0)
                                <span class="badge badge-danger badge-indicator notification-number-requests" style="position: absolute; top: 0; right: 0;">
                                    {{ App\Http\Controllers\AssetRequestController::getPendingRequestsCount() }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item dropdown dropdown-notifications">
                        <a class="nav-link dropdown-toggle no-caret d-flex crystal-navbar-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                            @if(App\Http\Controllers\AssetRequestController::getUnreadRequestsCount() > 0)
                                <span class="badge badge-danger badge-indicator" style="position: absolute; top: 0; right: 0;">
                                    {{ App\Http\Controllers\AssetRequestController::getUnreadRequestsCount() }}
                                </span>
                            @endif
                        </a>


                        <div class="dropdown-menu dropdown-menu-right notification-dropdown" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <h6 class="dropdown-header">Notifications</h6>
                            <div class="notifications-wrap">
                                @php
                                    $latestRequests = App\Models\AssetRequest::where('is_read', false)->latest()->take(5)->get();
                                @endphp

                                @if($latestRequests->count() > 0)
                                    @foreach($latestRequests as $notification)
                                        <a href="{{ route('asset-request.show', $notification->id) }}" class="dropdown-item">
                                            <div class="media">
                                                <div class="media-body">
                                                    <div class="notifications-text">New asset request from <span class="text-dark text-capitalize">{{ $notification->employee->name }}</span></div>
                                                    <div class="notifications-time">{{ $notification->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    @endforeach
                                @else
                                    <div class="dropdown-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <div class="notifications-text">No new notifications</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('asset-request.index') }}" class="dropdown-item text-center">View all notifications</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown dropdown-authentication" style="display: flex; align-items: center;justify-content: between;">
                        <a href="{{ route('dashboard') }}" class="crystal-navbar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </a>
                        <a href="{{ url('https://www.orioncc.com/') }}" target="_blank" class="crystal-navbar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        </a>
                        <a class="nav-link dropdown-toggle no-caret"  style="padding:5px 5px;"  href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <div class="media">
                                <div class="media-img-wrap">
                                    <div class="avatar" style="width: 55px !important; height: 55px !important;">
                                        <img src="{{ asset('X-Files/Dash/imgs/EmployeeProfilePic/' . Auth::user()->image) }}" alt="user"
                                            class="avatar-img rounded-circle" style="object-fit: cover;
                                            object-position: top;">
                                    </div>
                                    <span class="badge badge-success badge-indicator"></span>
                                </div>
                                <div class="media-body">
                                    <span>{{ Auth::user()->name }}<i class="zmdi zmdi-chevron-down"></i></span>
                                </div>
                            </div>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right"  style="padding:5px 5px;"  data-dropdown-in="flipInX"
                            data-dropdown-out="flipOutX">

                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="dropdown-item" href=""><i class="dropdown-icon zmdi zmdi-power"></i><span>Log
                                        out</span></button>
                            </form>
                        </div>
                    </li>
                </ul>
            @else
            <ul class="navbar-nav hk-navbar-content">



                <li class="nav-item dropdown dropdown-authentication" style="display: flex; align-items: center;justify-content: between;">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('X-Files/Dash/imgs/icons/home-button.png') }}" width="75" height="75" alt="" srcset="" style="padding:5px 5px;" >
                    </a>
                    <a href="{{ url('https://www.orioncc.com/') }}" target="_blank" >
                        <img src="{{ asset('X-Files/Dash/imgs/icons/world-wide-web.png') }}" width="75" height="75" alt=""  style="padding:5px 5px;" >
                    </a>
                    <a class="nav-link dropdown-toggle no-caret"  style="padding:5px 5px;"  href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <div class="media">
                            <div class="media-img-wrap">
                                <div class="avatar" style="width: 55px !important; height: 55px !important;">
                                    <img src="{{ asset('X-Files/Dash/imgs/EmployeeProfilePic/' . Auth::user()->image) }}" alt="user"
                                        class="avatar-img rounded-circle" style="object-fit: cover;
                                        object-position: top;">
                                </div>
                                <span class="badge badge-success badge-indicator"></span>
                            </div>
                            <div class="media-body">
                                <span>{{ Auth::user()->name }}<i class="zmdi zmdi-chevron-down"></i></span>
                            </div>
                        </div>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right"  style="padding:5px 5px;"  data-dropdown-in="flipInX"
                        data-dropdown-out="flipOutX">

                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="dropdown-item" href=""><i class="dropdown-icon zmdi zmdi-power"></i><span>Log
                                    out</span></button>
                        </form>
                    </div>
                </li>
            </ul>
            @endif
        </nav>
        <form role="search" class="navbar-search">
            <div class="position-relative">
                <a href="javascript:void(0);" class="navbar-search-icon"><span class="feather-icon"><i
                            data-feather="search"></i></span></a>
                <input type="text" name="example-input1-group2" class="form-control" placeholder="Type here to Search">
                <a id="navbar_search_close" class="navbar-search-close" href="#"><span class="feather-icon"><i
                            data-feather="x"></i></span></a>
            </div>
        </form>
        <!-- /Top Navbar -->

        <!-- Vertical Nav -->
        <nav class="hk-nav hk-nav-dark">
            <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i
                        data-feather="x"></i></span></a>
            <div class="nicescroll-bar">
                @if (Auth::user()->hasRole('o-super-admin') || Auth::user()->hasRole('o-admin') ||
                Auth::user()->hasRole('o-hr'))
                <div class="navbar-nav-wrap" style="padding-top: 50px">
                    <ul class="navbar-nav flex-column">

                        <li class="nav-item {{ Request::is('employees*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('employees.index') }}">
                                <span class="feather-icon crystal-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></span>
                                <span class="nav-link-text" style="font-size: 25px;padding-left:5px">Employees</span>
                            </a>
                        </li>


                        {{-- @endif --}}
                        <hr class="nav-separator">
                        {{-- @if (Auth::user()->hasRole('o-super-admin') || Auth::user()->hasRole('o-admin') || Auth::user()->hasRole('o-hr')) --}}

                        <li class="nav-item {{ Request::is('device*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('device.index') }}">
                                <span class="feather-icon crystal-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg></span>

                                <span class="nav-link-text" style="font-size: 25px;padding-left:5px">Devices</span>
                            </a>
                        </li>
                        <hr class="nav-separator">
                        <li class="nav-item {{ Request::is('clearance*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('clearance.index') }}">
                                <span class="feather-icon crystal-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg></span>

                                <span class="nav-link-text" style="font-size: 25px;padding-left:5px">Clearances</span>
                            </a>
                        </li>
                        <hr class="nav-separator">
                        <li class="nav-item {{ Request::is('receive*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('receive.index') }}">
                                <span class="feather-icon crystal-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16.5 9.4 7.55 4.24"></path><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.29 7 12 12 20.71 7"></polyline><line x1="12" y1="22" x2="12" y2="12"></line></svg></span>

                                <span class="nav-link-text" style="font-size: 25px;padding-left:5px">Receives</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('asset-request*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('asset-request.index') }}">
                                <span class="feather-icon crystal-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg></span>
                                <span class="nav-link-text" style="font-size: 25px;padding-left:5px">Requests</span>
                            </a>
                        </li>
                        {{-- @endif --}}

                        <hr class="nav-separator">
                        <li class="nav-item">
                            <a class="nav-link link-with-badge">
                                <span class="feather-icon crystal-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg></span>
                                <span class="nav-link-text" style="font-size: 25px;padding-left:5px">Control SyS</span>

                            </a>
                            <ul class="nav flex-column  collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        {{-- @if (Auth::user()->hasRole('o-super-admin') || Auth::user()->hasRole('o-admin') ||
                        Auth::user()->hasRole('o-hr')) --}}

                                        <li class="nav-item {{ Request::is('department*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('department.index') }}"><span class="crystal-nav-icon crystal-nav-icon-sm"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"></path><path d="M5 21V7l8-4v18"></path><path d="M19 21V11l-6-4"></path></svg></span>Departments</a>
                                        </li>
                                        <li class="nav-item {{ Request::is('position*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('position.index') }}"><span class="crystal-nav-icon crystal-nav-icon-sm"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg></span>Positions</a>
                                        </li>
                                        <li class="nav-item {{ Request::is('sim*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('sim.index') }}"><span class="crystal-nav-icon crystal-nav-icon-sm"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg></span>Sim Cards</a>
                                        </li>

                                        <li class="nav-item {{ Request::is('project') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('project.index') }}"><span class="crystal-nav-icon crystal-nav-icon-sm"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg></span>Projects</a>
                                        </li>
                                        <li class="nav-item {{ Request::is('project-assets*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('project-assets.index') }}"><span class="crystal-nav-icon crystal-nav-icon-sm"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73V8z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg></span>Project Assets</a>
                                        </li>
                                        <li class="nav-item {{ Request::is('department-assets*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('department-assets.index') }}"><span class="crystal-nav-icon crystal-nav-icon-sm"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg></span>Department Assets</a>
                                        </li>

                                        {{-- @elseif (Auth::user()->hasRole('o-hr') ) --}}

                                        {{-- <li class="nav-item {{ Request::is('department*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('department.index') }}"><img width="40" style="padding-right: 5px" src="{{ asset('X-Files/Dash/imgs/icons/003-department.png') }}" alt="" srcset="">Departments</a>
                                        </li>
                                        <li class="nav-item {{ Request::is('position*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('position.index') }}"><img width="40" style="padding-right: 5px" src="{{ asset('X-Files/Dash/imgs/icons/004-networking.png') }}" alt="" srcset="">Positions</a>
                                        </li>
                                        <li class="nav-item {{ Request::is('sim*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('sim.index') }}"><img width="40" style="padding-right: 5px" src="{{ asset('X-Files/Dash/imgs/icons/001-dual.png') }}" alt="" srcset="">Sim Cards</a>
                                        </li> --}}
                                        {{-- @endif --}}
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <hr class="nav-separator">
                        {{-- @if (Auth::user()->hasRole('o-super-admin') || Auth::user()->hasRole('o-admin') || Auth::user()->hasRole('o-hr')) --}}

                        <ul class="navbar-nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link collapsed " href="javascript:void(0);" data-toggle="collapse"
                                    data-target="#Components_drp" aria-expanded="false">
                                    <span class="feather-icon crystal-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></span>
                                    <span class="nav-link-text" style="font-size: 25px;padding-left:5px">Client</span>
                                </a>
                                <ul id="Components_drp" class="nav flex-column collapse-level-1 collapse" style="">
                                    <li class="nav-item">
                                        <ul class="nav flex-column">
                                            <li class="nav-item {{ Request::is('client*') ? 'active' : '' }}">
                                                <a class="nav-link " style="font-size: 20px" href="{{ route('client.index') }}">Clients</a>
                                            </li>
                                            <li class="nav-item {{ Request::is('clientEmployee*') ? 'active' : '' }}">
                                                <a class="nav-link " style="font-size: 20px"  href="{{ route('clientEmployee.index') }}">Client
                                                    Employees</a>
                                            </li>


                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ Request::is('consultant*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                <a class="nav-link" style="font-size: 25px" href="{{ route('consultant.index') }}"><span class="crystal-nav-icon crystal-nav-icon-sm"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg></span>Consultants</a>
                            </li>
                            <li class="nav-item {{ Request::is('manager*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                <a class="nav-link" style="font-size: 25px" href="{{ route('manager.index') }}"><span class="crystal-nav-icon crystal-nav-icon-sm"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></span>Managers</a>
                            </li>
                        </ul>
                        {{-- @endif --}}

                    </ul>

                </div>

                @endif
            </div>
        </nav>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->
