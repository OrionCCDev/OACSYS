@extends('layouts.app')

@section('sweetalert')
<script>
    @if(session('success'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    @endif
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}'
        });
    @endif
</script>
@endsection

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">{{ $printer->name }}</h2>
                <p>
                    Rental Printer &mdash; PO {{ $printer->po_number }}
                    <span class="badge {{ ['active' => 'badge-success', 'transferred' => 'badge-info', 'cancelled' => 'badge-danger'][$printer->status] ?? 'badge-secondary' }} text-capitalize ml-2">{{ $printer->status }}</span>
                </p>
            </div>
            <div>
                <a href="{{ route('printers.index') }}" class="btn btn-secondary mr-2">Back to Report</a>
                <a href="{{ route('printers.reports.printer', $printer->id) }}" class="btn btn-outline-info mr-2">Printer Report</a>
                @if($printer->trashed())
                    <form action="{{ route('printers.restore', $printer->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success mr-2">Restore</button>
                    </form>
                    <form action="{{ route('printers.force-destroy', $printer->id) }}" method="POST" style="display:inline"
                          onsubmit="return confirm('Permanently delete this printer{{ $printer->invoices->count() ? ', its ' . $printer->invoices->count() . ' invoice(s)' : '' }} and every uploaded document? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Forever</button>
                    </form>
                @else
                    <a href="{{ route('project.details', $printer->project_id) }}" class="btn btn-info mr-2">View Project</a>
                    <a href="{{ route('printers.edit', $printer->id) }}" class="btn btn-primary mr-2">Edit</a>
                    <form action="{{ route('printers.destroy', $printer->id) }}" method="POST" style="display:inline"
                          onsubmit="return confirm('Delete this printer{{ $printer->invoices->count() ? ' and its ' . $printer->invoices->count() . ' invoice(s)' : '' }}? You can restore it afterwards from the Deleted filter.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endif
            </div>
        </div>

        @if($printer->trashed())
        <div class="alert alert-dark">
            <strong>This printer is deleted.</strong>
            It is hidden from the printers report, its project page and all reports, but nothing has been erased &mdash;
            deleted {{ $printer->deleted_at->diffForHumans() }}. Restore it to put it back into service.
        </div>
        @endif

        @if($printer->transferredFrom)
        <div class="alert alert-info">
            Continued from <a href="{{ route('printers.show', $printer->transferredFrom->id) }}">{{ $printer->transferredFrom->project->project_name ?? 'a previous project' }}</a>
            (ended {{ $printer->transferredFrom->end_date?->format('Y-m-d') }}).
        </div>
        @endif
        @if($printer->transferredTo)
        <div class="alert alert-warning">
            This printer's rental was transferred on to <a href="{{ route('printers.show', $printer->transferredTo->id) }}">{{ $printer->transferredTo->project->project_name ?? 'another project' }}</a>.
        </div>
        @endif

        <div class="hk-pg">
            <div class="row">
                <div class="col-12 col-md-4">
                    <section class="hk-sec-wrapper text-center">
                        <img src="{{ asset('X-Files/Dash/imgs/devices/' . $printer->main_image) }}" alt="" class="img-fluid img-thumbnail mb-20">
                        <table class="table table-sm text-left">
                            <tr><th>Model</th><td>{{ $printer->model ?? '-' }}</td></tr>
                            <tr><th>Serial Number</th><td>{{ $printer->serial_number ?? '-' }}</td></tr>
                            <tr><th>Supplier</th><td>{{ $printer->supplier->name ?? '-' }}</td></tr>
                            <tr><th>Project</th><td>{{ $printer->project->project_name ?? '-' }}</td></tr>
                            <tr><th>PO Number</th><td>{{ $printer->po_number }}</td></tr>
                            <tr>
                                <th>PO Document</th>
                                <td>
                                    @if($printer->po_document)
                                        <a href="{{ asset('X-Files/Dash/imgs/printers/po/' . $printer->po_document) }}" target="_blank">View</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr><th>Start Date</th><td>{{ $printer->start_date->format('Y-m-d') }}</td></tr>
                            <tr><th>End Date</th><td>{{ $printer->end_date?->format('Y-m-d') ?? '-' }}</td></tr>
                            <tr><th>Assigned To</th><td>{{ $printer->assignedToLabel() }}</td></tr>
                        </table>

                        @if($printer->status === 'active' && !$printer->trashed())
                        <button type="button" class="btn btn-outline-primary btn-block mb-2" data-toggle="modal" data-target="#deliveryModal">
                            Change Assignment
                        </button>
                        <button type="button" class="btn btn-warning btn-block mb-2" data-toggle="modal" data-target="#transferModal">
                            Transfer To Another Project
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-block" data-toggle="modal" data-target="#cancelModal">
                            Cancel Rental
                        </button>
                        @endif
                    </section>
                </div>

                <div class="col-12 col-md-8">
                    <section class="hk-sec-wrapper">
                        <div class="d-flex justify-content-between align-items-center mb-20">
                            <h5 class="hk-sec-title mb-0">Invoices</h5>
                            @unless($printer->trashed())
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addInvoiceModal">
                                Add Invoice
                            </button>
                            @endunless
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Number</th>
                                        <th>Released</th>
                                        <th>Period</th>
                                        <th>Payment Term</th>
                                        <th>Document</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($printer->invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->num }}</td>
                                        <td>{{ $invoice->released_date->format('Y-m-d') }}</td>
                                        <td>{{ $invoice->start_date->format('Y-m-d') }} &rarr; {{ $invoice->end_date->format('Y-m-d') }}</td>
                                        <td>{{ $invoice->payment_term ?? '-' }}</td>
                                        <td>
                                            @if($invoice->invoice_document)
                                                <a href="{{ asset('X-Files/Dash/imgs/printers/invoices/' . $invoice->invoice_document) }}" target="_blank">View</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @unless($printer->trashed())
                                            <div class="d-flex">
                                                <button type="button" class="btn btn-sm btn-outline-primary mr-1"
                                                        data-toggle="modal" data-target="#editInvoiceModal{{ $invoice->id }}">Edit</button>
                                                <form action="{{ route('printers.invoices.destroy', $invoice->id) }}" method="POST"
                                                      onsubmit="return confirm('Delete invoice {{ $invoice->num }} and its document? This cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </div>
                                            @endunless
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No invoices recorded yet.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

@if($printer->status === 'active' && !$printer->trashed())
<!-- Change Delivery Modal -->
<div class="modal fade" id="deliveryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="{{ route('printers.delivery', $printer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Change Assignment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Assigned To</label>
                        <select name="delivered_to_type" id="deliveredToTypeEdit" class="form-control" required>
                            <option value="client" {{ $printer->delivered_to_type == 'client' ? 'selected' : '' }}>Client</option>
                            <option value="consultant" {{ $printer->delivered_to_type == 'consultant' ? 'selected' : '' }}>Consultant</option>
                            <option value="office" {{ $printer->delivered_to_type == 'office' ? 'selected' : '' }}>Orion (our office)</option>
                        </select>
                    </div>
                    <div class="form-group delivery-target-group-edit" data-type="client" style="{{ $printer->delivered_to_type != 'client' ? 'display:none' : '' }}">
                        <label>Client</label>
                        <select name="target_id" class="form-control delivery-target-edit" {{ $printer->delivered_to_type != 'client' ? 'disabled' : '' }}>
                            <option value="">Select Client</option>
                            @foreach($clientEmployees as $client)
                            <option value="{{ $client->id }}" {{ $printer->client_employee_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group delivery-target-group-edit" data-type="consultant" style="{{ $printer->delivered_to_type != 'consultant' ? 'display:none' : '' }}">
                        <label>Consultant</label>
                        <select name="target_id" class="form-control delivery-target-edit" {{ $printer->delivered_to_type != 'consultant' ? 'disabled' : '' }}>
                            <option value="">Select Consultant</option>
                            @foreach($consultants as $consultant)
                            <option value="{{ $consultant->id }}" {{ $printer->consultant_id == $consultant->id ? 'selected' : '' }}>{{ $consultant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Transfer To Another Project Modal -->
<div class="modal fade" id="transferModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="{{ route('printers.transfer', $printer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Transfer To Another Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">This ends the printer's rental on {{ $printer->project->project_name ?? 'this project' }} and starts a new engagement under a new PO.</p>
                    <div class="form-group">
                        <label>Target Project</label>
                        <select name="project_id" class="form-control" required>
                            <option value="">Select Project</option>
                            @foreach($projects as $proj)
                            <option value="{{ $proj->id }}">{{ $proj->project_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>New PO Number</label>
                        <input type="text" name="po_number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>New PO Document</label>
                        <input type="file" name="po_document" class="form-control" accept="image/*,application/pdf">
                    </div>
                    <div class="form-group">
                        <label>Assigned To</label>
                        <select name="delivered_to_type" id="deliveredToTypeTransfer" class="form-control" required>
                            <option value="client">Client</option>
                            <option value="consultant">Consultant</option>
                            <option value="office">Orion (our office)</option>
                        </select>
                    </div>
                    <div class="form-group delivery-target-group-transfer" data-type="client">
                        <label>Client</label>
                        <select name="target_id" class="form-control delivery-target-transfer" required>
                            <option value="">Select Client</option>
                            @foreach($clientEmployees as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group delivery-target-group-transfer" data-type="consultant" style="display:none">
                        <label>Consultant</label>
                        <select name="target_id" class="form-control delivery-target-transfer" disabled>
                            <option value="">Select Consultant</option>
                            @foreach($consultants as $consultant)
                            <option value="{{ $consultant->id }}">{{ $consultant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ now()->toDateString() }}" required>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Transfer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cancel Rental Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="{{ route('printers.cancel', $printer->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Cancel Printer Rental</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">This marks the printer's rental as ended and returned to the supplier.</p>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ now()->toDateString() }}" required>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Cancel Rental</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Add Invoice Modal -->
@unless($printer->trashed())
@foreach($printer->invoices as $invoice)
<div class="modal fade" id="editInvoiceModal{{ $invoice->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="{{ route('printers.invoices.update', $invoice->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Invoice {{ $invoice->num }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Invoice Number</label>
                        <input type="text" name="num" class="form-control" value="{{ $invoice->num }}" required>
                    </div>
                    <div class="form-group">
                        <label>Released Date</label>
                        <input type="date" name="released_date" class="form-control" value="{{ $invoice->released_date?->format('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Period Start</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $invoice->start_date->format('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Period End</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $invoice->end_date->format('Y-m-d') }}" required>
                    </div>
                    <small class="form-text text-muted mb-2 d-block">These dates drive the billing coverage on the reports, so a wrong period shows up there as a gap or a double-billing.</small>
                    <div class="form-group">
                        <label>Payment Term</label>
                        <input type="text" name="payment_term" class="form-control" value="{{ $invoice->payment_term }}" placeholder="e.g. Net 30">
                    </div>
                    <div class="form-group">
                        <label>Invoice Document</label>
                        <input type="file" name="invoice_document" class="form-control" accept="image/*,application/pdf">
                        <small class="form-text text-muted">
                            @if($invoice->invoice_document)
                                <a href="{{ asset('X-Files/Dash/imgs/printers/invoices/' . $invoice->invoice_document) }}" target="_blank">Current document</a> &mdash; choose a file to replace it.
                            @else
                                No document uploaded yet.
                            @endif
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endunless

<div class="modal fade" id="addInvoiceModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="{{ route('printers.invoices.store', $printer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Invoice Number</label>
                        <input type="text" name="num" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Released Date</label>
                        <input type="date" name="released_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Period Start</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Period End</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                    <small class="form-text text-muted mb-2 d-block">Usually a full quarter (3 months) - can be shorter if this is the printer's last invoice before it transfers or is cancelled.</small>
                    <div class="form-group">
                        <label>Payment Term</label>
                        <input type="text" name="payment_term" class="form-control" placeholder="e.g. Net 30">
                    </div>
                    <div class="form-group">
                        <label>Invoice Document</label>
                        <input type="file" name="invoice_document" class="form-control" accept="image/*,application/pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function wireDeliveryToggle(selectId, groupClass, targetClass) {
        const select = document.getElementById(selectId);
        if (!select) return;
        select.addEventListener('change', function () {
            const type = this.value;
            document.querySelectorAll('.' + groupClass).forEach(function (group) {
                const isMatch = group.dataset.type === type;
                group.style.display = isMatch ? 'block' : 'none';
                const targetSelect = group.querySelector('.' + targetClass);
                targetSelect.disabled = !isMatch;
                targetSelect.required = isMatch;
            });
        });
    }
    wireDeliveryToggle('deliveredToTypeEdit', 'delivery-target-group-edit', 'delivery-target-edit');
    wireDeliveryToggle('deliveredToTypeTransfer', 'delivery-target-group-transfer', 'delivery-target-transfer');
</script>
@endsection
