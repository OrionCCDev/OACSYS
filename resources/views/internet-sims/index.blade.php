@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container-fluid mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Internet SIMs</h2>
                <p>
                    The site internet lines behind routers and cameras.
                    <span class="text-muted">Separate from the SIM Cards module, which tracks SIMs issued to people as IT assets.</span>
                </p>
            </div>
            <div>
                <a href="{{ route('sim-report.monthly') }}" class="btn btn-gradient-info btn-rounded mr-2">Make Monthly Report</a>
                <a href="{{ route('sim-report.index') }}" class="btn btn-secondary mr-2">Issued Reports</a>
                <a href="{{ route('routers.index') }}" class="btn btn-secondary mr-2">Routers</a>
                <a href="{{ route('internet-sims.create') }}" class="btn btn-gradient-primary btn-rounded">Add Internet SIM</a>
                <button type="button" class="btn btn-secondary ml-2" data-toggle="modal" data-target="#importModal">Import Sheet</button>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    @if(session('import_warnings') && count(session('import_warnings')))
                    <div class="alert alert-warning">
                        <strong>Imported, with notes:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach(session('import_warnings') as $warning)
                            <li>{{ $warning }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <section class="hk-sec-wrapper">
                        <form method="GET" action="{{ route('internet-sims.index') }}" class="form-inline mb-20">
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend"><div class="input-group-text">Search</div></div>
                                <input type="text" name="search" class="form-control" placeholder="SIM number, S/N, account, contract, router, site" value="{{ request('search') }}">
                            </div>
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend"><div class="input-group-text">Provider</div></div>
                                <select name="provider" class="form-control">
                                    <option value="">All</option>
                                    @foreach($providers as $p)
                                    <option value="{{ $p }}" {{ request('provider') == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend"><div class="input-group-text">Line</div></div>
                                <select name="line" class="form-control">
                                    <option value="all" {{ request('line', 'all') == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="active" {{ request('line') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('line') == 'inactive' ? 'selected' : '' }}>Not active</option>
                                    <option value="deleted" {{ request('line') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Filter</button>
                            @if(request('search') || request('provider') || (request('line') && request('line') !== 'all'))
                            <a href="{{ route('internet-sims.index') }}" class="btn btn-secondary mb-2 ml-2">Clear</a>
                            @endif
                        </form>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>SIM Number</th>
                                        <th>Provider</th>
                                        <th>Account Name</th>
                                        <th>Account Site</th>
                                        <th class="text-center">Line</th>
                                        <th>SIM S/N</th>
                                        <th>Contract No</th>
                                        <th>Router S/N</th>
                                        <th>Remark</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sims as $sim)
                                    <tr>
                                        <td>{{ $sim->sim_number }}</td>
                                        <td>{{ $sim->sim_provider }}</td>
                                        <td>{{ $sim->account_name ?? '-' }}</td>
                                        <td>{{ $sim->siteLabel() }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $sim->line_active ? 'badge-success' : 'badge-danger' }}">{{ $sim->lineStatusLabel() }}</span>
                                            @if($sim->trashed())
                                                <span class="badge badge-dark">deleted</span>
                                            @endif
                                        </td>
                                        <td>{{ $sim->sim_serial ?? '-' }}</td>
                                        <td>{{ $sim->contract_no ?? '-' }}</td>
                                        <td>
                                            @if($sim->router)
                                                <a href="{{ route('routers.show', $sim->router->id) }}">{{ $sim->router->serial_number ?? $sim->router->name }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $sim->remark ?? '-' }}</td>
                                        <td>
                                            @if($sim->trashed())
                                                <form action="{{ route('internet-sims.restore', $sim->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                                </form>
                                                <form action="{{ route('internet-sims.force-destroy', $sim->id) }}" method="POST" style="display:inline"
                                                      onsubmit="return confirm('Permanently delete this internet SIM? This cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete Forever</button>
                                                </form>
                                            @else
                                                <a href="{{ route('internet-sims.edit', $sim->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('internet-sims.destroy', $sim->id) }}" method="POST" style="display:inline"
                                                      onsubmit="return confirm('Delete this internet SIM? You can restore it from the Deleted filter.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="10" class="text-center">No internet SIMs found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $sims->links() }}
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Bulk load a month's sheet. Re-uploading is safe: lines are matched and
     updated rather than duplicated. --}}
<div class="modal fade" id="importModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="{{ route('internet-sims.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Import Internet SIM Sheet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Excel file (.xlsx)</label>
                        <input type="file" name="sheet" class="form-control" accept=".xlsx,.xls" required>
                        <small class="form-text text-muted">
                            Needs the usual columns: SIM Number, Providor, Acount Name, Account Site,
                            SIM status, SIM S/N, Contract No, Router S/N, Remark.
                        </small>
                    </div>
                    <div class="form-group">
                        <label>Recorded from</label>
                        <input type="month" name="recorded_from" class="form-control" value="{{ now()->format('Y-m') }}">
                        <small class="form-text text-muted">
                            The month these lines should first appear on the report. They carry forward to every month after it.
                        </small>
                    </div>
                    <div class="alert alert-secondary mb-0">
                        <small>
                            Uploading the same sheet again is safe &mdash; a line is matched on its SIM S/N and
                            updated, not duplicated. Nothing is deleted: a line dropped from the sheet stays until
                            you delete it here.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
