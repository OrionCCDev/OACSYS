@extends('layouts.app')

@section('content')
<style>
    @media print {
    body * {
        visibility: hidden;
    }
    #PrintingArea, #PrintingArea * {
        visibility: visible;
    }
    #PrintingArea {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
    }
}
</style>
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header">
            <h4 class="hk-pg-title">Clearnace Details - {{ $clr->code }}</h4>
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
            @if ($clr->status == 'pending')

            <button type="button" class="btn btn-success mr-3" data-toggle="modal" data-target="#uploadModal">
                Upload Signed Clearnace
            </button>
            <form id="clr-dlt-btn-form"
                action="{{ route('clearance.destroy' , ['clearance' => $clr->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mr-3">
                    Cancel clr
                </button>
            </form>

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
                        <form action="{{ route('clearance.finish', $clr->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="signature">Signature Image</label>
                                    <input type="file" class="form-control" id="signature" name="receiving_signature"
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
            <button onclick="printClearance()" class="btn btn-info mr-3">
                Print Receiving
            </button>
            <a href="{{ route('clearance.index') }}" class="btn btn-sky mr-3">
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
                                        <h4>#{{ $clr->code }}</h4>
                                    </span></h4>
                            </div>

                        </div>
                    </div>
                    <hr class="mt-0">
                    <div class="invoice-to-wrap pb-20">
                        <div class="row">
                            <div class="col-12 mb-30 text-center" style="justify-items: center">
                                <p><strong>Name:</strong>
                                    {{ $clr->employee->name }}
                                </p>
                                <p><strong>ID:</strong>
                                    {{ $clr->employee->employee_id }}
                                </p>
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
                                @if(count($Devices) > 0)
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

                                        @foreach($Devices as $device)
                                        <tr>

                                            <td>{{ $device->device_code }}</td>
                                            <td>{{ $device->device_name }}</td>
                                            <td>{{ $device->device_type }}</td>
                                            <td>{{ $device->device_model }}</td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                @endif

                            </div>
                        </div>

                        @if(count($SimCards) > 0)
                        <div class="table-wrap" style="margin-top: 50px">
                            <div class="table-responsive">
                                <h5>SIM Cards</h5>
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Number</th>
                                            <th>Provider</th>
                                            <th>Plan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($SimCards as $sim)
                                        <tr>
                                            <td>{{ $sim->sim_number }}</td>
                                            <td>{{ $sim->sim_provider }}</td>
                                            <td>{{ $sim->sim_plan }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        @endif

                    </div>
                    <div class="row mt-30">
                        <div class="col-4 text-center" style="padding-bottom: 70px">
                            <h6>clrr Signature</h6>
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
                            clrr.</li>
                    </ul>
                </section>
            </div>
        </div>

    </div>
</div>

<script>

    function printClearance() {
        const printContent = document.getElementById('PrintingArea').innerHTML;
        const originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
    }

    function cancelClearance() {
        if(confirm('Are you sure you want to Delete this clearance?')) {
            window.location.href = "{{ route('clearance.cancel', $clr->id) }}";
        }
    }

</script>
@endsection
