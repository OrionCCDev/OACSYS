@extends('layouts.app')

@section('scripts')

@endsection

@section('content')
<style>
    @media print {
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        img {
            max-width: 100%;
            max-height: 100vh;
        }

        body {
            height: auto;
        }
    }
</style>
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header mb-4">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"></span></span>Request Details
            </h4>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center" id="request-header">
                <h5>Request #{{ $request->request_code }}</h5>
                <div class="btn-group">
                    @if (Auth::user()->hasRole(['o-admin', 'o-super-admin']))
                        @if($request->status == 'pending-receive' || $request->status == 'approved')
                            @if ($request->image !== null)
                                <button onclick="printImage()" id="btn-of-print" class="btn btn-info">
                                    <i class="fa fa-print"></i> Print Signed Document
                                </button>
                                <script>
                                    function printImage() {
                                        var printWindow = window.open('', '_blank', 'width=600,height=400');
                                        var img = document.getElementById('imageToPrint');

                                        printWindow.document.write('<html><head><title>Print Image</title></head><body>');
                                        printWindow.document.write('<img src="' + img.src + '" alt="Image to Print">');
                                        printWindow.document.write('</body></html>');
                                        printWindow.document.close();
                                        printWindow.print();}
                                </script>
                            @endif
                        @endif
                    @endif




                    @if (Auth::user()->hasRole(['o-admin', 'o-super-admin']))


                            @if($request->status === 'pending' || $request->status === 'pending-approve')
                                <!-- Edit Button -->
                                <a href="{{ route('asset-request.edit', $request->id) }}" class="btn btn-primary">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            @endif

                                @if($request->status === 'approved')
                                <!-- Reject Button -->
                                <form action="{{ route('asset-request.reject', $request->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fa fa-times"></i> Reject
                                    </button>
                                </form>
                                @elseif($request->status === 'pending-approve' || $request->status === 'pending')
                                <!-- Approve Button -->
                                <form action="{{ route('asset-request.approve', $request->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                </form>
                                @endif


                            <!-- Delete Button -->
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content alert alert-warning">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Request</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this request?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <form action="{{ route('asset-request.destroy', $request->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    @endif
                </div>
            </div>

            <div class="card-body main-info" id="printAreaRequired">
                <!-- Request Info -->
                <div class="row mb-4" id="requestInfo">
                    <div class="col-md-6">
                        <h6>Requester Information</h6>
                        <p><strong>Name:</strong> {{ $request->employee->name }}</p>
                        <p><strong>Position:</strong> {{ $request->employee->position->name }}</p>
                        <p><strong>Department:</strong> {{ $request->employee->department->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Request Details</h6>
                        <p><strong>Status:</strong> {{ $request->status }}</p>
                        <p><strong>Date:</strong> {{ $request->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                <!-- Requested Items -->
                <div class="row mb-4" id="requestItems">
                    <div class="col-12">
                        <h6>Requested Items</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item Type</th>
                                        <th>Quantity</th>
                                        <th>For</th>
                                        <th>Receiver</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($request->items as $item)
                                    <tr>
                                        <td>{{ $item->item_type }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->request_for_type }}</td>
                                        <td>
                                            {{ $item->requested_for_name }}<br>
                                            <small>{{ $item->requested_for_position }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Signature Section -->
                @if($request->image)
                <div class="col-12">
                    <h6>Signed Document</h6>
                    <img src="{{ asset('X-Files/Dash/imgs/request/' . $request->image) }}" id="imageToPrint"
                        alt="Signed Document" class="img-fluid">
                </div>
                @endif

                @if (Auth::user()->hasRole(['o-admin', 'o-super-admin']))

                <a href="{{ route('asset-request.index') }}" type="submit" class="btn btn-info mb-2">Back</a>

                @elseif(Auth::user()->hasRole(['o-manager']))
                <a href="{{ route('manager.show' , ['manager' => Auth::user()->id]) }}?tab=list-of-req" type="submit"
                    class="btn btn-info mb-2">Back</a>

                @endif

            </div>
        </div>
    </div>

</div>


@endsection
