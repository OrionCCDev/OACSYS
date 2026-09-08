@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">{{ $router->name }}</h2>
                <p>
                    Router
                    <span class="badge {{ ['active' => 'badge-success', 'in-stock' => 'badge-info', 'faulty' => 'badge-warning', 'retired' => 'badge-secondary'][$router->status] ?? 'badge-secondary' }} ml-2">{{ $router->status }}</span>
                </p>
            </div>
            <div>
                <a href="{{ route('routers.index') }}" class="btn btn-secondary mr-2">Back</a>
                @if($router->trashed())
                    <form action="{{ route('routers.restore', $router->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Restore</button>
                    </form>
                @else
                    <a href="{{ route('routers.edit', $router->id) }}" class="btn btn-primary mr-2">Edit</a>
                    <form action="{{ route('routers.destroy', $router->id) }}" method="POST" style="display:inline"
                          onsubmit="return confirm('Delete this router? You can restore it afterwards from the Deleted filter.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endif
            </div>
        </div>

        @if($router->trashed())
        <div class="alert alert-dark">
            <strong>This router is deleted.</strong> It is hidden from the routers list and the SIM report, but nothing has been erased.
        </div>
        @endif

        <div class="hk-pg">
            <div class="row">
                <div class="col-12 col-md-4">
                    <section class="hk-sec-wrapper text-center">
                        <img src="{{ asset('X-Files/Dash/imgs/devices/' . $router->main_image) }}" alt="" class="img-fluid img-thumbnail mb-20">
                        <table class="table table-sm text-left mb-0">
                            <tr><th style="width:45%">Brand</th><td>{{ $router->brand ?? '-' }}</td></tr>
                            <tr><th>Model</th><td>{{ $router->model ?? '-' }}</td></tr>
                            <tr><th>Serial Number</th><td>{{ $router->serial_number ?? '-' }}</td></tr>
                            <tr><th>ISP Provider</th><td>{{ $router->isp_provider ?? '-' }}</td></tr>
                            <tr><th>Account Site</th><td>{{ $router->siteLabel() }}</td></tr>
                            @if($router->notes)
                            <tr><th>Notes</th><td>{{ $router->notes }}</td></tr>
                            @endif
                        </table>
                    </section>
                </div>

                <div class="col-12 col-md-8">
                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title mb-15">SIM Cards Fitted ({{ $router->simCards->count() }})</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>SIM Number</th>
                                        <th>Provider</th>
                                        <th>Account Name</th>
                                        <th>SIM S/N</th>
                                        <th class="text-center">Line</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($router->simCards as $sim)
                                    <tr>
                                        <td>{{ $sim->sim_number ?? '-' }}</td>
                                        <td>{{ $sim->sim_provider ?? '-' }}</td>
                                        <td>{{ $sim->account_name ?? '-' }}</td>
                                        <td>{{ $sim->sim_serial ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $sim->line_active ? 'badge-success' : 'badge-danger' }}">{{ $sim->lineStatusLabel() }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center text-muted">No SIM cards are fitted in this router.</td></tr>
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
@endsection
