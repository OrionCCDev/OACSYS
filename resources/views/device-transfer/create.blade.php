@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Transfer Devices &amp; SIM Cards Between Employees</h2>
                <p>Pick the releasing employee, the receiving employee, and the device(s)/SIM card(s) to move. A
                    clearance is generated for the releasing employee and a receive for the receiving employee.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    @livewire('device-transfer-picker')
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
