@extends('layouts.app')


@section('content')
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Devices Management</h2>
                {{-- <p>Questions about onboarding lead data? <a href="#">Learn more.</a></p> --}}
            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">

                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title">Add New Device</h5>
                        <a href="{{ route('device.create') }}"
                            class="btn btn-gradient-primary btn-wth-icon btn-rounded icon-right">
                            <span class="btn-text">Add Device</span>
                            <span class="icon-label">
                                <span class="feather-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-arrow-right-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 16 16 12 12 8"></polyline>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg></span> </span>
                        </a>
                        <a href="{{ route('device.assignDeviceToEmp') }}"
                            class="btn btn-gradient-dark btn-wth-icon btn-rounded icon-right">
                            <span class="btn-text">Assigne Device To Employee</span>
                            <span class="icon-label">
                                <span class="feather-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-arrow-right-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 16 16 12 12 8"></polyline>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg></span> </span>
                        </a>
                    </section>

                    @livewire('device-index')
                </div>




            </div>
        </div>
    </div>
</div>
@endsection
