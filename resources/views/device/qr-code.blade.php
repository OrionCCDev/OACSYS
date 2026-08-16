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
                <button type="button" onclick="window.print()" class="btn btn-primary btn-sm">
                    <i class="fa fa-print"></i> Print Label
                </button>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-auto">
                <div id="qr-print-area" class="card text-center p-4">
                    <div class="qr-svg-wrap">{!! $qrSvg !!}</div>
                    <h5 class="mt-3 mb-0 no-print">{{ $device->device_name }}</h5>
                    <p class="text-muted mono mb-0">{{ $device->device_code }}</p>
                </div>
                <p class="text-muted text-center mt-3 no-print" style="max-width: 320px;">
                    This QR code is fixed to this device - it always points to this same
                    device record. Print and attach it to the physical device (sized for a
                    Phomemo M110/M120 40&times;30mm label). Scanning it requires an admin
                    login and opens this device's data, current holder, last activity, and
                    full receive/clearance history.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .qr-svg-wrap svg { width: 280px; height: 280px; }

    @media print {
        @page {
            size: 40mm 30mm;
            margin: 0;
        }

        body * { visibility: hidden; }
        #qr-print-area, #qr-print-area * { visibility: visible; }
        .no-print { display: none !important; }

        #qr-print-area {
            position: fixed;
            top: 0;
            left: 0;
            width: 40mm;
            height: 30mm;
            margin: 0;
            padding: 1mm;
            border: none !important;
            box-shadow: none !important;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }

        #qr-print-area .qr-svg-wrap svg {
            width: 24mm !important;
            height: 24mm !important;
        }

        #qr-print-area .mono {
            font-size: 6pt;
            line-height: 1;
            margin-top: 0.8mm !important;
            white-space: nowrap;
        }
    }
</style>
@endsection
