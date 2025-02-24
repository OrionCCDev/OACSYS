@extends('layouts.app')

@section('content')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #PrintingArea * {
            visibility: visible;
            width: 100%;
            height: 100%;
        }
        #PrintingArea {
            position: absolute;
            left: 0;
            top: 0;
            margin: 0;
            padding: 0;
        }
    }
</style>
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Deduction Information</h2>
            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between" >
                                <button onclick="window.print()" class="btn btn-info btn-rounded mb-4 align-items-center">
                                    <span class="feather-icon mr-2 text-center" style="text-align: center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer">
                                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                            <rect x="6" y="14" width="12" height="8"></rect>
                                        </svg>
                                    </span>
                                <span>Print Deduction</span>
                                </button>
                                <button type="button" class="btn btn-success btn-rounded mb-4 d-flex align-items-center" data-toggle="modal" data-target="#uploadSignedReport">
                                    <span class="feather-icon mr-2 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="17 8 12 3 7 8"></polyline>
                                            <line x1="12" y1="3" x2="12" y2="15"></line>
                                        </svg>
                                    </span>
                                <span>Upload Signed Report</span>
                                </button>
                                <a href="{{ url()->previous() }}"  class="btn btn-danger btn-rounded mb-4">

                                Back
                                </a>
                                <div class="modal fade" id="uploadSignedReport" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Upload Signed Deduction Report</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('deductions.upload-signed', $deduction->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Select Signed Report PDF/Image</label>
                                                        <input type="file" name="signed_deduction" class="form-control" accept=".jpg,.jpeg,.png" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success">Upload Report</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="PrintingArea">
                            <section class="hk-sec-wrapper hk-invoice-wrap pa-35">
                                <div class="invoice-from-wrap">
                                    <div class="row">
                                        <div class="col-sm-6 mb-20 text-center justify-self-center">
                                            <img class="img-fluid invoice-brand-img d-block mb-20" width="250"
                                                src="{{ asset('X-Files/Dash/imgs/logo-blue.webp') }}" alt="brand">

                                        </div>
                                        <div class="col-sm-6 mb-20 text-right">
                                            <h3>Deduction Report</h3>
                                            <h4>Date: {{ $deduction->created_at->format('d/m/Y') }}</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        <h5>Employee Information</h5>
                                        <p><strong>Name:</strong> {{ $deduction->employee->name }}</p>
                                        <p><strong>ID:</strong> {{ $deduction->employee->employee_id }}</p>
                                        <p><strong>Department:</strong> {{ $deduction->employee->department->name }}</p>
                                        <p><strong>Position:</strong> {{ $deduction->employee->position->name }}</p>
                                    </div>
                                    @if($deduction->device_id)
                                    <div class="col-md-6">
                                        <h5>Device Information</h5>
                                        <p><strong>Device Name:</strong> {{ $deduction->device->device_name }}</p>
                                        <p><strong>Device Code:</strong> {{ $deduction->device->device_code }}</p>
                                        <p><strong>Type:</strong> {{  $deduction->device->device_type }}</p>
                                    </div>
                                    @endif
                                </div>

                                <div class="row mb-5">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5>Deduction Details</h5>
                                                <p><strong>Reason:</strong> {{ $deduction->reason }}</p>
                                                <p><strong>Amount:</strong> {{ number_format($deduction->amount, 2) }} AED</p>
                                                <p><strong>Description:</strong> {{ $deduction->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-4 text-center">
                                        <p>_______________________</p>
                                        <p>IT Manager</p>
                                    </div>
                                    <div class="col-4 text-center">
                                        <p>_______________________</p>
                                        <p>HR Signature</p>
                                    </div>
                                    <div class="col-4 text-center">
                                        <p>_______________________</p>
                                        <p>Top Management Signature</p>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                @if($deduction->image)
                                <div class="row mt-5">
                                    <div class="col-12 text-center">
                                        <h5 class="mb-50">Signed Deduction Document</h5>
                                        <img src="{{ asset('X-Files/Dash/imgs/deductions/' . $deduction->image) }}" class="img-fluid" alt="Signed Deduction">
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
