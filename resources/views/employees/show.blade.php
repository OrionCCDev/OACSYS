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
                            <h2 class="hk-pg-title font-weight-600">{{ $employee->name }}</h2>
                        </div>
                        <div class="d-flex mb-0 flex-wrap">
                            <div class="btn-group btn-group-sm btn-group-rounded mb-15 ml-15" role="group">
                                <button type="button" class="btn btn-primary">ID : </button>
                                <button type="button" class="btn btn-outline-primary">{{ $employee->employee_id
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
                                                    <span class="d-block display-5 font-weight-400 text-dark">{{ $employee?->receives?->count() ?? 0 }}</span>
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
                                                                $employee?->clearance?->count() ?? 0 }}
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
                                                            $employee?->devices?->count() ?? 0 }}</span>
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
                                                            <img class="card-img-top d-block" src="{{ asset('X-Files/Dash/imgs/EmployeeProfilePic/'.$employee->profile_image) }}" alt="Card image cap">
                                                            <div class="resigned-sign" style="position: absolute;top: 40%;left: 25%%;z-index: 999;">
                                                                <img width="280" src="{{ asset('X-Files/Dash/imgs/resigned.png') }}" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <span style="font-size: 20px" class=" badge badge-soft-success mt-15 mr-10"><h5>{{ $employee->department->name }} - </h5></span>
                                                            <span style="font-size: 20px" class="badge badge-soft-warning mt-15 mr-10"><h5>{{ $employee->position->name }}</h5></span>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-12">

                                            <div class="card card-profile-feed">

												<div class="row text-center">

													<div class="col-6 border-right px-0">
														<div class="pa-15">
															<span class="d-block display-6 text-dark mb-5">Years: {{ $diff->y }}, Months: {{ $diff->m }}, Days: {{ $diff->d }}</span>
															<span class="d-block text-capitalize font-14">Working For</span>
														</div>
													</div>
													<div class="col-6 pl-0">
														<div class="pa-15">
															<span class="d-block display-6 text-dark mb-5">{{ $employee->department->name }}</span>
															<span class="d-block text-capitalize font-14">Department</span>
														</div>
													</div>
												</div>
												<ul class="list-group list-group-flush">
                                                    <li class="list-group-item"><span><i class="ion ion-md-calendar font-18 text-light-20 mr-10"></i><span>Hire Date:</span></span><span class="ml-5 text-dark">{{ $hireDate }}</span></li>
                                                    <li class="list-group-item"><span><i class="ion ion-md-briefcase font-18 text-light-20 mr-10"></i><span>Branch:</span></span><span class="ml-5 text-dark">Ras AlKhaima</span></li>
                                                    <li class="list-group-item"><span><i class="ion ion-md-briefcase font-18 text-light-20 mr-10"></i><span>Orion Mobile:</span></span><span class="ml-5 text-dark">
                                                        @if ($employee->sim_card->count() > 0)
                                                            @foreach ($employee->sim_card as $sim )
                                                            <span class="badge badge-success mt-15 mr-10">{{ $sim->sim_number }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="badge badge-danger mt-15 mr-10">No Sim Found</span>
                                                        @endif

                                                    </span></li>
                                                    <li class="list-group-item"><span><i class="ion ion-md-briefcase font-18 text-light-20 mr-10"></i>
                                                        <span>Orion Email:</span></span>
                                                        @if ($employee->orion_email)
                                                        <span class="ml-5 text-dark">{{ $employee->orion_email }}</span>
                                                        @else
                                                        <span class="ml-5 text-dark">No Email Assigned , Plz Contact IT</span>
                                                        @endif
                                                    </li>
                                                    <li class="list-group-item"><span><i class="ion ion-md-briefcase font-18 text-light-20 mr-10"></i>
                                                        <span>Personal Mobile:</span></span>
                                                        @if ($employee->personal_mobile)
                                                        <span class="ml-5 text-info">{{ $employee->personal_mobile }}</span>
                                                        @else
                                                        <span class="ml-5 text-info">Not Found</span>
                                                        @endif
                                                    </li>
                                                    <li class="list-group-item"><span><i class="ion ion-md-briefcase font-18 text-light-20 mr-10"></i>
                                                        <span>Personal Email:</span></span>
                                                        @if ($employee->personal_email)
                                                        <span class="ml-5 text-warning">{{ $employee->personal_email }}</span>
                                                        @else
                                                        <span class="ml-5 text-warning">Not Found</span>
                                                        @endif
                                                    </li>
                                                    @if ($employee->project)

                                                        <li class="list-group-item"><span><i class="ion ion-md-briefcase font-18 text-light-20 mr-10"></i>
                                                            <span>Project :</span></span>

                                                            <span class="ml-5 text-info">{{ $employee->project->project_name }} Code {{ $employee->project->project_code }}</span>

                                                        </li>

                                                    @endif
                                                </ul>
											 </div>

                                        </div>
                                    </div>
                                    @if ($employee->devices->count() > 0)
                                        <div class="card card-profile-feed">
                                            <div class="card-header card-header-action">
                                                <h6><span>Devices And Items <span class="badge badge-soft-primary ml-5">{{ $employee?->devices?->count() ?? 0 }}</span></span></h6>

                                            </div>
                                            <div class="card-body pb-5 w-100">
                                                <div class="hk-row text-center w-100">
                                                    <div class="customize-thumbnails-gallery w-100" id="customize-thumbnails-gallery">
                                                        @foreach ($employee->devices as $device )
                                                        <div class="col-4 mb-15">
                                                            <a class="w-100" href="{{ asset('X-Files/Dash/imgs/devices/' . $device->main_image) }}">
                                                                <img class="img-fluid img-thumbnail" src="{{ asset('X-Files/Dash/imgs/devices/' . $device->main_image) }}" />
                                                            </a>
                                                            <span class="d-block font-14 text-truncate">{{ $device->device_name }}</span>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.1/lightgallery.min.js" integrity="sha512-n82wdm8yNoOCDS7jsP6OEe12S0GHQV7jGSwj5V2tcNY/KM3z+oSDraUN3Hjf3EgOS9HWa4s3DmSSM2Z9anVVRQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                                                    <script>
                                                        lightGallery(document.getElementById('customize-thumbnails-gallery'), {
                                                            // Add a custom class to apply style only for the particular gallery
                                                            addClass: 'lg-custom-thumbnails',

                                                            // Remove the starting animations.
                                                            // This can be done by overriding CSS as well
                                                            appendThumbnailsTo: '.lg-outer',

                                                            animateThumb: false,
                                                            allowMediaOverlap: true,
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-profile-feed">
                                            <div class="card-header card-header-action">
                                                <div class="media align-items-center">

                                                    <div class="media-body">
                                                        <div class="text-capitalize font-weight-500 text-dark">Devices Details</div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="card-body">
                                                <div class="card">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Device Name</th>
                                                                <th>Device Type</th>
                                                                <th>Serial Model</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($employee->devices as $device)
                                                            <tr>
                                                                <td>{{ $device->device_name }}</td>
                                                                <td>{{ $device->device_type }}</td>
                                                                <td>{{ $device->device_model }}</td>
                                                                <td>
                                                                    <a href="{{ route('device.show', $device->id) }}" class="btn btn-info btn-sm">Show Details</a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    @endif

                                    <div class="row mt-30">
                                        <div class="col-auto">

                                            <a href="{{ route('employees.index') }}" style="display: inline-flex;align-items:center;" class="btn  mb-2 btn-gradient-danger btn-wth-icon icon-wthot-bg btn-rounded icon-left btn-lg">
                                                <i class="icon-logout"></i>
                                                <span class="btn-text">Back</span>
                                            </a>
                                            <a href="{{ route('employees.edit' , $employee->id) }}" class="btn mb-2 btn-gradient-bunting btn-wth-icon icon-wthot-bg btn-rounded icon-right btn-lg">
                                                <span class="btn-text">Edit</span> <span class="icon-label"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></span> </span>
                                            </a>

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
