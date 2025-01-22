@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header">
            <h4 class="hk-pg-title">Clearance For Resignation</h4>
        </div>
        @if(session('swal'))
        <script>
            Swal.fire({
                icon: "{{ session('swal.icon') }}",
                title: "{{ session('swal.title') }}",
                text: "{{ session('swal.text') }}",
                showConfirmButton: true
            });
        </script>
        @endif
        <div class="mt-4 mb-50 row">
            @if ($clearanceResign->status == 'pending_resign')

            <button type="button" class="btn btn-success mr-3" data-toggle="modal" data-target="#uploadModal">
                Upload Signed Resignation Clearance
            </button>


            <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Upload Signed Clearance</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('employee.resign-upload-signature',[ 'id' => $employee->id , 'clr' =>$clearanceResign->id ]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="signature">Signature Image</label>
                                    <input type="file" class="form-control" id="signature" name="signature"
                                        accept="image/*" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            <button onclick="window.print()" class="btn btn-info mr-3">
                Print Clearance
            </button>
            <a href="{{ url()->previous() }}" class="btn btn-sky mr-3">
                Back
            </a>
            <!-- Upload Modal -->


        </div>
        <div class="row" id="PrintingArea">

            <div class="col-xl-12">
                <section class="hk-sec-wrapper hk-invoice-wrap pa-35">
                    <div class="invoice-from-wrap">
                        <div class="row">
                            <div class="col-sm-6 mb-20 text-center justify-self-center">
                                <img class="img-fluid invoice-brand-img d-block mb-20" width="250"
                                    src="{{ asset('X-Files/Dash/imgs/logo-blue.webp') }}" alt="brand">
                            </div>
                            <div class="col-sm-6 mb-20">
                                <h4 class="mb-35 font-weight-600">Clearance Details Of Orion Devices</h4>
                                <h4 class="mb-35 font-weight-600">Clearance <span style="color:#174094 "
                                        class="d-block font-18 font-weight-600">
                                        <h4>#{{ $clearanceResign->clear_code }}</h4>
                                    </span></h4>
                            </div>

                        </div>
                    </div>
                    <hr class="mt-0">
                    <div class="invoice-to-wrap pb-20">
                        <div class="row">
                            <div class="col-12 mb-30 text-center" style="justify-items: center">
                                <p><strong>Name:</strong>
                                {{ $employee->name }}
                                </p>
                                <p><strong>ID:</strong>
                                {{ $employee->employee_id }}
                                </p>
                                <img src="{{ asset('X-Files/Dash/imgs/EmployeeProfilePic/'. $employee->profile_image) }}" width="150px" height="150px" class="img-fluid circle" alt="img">
                            </div>
                        </div>
                    </div>
                    <h3 class="text-center px-5" style="color:#174094 ">I, the undersigned,<br> confirm that the
                        mentioned
                        <br>
                        devices and Items has been returned to the company
                    </h3>
                    <h5 class="mt-3" style="color:#174094 ">Items</h5>
                    <hr>
                    <div class="invoice-details" style="min-height:550px">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                @if(count($employee->devices) > 0)
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
                                        @foreach($employee->devices as $device)
                                        <tr>
                                            <td>{{ $device->device_code }}</td>
                                            <td>{{ $device->device_name }}</td>
                                            <td>{{ $device->device_type }}</td>
                                            <td>{{ $device->device_model }}</td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                @else
                                <h4>I have No Devices</h4>
                                @endif

                            </div>
                        </div>



                        @if(count($employee->sim_card) > 0)
                        <div class="table-wrap" style="margin-top: 50px">
                            <div class="table-responsive">
                                <h5>SIM Cards</h5>
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employee->sim_card as $sim)
                                        <tr>
                                            <td>{{ $sim->sim_serial }}</td>
                                            <td>{{ $sim->sim_number }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        @else
                        <h4>I have No Sim Card</h4>
                        @endif

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
                        <li>Contact the IT department through the provided channels for any necessary changes or
                            repairs.
                        </li>
                        <li>Any damage caused to the equipment due to negligence or misuse will be the responsibility of
                            the
                            receiver.</li>
                    </ul>
                </section>
            </div>
        </div>

    </div>
</div>

<script>
    function printClearance() {
    const printContent = document.getElementById('printingArea').innerHTML;
    const originalContent = document.body.innerHTML;
    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
}

</script>
@endsection
