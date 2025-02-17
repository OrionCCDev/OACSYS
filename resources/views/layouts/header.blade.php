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

    <!-- Custom CSS -->
    <link href="{{ asset('X-Files/Dash/dist/css/style.css') }}" rel="stylesheet" type="text/css">
    @yield('custom_css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles()
    <style>
        .hk-wrapper .hk-navbar.navbar-dark {
            background-color: #0f5874 !important;
        }
        .hk-wrapper.hk-vertical-nav .hk-nav.hk-nav-dark {
            background-color: #114e67 !important;
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
            <ul class="navbar-nav hk-navbar-content">

                <li class="nav-item dropdown dropdown-authentication">
                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <div class="media">
                            <div class="media-img-wrap">
                                <div class="avatar" style="width: 55px !important; height: 55px !important;">
                                    <img src="{{ asset('X-Files/Dash/imgs/' . Auth::user()->image) }}" alt="user"
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
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="flipInX"
                        data-dropdown-out="flipOutX">

                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="dropdown-item" href=""><i class="dropdown-icon zmdi zmdi-power"></i><span>Log
                                    out</span></button>
                        </form>
                    </div>
                </li>
            </ul>
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
                <div class="navbar-nav-wrap" style="padding-top: 50px">
                    <ul class="navbar-nav flex-column">
                        @if (Auth::user()->hasRole('o-super-admin') || Auth::user()->hasRole('o-admin') ||
                        Auth::user()->hasRole('o-hr'))


                        <li class="nav-item {{ Request::is('employees*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('employees.index') }}">
                                <span class="feather-icon"><img width="50" src="{{ asset('X-Files/Dash/imgs/icons/009-division.png') }}" alt="" srcset=""></span>
                                <span class="nav-link-text" style="font-size: 25px;padding-left:5px">Employees</span>
                            </a>
                        </li>

                        @endif
                        <hr class="nav-separator">
                        @if (Auth::user()->hasRole('o-super-admin') || Auth::user()->hasRole('o-admin') )

                        <li class="nav-item {{ Request::is('device*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('device.index') }}">
                                                                <span class="feather-icon">
                                                                    <img width="50" src="{{ asset('X-Files/Dash/imgs/icons/008-device.png') }}" alt="" srcset=""></span>

                                <span class="nav-link-text" style="font-size: 25px;padding-left:5px">Devices</span>
                            </a>
                        </li>
                        <hr class="nav-separator">
                        <li class="nav-item {{ Request::is('clearance*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('clearance.index') }}">
                                                                <span class="feather-icon"><img width="50" src="{{ asset('X-Files/Dash/imgs/icons/007-customs-clearance.png') }}" alt="" srcset=""></span>

                                <span class="nav-link-text" style="font-size: 25px;padding-left:5px">Clearances</span>
                            </a>
                        </li>
                        <hr class="nav-separator">
                        <li class="nav-item {{ Request::is('receive*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('receive.index') }}">
                                                                <span class="feather-icon">
                                                                    <img width="50" src="{{ asset('X-Files/Dash/imgs/icons/006-received.png') }}" alt="" srcset=""></span>

                                <span class="nav-link-text" style="font-size: 25px;padding-left:5px">Receives</span>
                            </a>
                        </li>
                        @endif

                        <hr class="nav-separator">
                        <li class="nav-item">
                            <a class="nav-link link-with-badge">
                                <span class="feather-icon"><img width="50" src="{{ asset('X-Files/Dash/imgs/icons/005-security.png') }}" alt="" srcset=""></span>
                                <span class="nav-link-text" style="font-size: 25px;padding-left:5px">Control SyS</span>

                            </a>
                            <ul class="nav flex-column  collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        @if (Auth::user()->hasRole('o-super-admin') || Auth::user()->hasRole('o-admin')
                                        )

                                        <li class="nav-item {{ Request::is('department*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('department.index') }}"><img width="40" style="padding-right: 5px" src="{{ asset('X-Files/Dash/imgs/icons/003-department.png') }}" alt="" srcset="">Departments</a>
                                        </li>
                                        <li class="nav-item {{ Request::is('position*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('position.index') }}"><img width="40" style="padding-right: 5px" src="{{ asset('X-Files/Dash/imgs/icons/004-networking.png') }}" alt="" srcset="">Positions</a>
                                        </li>
                                        <li class="nav-item {{ Request::is('sim*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('sim.index') }}"><img width="40" style="padding-right: 5px" src="{{ asset('X-Files/Dash/imgs/icons/001-dual.png') }}" alt="" srcset="">Sim Cards</a>
                                        </li>

                                        <li class="nav-item {{ Request::is('project*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('project.index') }}"><img width="40" style="padding-right: 5px" src="{{ asset('X-Files/Dash/imgs/icons/010-planning.png') }}" alt="" srcset="">Projects</a>
                                        </li>

                                        @elseif (Auth::user()->hasRole('o-hr') )

                                        <li class="nav-item {{ Request::is('department*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('department.index') }}"><img width="40" style="padding-right: 5px" src="{{ asset('X-Files/Dash/imgs/icons/003-department.png') }}" alt="" srcset="">Departments</a>
                                        </li>
                                        <li class="nav-item {{ Request::is('position*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('position.index') }}"><img width="40" style="padding-right: 5px" src="{{ asset('X-Files/Dash/imgs/icons/004-networking.png') }}" alt="" srcset="">Positions</a>
                                        </li>
                                        <li class="nav-item {{ Request::is('sim*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                            <a class="nav-link" style="font-size: 20px" href="{{ route('sim.index') }}"><img width="40" style="padding-right: 5px" src="{{ asset('X-Files/Dash/imgs/icons/001-dual.png') }}" alt="" srcset="">Sim Cards</a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <hr class="nav-separator">
                        @if (Auth::user()->hasRole('o-super-admin') || Auth::user()->hasRole('o-admin') )

                        <ul class="navbar-nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link collapsed " href="javascript:void(0);" data-toggle="collapse"
                                    data-target="#Components_drp" aria-expanded="false">
                                    <span class="feather-icon"><img width="50" style="padding-right: 5px" src="{{ asset('X-Files/Dash/imgs/icons/013-customer-review.png') }}" alt="" srcset=""></span>
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
                                <a class="nav-link" style="font-size: 25px" href="{{ route('consultant.index') }}"><img width="40" style="padding-right: 5px" src="{{ asset('X-Files/Dash/imgs/icons/011-consultant.png') }}" alt="" srcset="">Consultants</a>
                            </li>
                            <li class="nav-item {{ Request::is('manager*') ? 'active' : '' }}" style="margin-bottom: 7px">
                                <a class="nav-link" style="font-size: 25px" href="{{ route('manager.index') }}"><img width="40" style="padding-right: 5px" src="{{ asset('X-Files/Dash/imgs/icons/manager.png') }}" alt="" srcset="">Managers</a>
                            </li>
                        </ul>
                        @endif

                    </ul>

                </div>
            </div>
        </nav>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->
