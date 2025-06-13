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
                <h2 class="hk-pg-title font-weight-600 mb-10">Devices Clearance</h2>
                {{-- <p>Questions about onboarding lead data? <a href="#">Learn more.</a></p> --}}
            </div>
        </div>
        <!-- Title -->
        <div class="container">
            <!-- Title -->
            <div class="hk-pg-header mb-10">
                <div>
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg></span></span>Clearing</h4>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button style="margin-right: 15px" type="button" class="btn btn-success " data-toggle="modal" data-target="#exampleModalForms" class="btn btn-secondary btn-wth-icon btn-rounded icon-right">
                        <span class="btn-text">Upload Clearance Signture</span>

                    </button>
                    <div class="modal fade" id="exampleModalForms" tabindex="-1" role="dialog" aria-labelledby="exampleModalForms" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Upload Clearance</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('device.clear', ['id' => $device->id , 'clear' => $newClearance->id ]) }}"
                                            method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                            <div class="form-control text-truncate" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                            <span class="input-group-append">
                                                <span class="btn btn-primary btn-file">
                                                    <span class="fileinput-new">Select file</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="clearing_signature" id="imageInput" accept="image/*">
                                                </span>
                                            </span>
                                            <a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                        <div class="mt-3">
                                            <img id="imagePreview" src="#" alt="Preview" style="max-width: 200px; display: none;">
                                        </div>
                                    </div>

                                    <script>
                                    document.getElementById('imageInput').onchange = function(evt) {
                                        const [file] = this.files;
                                        if (file) {
                                            const preview = document.getElementById('imagePreview');
                                            preview.src = URL.createObjectURL(file);
                                            preview.style.display = 'block';
                                        }
                                    };
                                    </script>
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                        <button data-dismiss="modal" class="btn btn-danger">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('device.index') }}" style="margin-right: 15px" class="btn btn-primary btn-rounded ">Back To Devices List</a>
                    <form action="" method="post">
                        @csrf
                        @method('DELETE')

                        <button
                             class="btn btn-danger btn-rounded" style="margin-right: 15px">

                            <span class="btn-text">Cancel</span>
                        </button>
                    </form>
                    <button
                    onclick="printReceiving()"
                         class="btn btn-info btn-rounded ">

                         <span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg></span>
                    </button>

                </div>
            </div>
            <!-- /Title -->
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">All His Devices</h5>
                <p class="mb-25">Devices</p>
                <div class="row">
                    <div class="col-sm">
                        <div class="card">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 mt-2">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Img</th>
                                                <th>Type</th>
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($hisDevices as $dvc)
                                            <tr>

                                                <td>{{ $dvc->device_code }}</td>
                                                <td>{{ $dvc->device_name }}</td>
                                                <td>
                                                    <img class="img-fluid rounded"
                                                    src="{{ asset('X-Files/Dash/imgs/devices/' . $dvc->main_image ) }}"
                                                    width="50" height="50" alt="icon">
                                                </td>
                                                <td>{{ $dvc->device_type }}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-rounded">Add</button>
                                                </td>


                                            </tr>
                                            @endforeach
                                            @if ($simCards)
                                            <tr>
                                                <td colspan="5">
                                                    <h5 class="hk-sec-title">Sim Cards</h5>
                                                    <p class="mb-25">Sim Cards</p>
                                                    <div class="table-wrap">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover mb-0 mt-2">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Code</th>
                                                                        <th>Number</th>
                                                                        <th>Manage</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($simCards as $sim)
                                                                    <tr>
                                                                        <td>{{ $sim->sim_serial }}</td>
                                                                        <td>{{ $sim->sim_number }}</td>
                                                                        <td>
                                                                            <button class="btn btn-primary btn-rounded">Add</button>
                                                                        </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Row -->
            <div class="row" id="PrintingArea">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper hk-invoice-wrap pa-35" >
                        <div class="invoice-from-wrap">
                            <div class="row">
                                <div class="col-sm-6 mb-20 text-center justify-self-center">
                                    <img class="img-fluid invoice-brand-img d-block mb-20" width="250" src="{{ asset('X-Files/Dash/imgs/logo-blue.webp') }}" alt="brand">
                                </div>
                                <div class="col-sm-6 mb-20">
                                    <h4 class="mb-35 font-weight-600">Clearance Details Of Orion Devices</h4>
                                    <h4 class="mb-35 font-weight-600">Clearance <span style="color:#174094 " class="d-block font-18 font-weight-600">#{{ $newClearance->clear_code }}</span></h4>
                                </div>

                            </div>
                        </div>
                        <hr class="mt-0">
                        <div class="invoice-to-wrap pb-20">
                            <div class="row">
                                <div class="col-12 mb-30 text-center" style="justify-items: center">

                                    <h6 class="mb-5">Date : <span  style="color:#174094 ">{{ now()->format('Y-m-d') }}</span></h6>
                                    @if ($device->employee_id != null)
                                        <h6 class="mb-5">Name : <span  style="color:#174094 ">{{ $device->employee->name }}</span></h6>
                                        <h6 class="mb-5">Orion-ID : <span  style="color:#174094 ">{{ $device->employee->employee_id }}</span></h6>
                                        <h6 class="mb-5">Department : <span  style="color:#174094 ">{{ $device->employee->department->name }}</span></h6>

                                    @endif
                                    @if ($device->client_id != null)
                                    <h6 class="mb-5">Name : <span  style="color:#174094 ">{{ $device->clientEmployee->name }}</span></h6>
                                    @endif
                                    @if ($device->consultant_id != null)
                                    <h6 class="mb-5">Name : <span  style="color:#174094 ">{{ $device->consultant->name }}</span></h6>
                                    @endif
                                    @if ($device->project_id != null)
                                        <h6 class="mb-5">Project : <span  style="color:#174094 ">{{ $device->project->project_code }}</span></h6>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <h3 class="text-center px-5" style="color:#174094 ">I, the undersigned, confirm that the above-mentioned device has been returned to the company</h3>
                        <h5 class="mt-3" style="color:#174094 ">Items</h5>
                        <hr>
                        <div class="invoice-details" style="min-height:550px">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Model</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>{{ $device->device_code }}</td>
                                                <td>
                                                    {{ $device->device_name }}
                                                </td>
                                                <td>{{ $device->device_type }}</td>
                                                <td>
                                                    {{ $device->device_model }}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-30">
                            <div class="col-4 text-center" style="padding-bottom: 70px">
                                <h6>Receiver Signature</h6>
                            </div>
                            <div class="col-4 text-center" style="padding-bottom: 70px">
                                <h6>IT Manager</h6>
                            </div>
                            <div class="col-4 text-center" style="padding-bottom: 70px">
                                <h6>Top Management Signature</h6>
                            </div>
                        </div>
                        <hr>
                        <ul class="invoice-terms-wrap font-14 list-ul">
                            <h6>By Signing This paper You Accept The Following Roles</h6>
                        <li>Do not make any unauthorized modifications or repairs to the equipment.</li>
                        <li>Handle all equipment with care to avoid damage.</li>
                        <li>Use appropriate packaging and protective materials during transportation and storage.</li>
                        <li>For any updates, modifications, or fixes, the equipment must be returned to the IT
                            department.
                        </li>
                        <li>All received equipment must be used exclusively for work-related purposes and personal use is strictly prohibited.</li>
                        <li>SIM cards provided are for business communications only; personal calls and messages are not permitted.</li>
                        <li>Any damage caused to the equipment due to negligence or misuse will be the responsibility of
                            the
                            receiver.</li>
                        </ul>
                    </section>
                </div>
            </div>
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
