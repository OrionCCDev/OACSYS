@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Routers</h2>
                <p>
                    Every internet unit on site, one row per SIM line, in the order of the sheet.
                    A project can have several: with the project manager, in the client office, with the consultant -
                    the <strong>Held by</strong> column says which.
                    <span class="text-muted d-block">
                        {{ $totals['units'] }} units &middot; {{ $totals['active'] }} active &middot; {{ $totals['sites'] }} sites
                    </span>
                </p>
            </div>
            <div>
                <a href="{{ route('internet-sims.index') }}" class="btn btn-secondary mr-2">Internet SIMs</a>
                <a href="{{ route('sim-report.monthly') }}" class="btn btn-gradient-info btn-rounded mr-2">Make Monthly Report</a>
                <a href="{{ route('sim-report.index') }}" class="btn btn-info mr-2">All Reports</a>
                <a href="{{ route('routers.create') }}" class="btn btn-gradient-primary btn-rounded">Add Router</a>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <form method="GET" action="{{ route('routers.index') }}" class="form-inline mb-20">
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend"><div class="input-group-text">Search</div></div>
                                <input type="text" name="search" class="form-control" style="min-width:280px"
                                       placeholder="SIM number, router S/N, site, account, held by" value="{{ request('search') }}">
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
                            <a href="{{ route('routers.index') }}" class="btn btn-secondary mb-2 ml-2">Clear</a>
                            @endif
                        </form>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>SIM Number</th>
                                        <th>Provider</th>
                                        <th>Account Site</th>
                                        <th>Held by</th>
                                        <th>Account Name</th>
                                        <th>Router S/N</th>
                                        <th class="text-center">Line</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($units as $unit)
                                    <tr>
                                        <td class="text-muted">{{ $units->firstItem() + $loop->index }}</td>
                                        <td style="font-family:Consolas,monospace">{{ $unit->sim_number }}</td>
                                        <td>{{ $unit->sim_provider }}</td>
                                        <td>{{ $unit->siteLabel() }}</td>
                                        <td>{{ $unit->remark ?? '-' }}</td>
                                        <td>{{ $unit->account_name ?? '-' }}</td>
                                        <td style="font-family:Consolas,monospace">
                                            @if($unit->router)
                                                <a href="{{ route('routers.show', $unit->router->id) }}">{{ $unit->router->serial_number ?? $unit->router->name }}</a>
                                                @if($unit->router->trashed())
                                                    <span class="badge badge-dark">deleted</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $unit->line_active ? 'badge-success' : 'badge-danger' }}">{{ $unit->lineStatusLabel() }}</span>
                                            @if($unit->trashed())
                                                <span class="badge badge-dark">deleted</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            @if($unit->trashed())
                                                <form action="{{ route('internet-sims.restore', $unit->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                                </form>
                                            @else
                                                @if($unit->router && !$unit->router->trashed())
                                                    <a href="{{ route('routers.show', $unit->router->id) }}" class="btn btn-sm btn-info">View</a>
                                                @endif
                                                <a href="{{ route('internet-sims.edit', $unit->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="9" class="text-center">No units found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $units->links() }}
                    </section>

                    @if($deletedRouters->isNotEmpty())
                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title">Deleted routers ({{ $deletedRouters->count() }})</h5>
                        <p class="mb-20">Router records that were deleted. Restore one to bring it back with its SIM pairing.</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Router</th>
                                        <th>Router S/N</th>
                                        <th>Account Site</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deletedRouters as $router)
                                    <tr>
                                        <td>{{ $router->name }}</td>
                                        <td style="font-family:Consolas,monospace">{{ $router->serial_number ?? '-' }}</td>
                                        <td>{{ $router->siteLabel() }}</td>
                                        <td class="text-nowrap">
                                            <form action="{{ route('routers.restore', $router->id) }}" method="POST" style="display:inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                            </form>
                                            <form action="{{ route('routers.force-destroy', $router->id) }}" method="POST" style="display:inline"
                                                  onsubmit="return confirm('Permanently delete this router? Any SIM fitted in it will be unpaired. This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete Forever</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
