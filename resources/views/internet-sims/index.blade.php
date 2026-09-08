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
                <a href="{{ route('sim-report.monthly') }}" class="btn btn-info mr-2">Monthly Report</a>
                <a href="{{ route('routers.index') }}" class="btn btn-secondary mr-2">Routers</a>
                <a href="{{ route('internet-sims.create') }}" class="btn btn-gradient-primary btn-rounded">Add Internet SIM</a>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
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
                            @if(request('search') || request('provider') || request('line'))
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
                                        <td>
                                            {{ $sim->holderLabel() }}
                                            <span class="text-muted"><small>({{ $sim->holderType() }})</small></span>
                                        </td>
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
@endsection
