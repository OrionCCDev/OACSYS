@extends('layouts.app')

@push('styles')

@endpush
@section('content')
{{-- @dd($devicesData , $receiver , $receiver_type) --}}
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Make Clearance</h2>
                {{-- <p>Questions about onboarding lead data? <a href="#">Learn more.</a></p> --}}
            </div>
        </div>
        <!-- Title -->
        <div class="container">
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Select Employee To Make For Him A Clearance</h5>
                <div class="row">
                    <livewire:clearance-device-selector />
                </div>
            </section>
            <!-- /Title -->

            <!-- Row -->

            <!-- /Row -->
        </div>
    </div>
</div>
<script>
    function printReceiving() {
        const printContent = document.getElementById('PrintingArea').innerHTML;
        const originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
    }
    </script>
@endsection
