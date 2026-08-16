@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Device QR Code</h2>
                <p>{{ $device->device_name }} ({{ $device->device_code }})</p>
            </div>
            <div class="d-flex">
                <a href="{{ route('device.show', $device->id) }}" class="btn btn-secondary btn-sm mr-2">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <a href="{{ route('device.qr.print', $device->id) }}" target="_blank" class="btn btn-primary btn-sm">
                    <i class="fa fa-print"></i> Print Label
                </a>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-auto">
                <div class="card text-center p-4">
                    <div class="qr-svg-wrap">{!! $qrSvg !!}</div>
                    <h5 class="mt-3 mb-0">{{ $device->device_name }}</h5>
                    <p class="text-muted mono mb-0">{{ $device->device_code }}</p>
                </div>
                <p class="text-muted text-center mt-3" style="max-width: 320px;">
                    This QR code is fixed to this device - it always points to this same
                    device record. "Print Label" opens a bare, correctly-sized page for a
                    Phomemo M110/M120 50&times;30mm label and prints it directly. Scanning
                    the code requires an admin login and opens this device's data, current
                    holder, last activity, and full receive/clearance history.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .qr-svg-wrap svg { width: 280px; height: 280px; }
</style>
@endsection
