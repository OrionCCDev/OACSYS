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
                {{-- <li class="nav-item">
                    <a id="navbar_search_btn" class="nav-link nav-link-hover" href="javascript:void(0);"><span
                            class="feather-icon"><i data-feather="search"></i></span></a>
                </li>
                <li class="nav-item">
                    <a id="settings_toggle_btn" class="nav-link nav-link-hover" href="javascript:void(0);"><span
                            class="feather-icon"><i data-feather="settings"></i></span></a>
                </li>
                <li class="nav-item dropdown dropdown-notifications">
                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"><span class="feather-icon"><i
                                data-feather="bell"></i></span><span class="badge-wrap"><span
                                class="badge badge-primary badge-indicator badge-indicator-sm badge-pill pulse"></span></span></a>
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="fadeIn"
                        data-dropdown-out="fadeOut">
                        <h6 class="dropdown-header">Notifications <a href="javascript:void(0);" class="">View all</a>
                        </h6>
                        <div class="notifications-nicescroll-bar">
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <img src="{{ asset('X-Files/Dash/dist/img/avatar1.jpg') }}" alt="user"
                                                class="avatar-img rounded-circle">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text"><span class="text-dark text-capitalize">Evie
                                                    Ono</span> accepted your invitation to join the team</div>
                                            <div class="notifications-time">12m</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <img src="{{ asset('X-Files/Dash/dist/img/avatar2.jpg') }}" alt="user"
                                                class="avatar-img rounded-circle">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">New message received from <span
                                                    class="text-dark text-capitalize">Misuko Heid</span></div>
                                            <div class="notifications-time">1h</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-primary rounded-circle">
                                                <span class="initial-wrap"><span><i
                                                            class="zmdi zmdi-account font-18"></i></span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">You have a follow up with<span
                                                    class="text-dark text-capitalize"> Mintos head</span> on <span
                                                    class="text-dark text-capitalize">friday, dec 19</span> at <span
                                                    class="text-dark">10.00 am</span></div>
                                            <div class="notifications-time">2d</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-success rounded-circle">
                                                <span class="initial-wrap"><span>A</span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">Application of <span
                                                    class="text-dark text-capitalize">Sarah Williams</span> is waiting
                                                for your approval</div>
                                            <div class="notifications-time">1w</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-warning rounded-circle">
                                                <span class="initial-wrap"><span><i
                                                            class="zmdi zmdi-notifications font-18"></i></span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">Last 2 days left for the project</div>
                                            <div class="notifications-time">15d</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </li> --}}
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
                        {{-- <a class="dropdown-item" href="profile.html"><i
                                class="dropdown-icon zmdi zmdi-account"></i><span>Profile</span></a>
                        <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-card"></i><span>My
                                balance</span></a>
                        <a class="dropdown-item" href="inbox.html"><i
                                class="dropdown-icon zmdi zmdi-email"></i><span>Inbox</span></a>
                        <a class="dropdown-item" href="#"><i
                                class="dropdown-icon zmdi zmdi-settings"></i><span>Settings</span></a>
                        <div class="dropdown-divider"></div>
                        <div class="sub-dropdown-menu show-on-hover">
                            <a href="#" class="dropdown-toggle dropdown-item no-caret"><i
                                    class="zmdi zmdi-check text-success"></i>Online</a>
                            <div class="dropdown-menu open-left-side">
                                <a class="dropdown-item" href="#"><i
                                        class="dropdown-icon zmdi zmdi-check text-success"></i><span>Online</span></a>
                                <a class="dropdown-item" href="#"><i
                                        class="dropdown-icon zmdi zmdi-circle-o text-warning"></i><span>Busy</span></a>
                                <a class="dropdown-item" href="#"><i
                                        class="dropdown-icon zmdi zmdi-minus-circle-outline text-danger"></i><span>Offline</span></a>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div> --}}
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
                        </ul>
                        @endif
                        {{--<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#auth_drp">
                                <span class="feather-icon"><i data-feather="zap"></i></span>
                                <span class="nav-link-text">Authentication</span>
                            </a>
                            <ul id="auth_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                                data-target="#signup_drp">
                                                Sign Up
                                            </a>
                                            <ul id="signup_drp" class="nav flex-column collapse collapse-level-2">
                                                <li class="nav-item">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="signup.html">Cover</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="signup-simple.html">Simple</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                                data-target="#signin_drp">
                                                Login
                                            </a>
                                            <ul id="signin_drp" class="nav flex-column collapse collapse-level-2">
                                                <li class="nav-item">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="login.html">Cover</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="login-simple.html">Simple</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                                data-target="#recover_drp">
                                                Recover Password
                                            </a>
                                            <ul id="recover_drp" class="nav flex-column collapse collapse-level-2">
                                                <li class="nav-item">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="forgot-password.html">Forgot
                                                                Password</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="reset-password.html">Reset
                                                                Password</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="lock-screen.html">Lock Screen</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="404.html">Error 404</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="maintenance.html">Maintenance</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#pages_drp">
                                <span class="feather-icon"><i data-feather="file-text"></i></span>
                                <span class="nav-link-text">Pages</span>
                            </a>
                            <ul id="pages_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="profile.html">Profile</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="invoice.html">Invoice</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="gallery.html">Gallery</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="activity.html">Activity</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="faq.html">Faq</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li> --}}
                    </ul>
                    {{--
                    <hr class="nav-separator">
                    <div class="nav-header">
                        <span>User Interface</span>
                        <span>UI</span>
                    </div>
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#Components_drp">
                                <span class="feather-icon"><i data-feather="layout"></i></span>
                                <span class="nav-link-text">Components</span>
                            </a>
                            <ul id="Components_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="alerts.html">Alerts</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="avatar.html">Avatar</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="badge.html">Badge</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="buttons.html">Buttons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="cards.html">Cards</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="carousel.html">Carousel</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="collapse.html">Collapse</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="dropdowns.html">Dropdown</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="list-group.html">List Group</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="modal.html">Modal</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="nav.html">Nav</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="navbar.html">Navbar</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="nestable.html">Nestable</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pagination.html">Pagination</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="popovers.html">Popovers</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="progress.html">Progress</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="tooltip.html">Tooltip</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#content_drp">
                                <span class="feather-icon"><i data-feather="type"></i></span>
                                <span class="nav-link-text">Content</span>
                            </a>
                            <ul id="content_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="typography.html">Typography</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="images.html">Images</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="media-object.html">Media Object</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#utilities_drp">
                                <span class="feather-icon"><i data-feather="anchor"></i></span>
                                <span class="nav-link-text">Utilities</span>
                            </a>
                            <ul id="utilities_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="background.html">Background</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="border.html">Border</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="colors.html">Colors</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="embeds.html">Embeds</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="icons.html">Icons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="shadow.html">Shadow</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="sizing.html">Sizing</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="spacing.html">Spacing</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#forms_drp">
                                <span class="feather-icon"><i data-feather="server"></i></span>
                                <span class="nav-link-text">Forms</span>
                            </a>
                            <ul id="forms_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="form-element.html">Form Elements</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="input-groups.html">Input Groups</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="form-layout.html">Form Layout</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="form-mask.html">Form Mask</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="form-validation.html">Form Validation</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="form-wizard.html">Form Wizard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="file-upload.html">File Upload</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editor.html">Editor</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#tables_drp">
                                <span class="feather-icon"><i data-feather="list"></i></span>
                                <span class="nav-link-text">Tables</span>
                            </a>
                            <ul id="tables_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="basic-table.html">Basic Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="data-table.html">Data Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="responsive-table.html">Responsive Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editable-table.html">Editable Table</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#charts_drp">
                                <span class="feather-icon"><i data-feather="pie-chart"></i></span>
                                <span class="nav-link-text">Charts</span>
                            </a>
                            <ul id="charts_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="line-charts.html">Line Chart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="area-charts.html">Area Chart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="bar-charts.html">Bar Chart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pie-charts.html">Pie Chart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="realtime-charts.html">Realtime Chart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="mini-charts.html">Mini Chart</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#maps_drp">
                                <span class="feather-icon"><i data-feather="map"></i></span>
                                <span class="nav-link-text">Maps</span>
                            </a>
                            <ul id="maps_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="google-map.html">Google Map</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="vector-map.html">Vector Map</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <hr class="nav-separator">
                    <div class="nav-header">
                        <span>Getting Started</span>
                        <span>GS</span>
                    </div>
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="documentation.html">
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">Documentation</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-with-badge" href="#">
                                <span class="feather-icon"><i data-feather="eye"></i></span>
                                <span class="nav-link-text">Changelog</span>
                                <span class="badge badge-sm badge-danger badge-pill">v 1.0</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="feather-icon"><i data-feather="headphones"></i></span>
                                <span class="nav-link-text">Support</span>
                            </a>
                        </li>
                    </ul> --}}
                </div>
            </div>
        </nav>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->
