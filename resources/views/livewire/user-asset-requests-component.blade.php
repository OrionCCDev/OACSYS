<div>
    <div class="profile-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>My Asset Requests</h3>
            <a href="{{ route('asset-request.create') }}" class="btn btn-primary">
                <i class="ion ion-md-add mr-1"></i>New Request
            </a>
        </div>

        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if($requests->isEmpty())
        <div class="p-4 text-center text-gray-500">
            No requests found. Click the "New Request" button to create one.
        </div>
        @else
        <div class="table-container">
            <table class="profile-table">
                <thead>
                    <tr>
                        <th>Request Code</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Items</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                    <tr>
                        <td>{{ $request->request_code }}</td>
                        <td>
                            @switch($request->status)
                            @case('pending')
                            <span class="badge badge-warning">Pending</span>
                            @break
                            @case('pending-receive')
                            <span class="badge badge-info">Pending Receive</span>
                            @break
                            @case('pending-approve')
                            <span class="badge badge-primary">Pending Approval</span>
                            @break
                            @case('approved')
                            <span class="badge badge-success">Approved</span>
                            @break
                            @case('rejected')
                            <span class="badge badge-danger">Rejected</span>
                            @break
                            @default
                            <span class="badge badge-secondary">{{ $request->status }}</span>
                            @endswitch
                        </td>
                        <td>{{ $request->created_at->format('d M Y, h:i A') }}</td>
                        <td>{{ $request->items->count() }}</td>
                        <td class="actions">
                            <a href="{{ route('asset-request.show', $request->id) }}" class="btn btn-sm btn-info mr-1"
                                title="View Details">
                                <i class="ion ion-md-eye"></i>
                            </a>
                            @if (in_array($request->status, ['approved']))
                                    <!-- Print Button -->
                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#printModal{{ $request->id }}" title="Print Request">
                                        <i class="fa fa-print"></i>
                                    </button>
                                    <!-- Upload Signature Button -->
                                    <button type="button" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#uploadModal{{ $request->id }}" title="Upload Signature">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                    <!-- Upload Modal -->
                                    <div class="modal fade" id="uploadModal{{ $request->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Upload Signed Document</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('asset-request.upload-signature', $request->id) }}" method="POST" enctype="multipart/form-data">
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
                            @endif

                            @if(in_array($request->status, ['pending', 'pending-receive']))
                                <a href="{{ route('asset-request.edit', $request->id) }}"
                                    class="btn btn-sm btn-warning mr-1" title="Edit Request">
                                    <i class="ion ion-md-create"></i>
                                </a>



                                <button  data-toggle="modal"
                                data-target="#exampleModalCenter{{ $request->id }}" type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModalCenter8">
                                <i class="icon-trash"></i>
                                </button>
                                <div class="modal fade" id="exampleModalCenter{{ $request->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenter{{ $request->id }}" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content  alert alert-warning ">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Deleteing Asset Request</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are You sure You want to DELETE This  Request <br> <span class="badge badge-soft-danger">{{ $request->request_code }}</span></p>
                                            </div>
                                            <div class="modal-footer" style="display: flex; justify-content: space-between;">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button wire:click="deleteRequest({{ $request->id }})" class="btn btn-danger"
                                                    title="Delete Request"
                                                    >
                                                    <i class="ion ion-md-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $requests->links() }}
        </div>
        @endif
    </div>
    @if (in_array($request->status, ['approved']))
        @foreach ($requests as $req )
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
                            <div class="card" style="max-width: 100%">
                                <div class="card-body">
                                    <h5 class="card-title">Requested Items</h5>
                                    <table class="table table-bordered"  style="max-width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Item Type</th>
                                                <th>Quantity</th>
                                                <th>For</th>
                                                <th>Receiver</th>

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

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Signatures -->
                            <div class="row mt-5">

                                <div class="col-6 text-center">
                                    <div class="signature-line">
                                        <p>____________________</p>
                                        <p>IT Department Approval</p>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
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
        @endforeach
    @endif
    <style>
        .actions {
            white-space: nowrap;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-warning {
            background: #fff8e1;
            color: #f59e0b;
        }

        .badge-info {
            background: #e0f2fe;
            color: #0ea5e9;
        }

        .badge-primary {
            background: #dbeafe;
            color: #3b82f6;
        }

        .badge-success {
            background: #dcfce7;
            color: #16a34a;
        }

        .badge-danger {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-secondary {
            background: #f3f4f6;
            color: #6b7280;
        }
    </style>
</div>
