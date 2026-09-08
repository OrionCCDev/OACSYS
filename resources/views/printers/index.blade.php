@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Rental Printers Report</h2>
                <p>Every rental printer we track, its PO, and where it currently is.</p>
            </div>
            <div>
                <a href="{{ route('printers.reports.projects') }}" class="btn btn-info mr-2">Report by Project</a>
                <a href="{{ route('supplier.index') }}" class="btn btn-secondary mr-2">Suppliers</a>
                <a href="{{ route('printers.create') }}" class="btn btn-gradient-primary btn-rounded">Add Printer</a>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <form method="GET" action="{{ route('printers.index') }}" class="form-inline mb-20">
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Search</div>
                                </div>
                                <input type="text" name="search" class="form-control" placeholder="Name, model, serial, PO number, supplier" value="{{ request('search') }}">
                            </div>
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Status</div>
                                </div>
                                <select name="status" class="form-control">
                                    <option value="active" {{ request('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="transferred" {{ request('status') == 'transferred' ? 'selected' : '' }}>Transferred</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="deleted" {{ request('status') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Filter</button>
                            @if(request('search') || request('status'))
                            <a href="{{ route('printers.index') }}" class="btn btn-secondary mb-2 ml-2">Clear</a>
                            @endif
                        </form>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Model</th>
                                        <th>Supplier</th>
                                        <th>Project</th>
                                        <th>Assigned To</th>
                                        <th>PO Number</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($printers as $printer)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('X-Files/Dash/imgs/devices/' . $printer->main_image) }}" alt="" width="50" height="50" style="object-fit:cover">
                                        </td>
                                        <td>{{ $printer->name }}</td>
                                        <td>{{ $printer->model ?? '-' }}</td>
                                        <td>{{ $printer->supplier->name ?? '-' }}</td>
                                        <td>{{ $printer->project->project_name ?? '-' }}</td>
                                        <td>{{ $printer->assignedToLabel() }}</td>
                                        <td>{{ $printer->po_number }}</td>
                                        <td>
                                            <span class="badge {{ ['active' => 'badge-success', 'transferred' => 'badge-info', 'cancelled' => 'badge-danger'][$printer->status] ?? 'badge-secondary' }} text-capitalize">
                                                {{ $printer->status }}
                                            </span>
                                            @if($printer->trashed())
                                                <span class="badge badge-dark">deleted</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($printer->trashed())
                                                <form action="{{ route('printers.restore', $printer->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                                </form>
                                                <form action="{{ route('printers.force-destroy', $printer->id) }}" method="POST" style="display:inline"
                                                      onsubmit="return confirm('Permanently delete this printer, its invoices and its documents? This cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete Forever</button>
                                                </form>
                                            @else
                                                <a href="{{ route('printers.show', $printer->id) }}" class="btn btn-sm btn-info">View / History</a>
                                                <a href="{{ route('printers.reports.printer', $printer->id) }}" class="btn btn-sm btn-outline-info">Report</a>
                                                <a href="{{ route('printers.edit', $printer->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No printers found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $printers->links() }}
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
