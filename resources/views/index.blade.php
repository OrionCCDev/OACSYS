@extends('layouts.app')
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var _seed = 42;
    Math.random = function() {
        _seed = _seed * 16807 % 2147483647;
        return (_seed - 1) / 2147483646;
    };

    function createRadialBarChart(elementId, seriesValue, label) {
        var options = {
            series: [seriesValue],
            chart: {
                height: 350,
                type: 'radialBar',
                toolbar: {
                    show: false
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 2000 // 2 seconds delay
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                }
            },
            plotOptions: {
                radialBar: {
                    startAngle: -135,
                    endAngle: 225,
                    hollow: {
                        margin: 0,
                        size: '70%',
                        background: '#fff',
                        position: 'front',
                        dropShadow: {
                            enabled: true,
                            top: 3,
                            left: 0,
                            blur: 4,
                            opacity: 0.5
                        }
                    },
                    track: {
                        background: '#fff',
                        strokeWidth: '67%',
                        margin: 0, // margin is in pixels
                        dropShadow: {
                            enabled: true,
                            top: -3,
                            left: 0,
                            blur: 4,
                            opacity: 0.7
                        }
                    },
                    dataLabels: {
                        show: true,
                        name: {
                            offsetY: -10,
                            show: true,
                            color: '#888',
                            fontSize: '17px'
                        },
                        value: {
                            formatter: function(val) {
                                return parseInt(val);
                            },
                            color: '#111',
                            fontSize: '36px',
                            show: true,
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#ABE5A1'],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50]
                }
            },
            stroke: {
                lineCap: 'round'
            },
            labels: [label],
        };

        var chart = new ApexCharts(document.querySelector("#" + elementId), options);
        chart.render();
    }

    document.addEventListener('DOMContentLoaded', function() {
        createRadialBarChart('chart1', {{ $employees_count }}, 'Employees');
        createRadialBarChart('chart2', {{ $project_count }}, 'Projects');
        createRadialBarChart('chart3', {{ $department_count }}, 'Departments');
        createRadialBarChart('chart4', {{ $routers_count }}, 'Routers');
        createRadialBarChart('chart5', {{ $laptop_count }}, 'Laotops');
        createRadialBarChart('chart6', {{ $camera_count }}, 'Cameras');
        // Add more charts as needed
    });
</script>
@endsection
@section('content')
<!-- Main Content -->
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <!-- Title -->
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">System Management</h2>
                {{-- <p>Questions about onboarding lead data? <a href="#">Learn more.</a></p> --}}
            </div>
            {{-- <div class="d-flex w-500p">
                <select class="form-control custom-select custom-select-sm mr-15">
                    <option selected="">Latest Products</option>
                    <option value="1">CRM</option>
                    <option value="2">Projects</option>
                    <option value="3">Statistics</option>
                </select>
                <select class="form-control custom-select custom-select-sm mr-15">
                    <option selected="">USA</option>
                    <option value="1">USA</option>
                    <option value="2">India</option>
                    <option value="3">Australia</option>
                </select>
                <select class="form-control custom-select custom-select-sm">
                    <option selected="">December</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="1">April</option>
                    <option value="2">May</option>
                    <option value="3">June</option>
                    <option value="1">July</option>
                    <option value="2">August</option>
                    <option value="3">September</option>
                    <option value="1">October</option>
                    <option value="2">November</option>
                    <option value="3">December</option>
                </select>
            </div> --}}
        </div>
        <!-- /Title -->
        <style>
            .card-body {
                background: #4168c2;
                color: white !important;
                text-align: center
            }

            .card.card-sm {
                border: 2px solid black;
            }

            .card-body .d-flex div span {
                color: white !important;
            }
        </style>
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="hk-row">
                    @if (Auth::user()->hasRole('o-super-admin') || Auth::user()->hasRole('o-admin'))
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-12 col-md-4 my-15">
                                <a href="{{ route('receive.create') }}"
                                    style="width: 100%;height:150px;display:flex;justify-content: center;align-items: center;"
                                    class="btn btn-gradient-primary btn-wth-icon btn-lg">
                                    <span class="icon-label"><span class="feather-icon"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-credit-card">
                                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                <line x1="1" y1="10" x2="23" y2="10"></line>
                                            </svg></span> </span><span class="btn-text" style="font-size: 35px">Make
                                        Receiving</span></a>
                            </div>
                            <div class="col-12 col-md-4 my-15">
                                <a href="{{ route('clearance.index') }}"
                                    style="width: 100%;height:150px;display:flex;justify-content: center;align-items: center;"
                                    class="btn btn-gradient-info btn-wth-icon btn-lg"> <span class="icon-label"><span
                                            class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-credit-card">
                                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                <line x1="1" y1="10" x2="23" y2="10"></line>
                                            </svg></span> </span><span class="btn-text" style="font-size: 35px">Make
                                        Clearance</span></a>
                            </div>
                            <div class="col-12 col-md-4 my-15">
                                <button style="width: 100%;height:150px"
                                    class="btn btn-gradient-danger btn-wth-icon btn-lg"> <span class="icon-label"><span
                                            class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-credit-card">
                                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                <line x1="1" y1="10" x2="23" y2="10"></line>
                                            </svg></span> </span><span class="btn-text" style="font-size: 25px">Make a
                                        Resignation</span></button>
                            </div>
                            <div class="col-12 col-md-4 my-15">
                                <a href="{{ url('import-simcards') }}"
                                    style="width: 100%;height:150px;display:flex;justify-content: center;align-items: center;"
                                    class="btn btn-gradient-success  btn-wth-icon btn-lg">
                                    <span class="icon-label"><span class="feather-icon"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-credit-card">
                                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                <line x1="1" y1="10" x2="23" y2="10"></line>
                                            </svg></span> </span><span class="btn-text" style="font-size: 25px">Upload
                                        Sim From Excel</span></a>
                            </div>
                            <div class="col-12 col-md-4 my-15">
                                <a href="{{ url('import-employees') }}"
                                    style="width: 100%;height:150px;display:flex;justify-content: center;align-items: center;"
                                    class="btn btn-gradient-warning  btn-wth-icon btn-lg">
                                    <span class="icon-label"><span class="feather-icon"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-credit-card">
                                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                <line x1="1" y1="10" x2="23" y2="10"></line>
                                            </svg></span> </span><span class="btn-text" style="font-size: 25px">Upload
                                        Employees From Excel</span></a>
                            </div>


                        </div>
                    </div>
                    <div class="col-sm-12 mt-100">
                        <div class=" row">
                            <div class="  col-md-3">

                                <div id="chart1"></div>

                            </div>
                            <div class="  col-md-3">

                                <div id="chart2"></div>

                            </div>
                            <div class="  col-md-3">

                                <div id="chart3"></div>

                            </div>
                            <div class="  col-md-3">

                                <div id="chart4"></div>

                            </div>
                            <div class="  col-md-3">

                                <div id="chart5"></div>

                            </div>
                            <div class="  col-md-3">

                                <div id="chart6"></div>

                            </div>

                        </div>
                    </div>
                    @elseif(Auth::user()->hasRole('o-manager'))
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-12 col-md-4 my-15">
                                <a href="{{ route('manager.show' , ['manager' => Auth::user()->employee_profile_id]) }}"
                                    style="width: 100%;height:150px;display:flex;justify-content: center;align-items: center;"
                                    class="btn btn-gradient-primary btn-wth-icon btn-lg">
                                    <span class="icon-label"><span class="feather-icon"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-credit-card">
                                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                <line x1="1" y1="10" x2="23" y2="10"></line>
                                            </svg></span> </span><span class="btn-text" style="font-size: 35px">Show My
                                        Profile</span></a>
                            </div>

                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->

    <!-- Footer -->
    <div class="hk-footer-wrap container">
        <footer class="footer">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <p>Designed by<a href="https://orioncc.com/" class="text-dark" target="_blank">IT-Department</a> ©
                        2024</p>
                </div>
                {{-- <div class="col-md-6 col-sm-12">
                    <p class="d-inline-block">Follow us</p>
                    <a href="#" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span
                            class="btn-icon-wrap"><i class="fa fa-facebook"></i></span></a>
                    <a href="#" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span
                            class="btn-icon-wrap"><i class="fa fa-twitter"></i></span></a>
                    <a href="#" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span
                            class="btn-icon-wrap"><i class="fa fa-google-plus"></i></span></a>
                </div> --}}
            </div>
        </footer>
    </div>
    <!-- /Footer -->
</div>
<!-- /Main Content -->
@endsection
