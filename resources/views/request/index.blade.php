@extends('layouts.app')


@section('content')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .modal-content * {
            visibility: visible;
        }
        .modal {
            position: absolute;
            left: 0;
            top: 0;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .modal-dialog {
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 20px;
        }
        .modal-footer, .modal-header .close {
            display: none;
        }
        .signature-line {
            margin-top: 30px;
        }
    }
</style>
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Request Managment</h2>
                {{-- <p>Questions about onboarding lead data? <a href="#">Learn more.</a></p> --}}
            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div>
                <div class="row">
                    <div class="col-12">

                         <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Make New Request</h5>
                            <a href="{{ route('request.create') }}"
                                class="btn btn-gradient-primary btn-wth-icon btn-rounded icon-right">
                                <span class="btn-text">Make Request</span>
                                <span class="icon-label">
                                    <span class="feather-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-arrow-right-circle">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 16 16 12 12 8"></polyline>
                                            <line x1="8" y1="12" x2="16" y2="12"></line>
                                        </svg></span> </span>
                            </a>
                        </section>

                        <div class="hk-row">
                            <div class="col-sm-12">
                                {{-- start of content --}}
                                <div class="table-wrap mb-20">
                                    <div class="table-responsive">

                                        <div class="card">
                                            <div class="card-body pa-0">
                                                <div class="table-wrap">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-hover mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Code</th>

                                                                    <th>Name</th>

                                                                    <th>status</th>

                                                                    <th>Signture</th>
                                                                    <th>Manage</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach ($requests as $req)
                                                                <tr>

                                                                    <td>{{ $req->request_code }}</td>
                                                                    <td>{{ $req->employee->name }}</td>

                                                                    <td>
                                                                        {{ $req->status }}
                                                                    </td>

                                                                        <td class="text-center">
                                                                            <div class="btn-group" role="group">


                                                                                <!-- Print Button -->
                                                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#printModal{{ $req->id }}" title="Print Request">
                                                                                    <i class="fa fa-print"></i>
                                                                                </button>

                                                                                <!-- Upload Signature Button -->
                                                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#uploadModal{{ $req->id }}" title="Upload Signature">
                                                                                    <i class="fa fa-upload"></i>
                                                                                </button>


                                                                                <!-- Upload Modal -->
                                                                                <div class="modal fade" id="uploadModal{{ $req->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title">Upload Signed Document</h5>
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                    <span aria-hidden="true">×</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <form action="{{ route('request.upload.signature', $req->id) }}" method="POST" enctype="multipart/form-data">
                                                                                                @csrf
                                                                                                <div class="modal-body">
                                                                                                    <div class="form-group">
                                                                                                        <label>Upload Signed Document</label>
                                                                                                        <input type="file" name="signature" class="form-control" accept="image/*" required>
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
                                                                            </div>


                                                                    </td>

                                                                    <td class="text-center">
                                                                        <div class="btn-group" role="group">
                                                                            <a href="{{ route('request.show' , $req->id) }}"
                                                                                class="btn btn-sm btn-success"
                                                                                title="View Details">
                                                                                <i class="fa fa-eye"></i>
                                                                            </a>

                                                                            <button data-toggle="modal"
                                                                                data-target="#exampleModalCenter{{ $req->id }}"
                                                                                type="button"
                                                                                class="btn btn-sm btn-danger"
                                                                                data-toggle="modal"
                                                                                data-target="#exampleModalCenter8">
                                                                                <i class="icon-trash"></i>
                                                                            </button>
                                                                            <div class="modal fade"
                                                                                id="exampleModalCenter{{ $req->id }}"
                                                                                tabindex="-1" role="dialog"
                                                                                aria-labelledby="exampleModalCenter{{ $req->id }}"
                                                                                aria-hidden="true"
                                                                                style="display: none;">
                                                                                <div class="modal-dialog modal-dialog-centered"
                                                                                    role="document">
                                                                                    <div
                                                                                        class="modal-content  alert alert-warning ">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title">
                                                                                                Deleteing Request
                                                                                            </h5>
                                                                                            <button type="button"
                                                                                                class="close"
                                                                                                data-dismiss="modal"
                                                                                                aria-label="Close">
                                                                                                <span
                                                                                                    aria-hidden="true">×</span>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <p>Are You sure You want to
                                                                                                DELETE This Request
                                                                                                <span
                                                                                                    class="badge badge-soft-danger"></span>
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="modal-footer"
                                                                                            style="display: flex; justify-content: space-between;">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-dismiss="modal">Close</button>
                                                                                            <form
                                                                                                action="{{ route('request.destroy' , $req->id ) }}"
                                                                                                method="post">
                                                                                                @csrf
                                                                                                @method('delete')

                                                                                                <button type="button"
                                                                                                    data-dismiss="modal"
                                                                                                    class="btn btn-danger">Delete</button>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                </tr>

                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{ $requests->links() }}

                                    </div>
                                </div>
                                {{-- end of content --}}

                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="printModal{{ $req->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Request Details - {{ $req->request_code }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="printArea{{ $req->id }}">
                                    <!-- Print Header -->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="company-info">
                                            <img class="img-fluid invoice-brand-img d-block mb-20" width="250"
                                            src="{{ asset('X-Files/Dash/imgs/logo-blue.webp') }}" alt="brand">
                                            <p>Asset Request Form</p>
                                        </div>
                                        <div class="request-info text-right">

                                            <p><strong>Date:</strong> {{ $req->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>

                                    <!-- Requester Info -->
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">Requester Information</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Name:</strong> {{ $req->employee->name }}</p>
                                                    <p><strong>Position:</strong> {{ $req->employee->position->name }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <p><strong>Status:</strong> {{ $req->status }}</p> --}}
                                                    <p><strong>Department:</strong> {{ $req->employee->department->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Requested Items -->
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Requested Items</h5>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Item Type</th>
                                                        <th>Quantity</th>
                                                        <th>For</th>
                                                        <th>Receiver</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($req->items as $item)
                                                    <tr>
                                                        <td>{{ $item->item_type }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ $item->request_for_type }}</td>
                                                        <td>{{ $item->requested_for_name }}<br>
                                                            <small>{{ $item->requested_for_position }}</small>
                                                        </td>
                                                        <td>{{ $item->notes }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Signatures -->
                                    <div class="row mt-5">
                                        <div class="col-4 text-center">
                                            <div class="signature-line">
                                                <p>____________________</p>
                                                <p>Requester Signature</p>
                                            </div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div class="signature-line">
                                                <p>____________________</p>
                                                <p>IT Department Approval</p>
                                            </div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div class="signature-line">
                                                <p>____________________</p>
                                                <p>Manager Approval</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="printRequest({{ $req->id }})">Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        function printRequest(requestId) {
                            const printContent = document.getElementById(`printArea${requestId}`);
                            const originalContents = document.body.innerHTML;

                            document.body.innerHTML = printContent.innerHTML;
                            window.print();
                            document.body.innerHTML = originalContents;

                            // Reinitialize any necessary scripts/events after restoring content
                            location.reload();
                        }
                        </script>

                </div>
            </div>


        </div>
    </div>
</div>
@endsection
