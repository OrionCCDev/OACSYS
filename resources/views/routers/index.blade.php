@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Routers</h2>
                <p>Every router we track, where it is, and how many SIM cards are fitted in it.</p>
            </div>
            <div>
                <a href="{{ route('internet-sims.index') }}" class="btn btn-secondary mr-2">Internet SIMs</a>
                <a href="{{ route('sim-report.monthly') }}" class="btn btn-info mr-2">SIM Report</a>
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
                                <input type="text" name="search" class="form-control" placeholder="Name, brand, model, serial, holder" value="{{ request('search') }}">
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
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Serial Number</th>
                                        <th>Supplier</th>
                                        <th>Assigned To</th>
                                        <th class="text-center">SIMs</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($routers as $router)
                                    <tr>
                                        <td>{{ $router->name }}</td>
                                        <td>{{ $router->brand ?? '-' }}</td>
                                        <td>{{ $router->model ?? '-' }}</td>
                                        <td>{{ $router->serial_number ?? '-' }}</td>
                                        <td>{{ $router->supplier?->name ?? '-' }}</td>
                                        <td>
                                            {{ $router->holderLabel() }}
                                            <span class="text-muted"><small>({{ $router->holderType() }})</small></span>
                                        </td>
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
                                    <tr><td colspan="9" class="text-center">No routers found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $routers->links() }}
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
