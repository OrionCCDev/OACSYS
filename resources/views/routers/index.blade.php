@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Routers</h2>
                <p>
                    Every router we track, where it is, and which SIM is fitted in it.
                    SIM lines that are not in any router are listed underneath, so the whole sheet is on this page.
                    <span class="text-muted">
                        {{ $totals['routers'] }} routers &middot; {{ $totals['lines'] }} SIM lines,
                        {{ $totals['unfitted'] }} of them with no router.
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
                                <input type="text" name="search" class="form-control" placeholder="Name, serial, ISP, site, SIM number, owner" value="{{ request('search') }}">
                            </div>
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend"><div class="input-group-text">Status</div></div>
                                <select name="status" class="form-control">
                                    <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="in-stock" {{ request('status') == 'in-stock' ? 'selected' : '' }}>In Stock</option>
                                    <option value="faulty" {{ request('status') == 'faulty' ? 'selected' : '' }}>Faulty</option>
                                    <option value="retired" {{ request('status') == 'retired' ? 'selected' : '' }}>Retired</option>
                                    <option value="deleted" {{ request('status') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Filter</button>
                            @if(request('search') || request('status'))
                            <a href="{{ route('routers.index') }}" class="btn btn-secondary mb-2 ml-2">Clear</a>
                            @endif
                        </form>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Router</th>
                                        <th>SIM Number</th>
                                        <th>ISP Provider</th>
                                        <th>Account Site</th>
                                        <th class="text-center">SIMs</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($routers as $router)
                                    <tr>
                                        <td>
                                            {{ $router->name }}
                                            {{-- imported routers are named by their serial; only repeat it when it differs --}}
                                            @if($router->serial_number && $router->serial_number !== $router->name)
                                                <small class="text-muted d-block">S/N {{ $router->serial_number }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @forelse($router->simCards as $sim)
                                                <div style="font-family:Consolas,monospace">{{ $sim->sim_number }}</div>
                                            @empty
                                                <span class="text-muted">no SIM</span>
                                            @endforelse
                                        </td>
                                        <td>{{ $router->isp_provider ?? '-' }}</td>
                                        <td>{{ $router->siteLabel() }}</td>
                                        <td class="text-center">{{ $router->sim_cards_count }}</td>
                                        <td>
                                            <span class="badge {{ ['active' => 'badge-success', 'in-stock' => 'badge-info', 'faulty' => 'badge-warning', 'retired' => 'badge-secondary'][$router->status] ?? 'badge-secondary' }}">
                                                {{ $router->status }}
                                            </span>
                                            @if($router->trashed())
                                                <span class="badge badge-dark">deleted</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($router->trashed())
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
                                            @else
                                                <a href="{{ route('routers.show', $router->id) }}" class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('routers.edit', $router->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="7" class="text-center">No routers found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $routers->links() }}
                    </section>

                    @if($unfitted->isNotEmpty())
                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title">SIM lines with no router ({{ $unfitted->count() }})</h5>
                        <p class="mb-20">
                            These lines are on the monthly report but are not fitted in a router we track -
                            cameras, phones, spares. To put one in a router, edit it and pick the router.
                        </p>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>SIM Number</th>
                                        <th>ISP Provider</th>
                                        <th>Account Name</th>
                                        <th>Account Site</th>
                                        <th>Remark</th>
                                        <th>Line</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($unfitted as $sim)
                                    <tr>
                                        <td style="font-family:Consolas,monospace">{{ $sim->sim_number }}</td>
                                        <td>{{ $sim->sim_provider }}</td>
                                        <td>{{ $sim->account_name ?? '-' }}</td>
                                        <td>{{ $sim->siteLabel() }}</td>
                                        <td>{{ $sim->remark ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $sim->line_active ? 'badge-success' : 'badge-danger' }}">{{ $sim->lineStatusLabel() }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('internet-sims.edit', $sim->id) }}" class="btn btn-sm btn-primary">Edit</a>
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
