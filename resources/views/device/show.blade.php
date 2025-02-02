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
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Device Information</h2>

            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <h2 class="my-3 text-center" style="font-size: 65px;font-weight: 800">{{ $device->device_name }}</h2>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="card card-profile-feed">
                                <div class="card-body">
                                    <div class="card">
                                        <div class="position-relative">
                                            <img class="card-img-top d-block" src="{{ asset('X-Files/Dash/imgs/devices/' . $device->main_image) }}" alt="Card image cap">
                                            <a class="btn btn-warning  btn-wth-icon icon-wthot-bg btn-rounded btn-pg-link"><span class="icon-label"><i class="ion ion-md-link"></i></span><span class="btn-text">{{ $device->status }}</span></a>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $device->short_description ?? 'No Description Available For This Device' }}</h5>
                                            <p class="card-text">{{ $device->notes ?? 'No Notes Available For This Device' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer justify-content-between">

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card card-profile-feed">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item" style="font-size: 35px">
                                        <span>
                                            <span>Deleivered To: </span></span>
                                            <span class="ml-5 text-dark">
                                                @if($device->employee)
                                                    {{ $device->employee->name }} (Employee)
                                                @elseif($device->client)
                                                    {{ $device->client->name }} (Client)
                                                @elseif($device->consultant)
                                                    {{ $device->consultant->name }} (Consultant)
                                                @else
                                                    No receiver assigned
                                                @endif
                                            </span>
                                    </li>
                                    <li class="list-group-item" style="font-size: 35px">
                                        <span>
                                            <span>Model: </span></span>
                                            <span class="ml-5 text-dark">{{ $device->device_model ?? 'No model Assigned' }} </span>
                                    </li>
                                    <li class="list-group-item" style="font-size: 35px">
                                        <span>
                                            <span>Type: </span></span>
                                            <span class="ml-5 text-dark">{{ $device->device_type ?? 'No Device Type' }} </span>
                                    </li>
                                    <li class="list-group-item" style="font-size: 35px">
                                        <span>
                                            <span>Price: </span></span>
                                            <span class="ml-5 text-dark">{{ $device->device_price ?? 'No Device Price' }} </span>
                                    </li>
                                    <li class="list-group-item" style="font-size: 35px">
                                        <span>
                                            <span>Serial Number: </span></span>
                                            <span class="ml-5 text-dark">{{ $device->serial_number ?? 'No Serial Number' }} </span>
                                    </li>
                                    <li class="list-group-item" style="font-size: 35px">
                                        <span>
                                            <span>Supplier Name: </span></span>
                                            <span class="ml-5 text-dark">{{ $device->supplier_name ?? 'No Supplier Assigned' }} </span>
                                    </li>

                                </ul>
                             </div>
                        </div>
                    </div>
                    {{-- <img src="{{ asset('media/1/61maJhzoSULACSL1500.jpg') }}" alt="" srcset="">g --}}
                    <div class="row hk-gallery">
                        <div class="customize-thumbnails-gallery" id="customize-thumbnails-gallery">
                             @foreach ($device->getMedia('Device_image') as $img )
                            <a href="{{ $img->getUrl() }}">
                                <img class="img-fluid img-thumbnail" src="{{ $img->getUrl() }}" />
                            </a>
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
                    <div class="row mt-30">
                        <div class="col-auto">
                            <a href="{{ url()->previous() }}" class="btn btn-danger btn-lg mb-2">Back</a>
                            <a href="{{ route('device.edit' , $device->id) }}" class="btn mb-2 btn-info btn-wth-icon icon-wthot-bg  icon-right btn-lg">
                                <span class="btn-text">Edit</span> <span class="icon-label"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></span> </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
