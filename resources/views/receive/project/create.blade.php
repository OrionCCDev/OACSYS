@extends('layouts.app')

@push('styles')
<!-- Add any additional styles here -->
@endpush

@section('content')
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Project Devices Receiving</h2>
            </div>
        </div>
        <!-- Title -->
        <div class="container">
            <!-- Title -->
            <div class="hk-pg-header mb-10">
                <div>
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-book">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                </svg></span></span>Receiving</h4>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    @if ($receive->status == 'pending')
                    <button style="margin-right: 15px" type="button" class="btn btn-success " data-toggle="modal"
                        data-target="#exampleModalForms" class="btn btn-secondary btn-wth-icon btn-rounded icon-right">
                        <span class="btn-text">Upload Receiving Signature</span>
                    </button>
                    <div class="modal fade" id="exampleModalForms" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalForms" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Upload Receiving</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="uploadForm" action="{{ route('project.receive.finish', ['id' => $receive->id]) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="devices" value="{{ json_encode($devicesData) }}">
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
                                                        <input type="file" name="receiving_signature" id="imageInput" accept="image/*">
                                                    </span>
                                                </span>
                                                <a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                            <div class="mt-3">
                                                <img id="imagePreview" src="#" alt="Preview" style="max-width: 200px; display: none;">
                                            </div>
                                            <div id="validationMessage" class="text-danger mt-2" style="display: none;"></div>
                                        </div>

                                        <script>
                                            document.getElementById('imageInput').onchange = function(evt) {
                                                const [file] = this.files;
                                                const validationMessage = document.getElementById('validationMessage');
                                                validationMessage.style.display = 'none';
                                                validationMessage.innerText = '';

                                                if (file) {
                                                    const preview = document.getElementById('imagePreview');
                                                    preview.src = URL.createObjectURL(file);
                                                    preview.style.display = 'block';

                                                    // Validate file type
                                                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/svg+xml'];
                                                    if (!validTypes.includes(file.type)) {
                                                        validationMessage.innerText = 'Invalid file type. Only JPEG, PNG, JPG, and SVG are allowed.';
                                                        validationMessage.style.display = 'block';
                                                        preview.style.display = 'none';
                                                        return;
                                                    }

                                                    // Validate file size (max 2MB)
                                                    const maxSize = 2 * 1024 * 1024; // 2MB
                                                    if (file.size > maxSize) {
                                                        validationMessage.innerText = 'File size exceeds 2MB.';
                                                        validationMessage.style.display = 'block';
                                                        preview.style.display = 'none';
                                                        return;
                                                    }
                                                }
                                            };

                                            document.getElementById('uploadForm').onsubmit = function(evt) {
                                                const fileInput = document.getElementById('imageInput');
                                                const validationMessage = document.getElementById('validationMessage');
                                                if (!fileInput.files.length) {
                                                    validationMessage.innerText = 'Please select a file to upload.';
                                                    validationMessage.style.display = 'block';
                                                    evt.preventDefault();
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
                    <form action="{{ route('project.receive.destroy' , ['receive' => $receive->id] ) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-rounded" style="margin-right: 15px">
                            <span class="btn-text">Delete</span>
                        </button>
                    </form>
                    @endif

                    <button type="button" class="btn btn-success btn-rounded mx-10" onclick="window.history.back();">Go Back</button>

                    {{-- <a href="{{ route('device.index') }}" style="margin-right: 15px"
                        class="btn btn-primary btn-rounded ">Back To Devices List</a> --}}
                    <button onclick="printReceiving()" class="btn btn-info btn-rounded ">
                        <span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer">
                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                </path>
                                <rect x="6" y="14" width="12" height="8"></rect>
                            </svg></span>
                    </button>
                </div>
            </div>
            <!-- /Title -->

            <!-- Row -->
            <div class="row" id="PrintingArea">
                @if ($receive->status != 'received')
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper hk-invoice-wrap pa-35">
                        <div class="invoice-from-wrap">
                            <div class="row">
                                <div class="col-sm-6 mb-20 text-center justify-self-center">
                                    <img class="img-fluid invoice-brand-img d-block mb-20" width="250"
                                        src="{{ asset('X-Files/Dash/imgs/logo-blue.webp') }}" alt="brand">
                                </div>
                                <div class="col-sm-6 mb-20">
                                    <h4 class="mb-35 font-weight-600">Receiving Details Of {{ $project->project_name }} Devices</h4>
                                    <h4 class="mb-35 font-weight-600">Receiving <span style="color:#174094 "
                                            class="d-block font-18 font-weight-600">#{{ $receive_id }}</span></h4>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-0">
                        <div class="invoice-to-wrap pb-20">
                            <div class="row">
                                <div class="col-12 mb-30 text-center" style="justify-items: center">
                                    <h6 class="mb-5">Date : <span style="color:#174094 ">{{ now()->format('Y-m-d')
                                            }}</span></h6>
                                    @if($receiver_type == 'project')
                                        <h6 class="mb-5">Project : <span style="color:#174094 ">{{ $project->project_name }}</span></h6>
                                        <h6 class="mb-5">Code : <span style="color:#174094 ">{{ $project->project_code }}</span></h6>
                                        @if($receiver)
                                            <h6 class="mb-5">Project Manager : <span style="color:#174094 ">{{ $receiver->name ?? $receiver->company_name }}</span></h6>
                                        @endif
                                    @else
                                        @if ($receiver_type == 'employee')
                                            <h6 class="mb-5">Orion-ID : <span style="color:#174094 ">{{ $receiver->employee_id }}</span></h6>
                                            <h6 class="mb-5">Department : <span style="color:#174094 ">{{ $receiver->department->name }}</span></h6>
                                            @if ($receiver->project_id != null)
                                                <h6 class="mb-5">Project : <span style="color:#174094 ">{{ $receiver->project->project_code }}</span></h6>
                                            @endif
                                        @endif
                                        @if ($receiver_type != 'employee' && $receiver->project_id != null)
                                            <h6 class="mb-5">Project : <span style="color:#174094 ">{{ $receiver->project->project_code }}</span></h6>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <h4 class="text-center" style="color:#174094;font-size:larger ">
                            @if($receiver_type == 'project')
                                I, the undersigned Project Manager,<br>
                                acknowledge that My project have received the following items And Deliver to the designated receiver under signed
                            @else
                                I, the undersigned,<br>
                                acknowledge that I have received the following items
                            @endif
                        </h4>
                        <h5 class="pt-20" style="color:#174094 ">Items</h5>
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
                                            @foreach ($devicesData as $device )
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if (isset($simCardsData) && count($simCardsData) > 0)
                            <div class="table-wrap mt-20">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Sim Number</th>
                                                <th>Sim Plan</th>
                                                <th>Sim Provider</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($simCardsData as $sim )
                                            <tr>
                                                <td>
                                                    <span>{{ $sim->sim_number }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $sim->sim_plan }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $sim->sim_provider }}</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="row mt-30">
                            <ul class="invoice-terms-wrap font-14 list-ul">
                                <li>Receiver name :</li>
                                <li>Receiver Position :</li>
                                <li>Receiver Signature :
                                </li>

                            </ul>
                        </div>
                        <hr>
                        <div class="row mt-30">
                            <div class="col-4 text-center" style="padding-bottom: 70px">
                                <h6>Project Stamp</h6>
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
                            <h6>By Signing This paper You Accept The Following Terms and Conditions</h6>

                            <li>Handle all equipment with care to avoid damage.</li>
                            <li>Use appropriate packaging and protective materials during transportation and storage.
                            </li>

                            <li>Contact the IT department through the provided channels for any necessary changes or
                                repairs.</li>
                            <li>Any damage caused to the equipment due to negligence or misuse will be the
                                responsibility of the receiver.</li>
                        </ul>
                    </section>
                </div>
                @else
                <div class="col-xl-12">
                    <img src="{{ asset('X-Files/Dash/imgs/receives/' . $receive->receive_image ) }}" width="100%" height="100%" alt="">
                </div>
                @endif
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
