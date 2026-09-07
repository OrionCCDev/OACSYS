@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Rental Printers Report</h2>
                <p>Every rental printer we track, and where it currently is.</p>
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
                                <input type="text" name="search" class="form-control" placeholder="Name, model, supplier, serial" value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Search</button>
                            @if(request('search'))
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
                                        <th>Current Location</th>
                                        <th>Since</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($printers as $printer)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('X-Files/Dash/imgs/devices/' . $printer->main_image) }}" alt="" width="50" height="50" style="object-fit:cover">
                                        </td>
                                        <td>{{ $printer->device_name }}</td>
                                        <td>{{ $printer->device_model ?? '-' }}</td>
                                        <td>{{ $printer->supplier_name ?? '-' }}</td>
                                        <td>
                                            @if($printer->currentAssignment)
                                                @php $type = $printer->currentAssignment->location_type; @endphp
                                                <span class="badge {{ ['project' => 'badge-info', 'client' => 'badge-purple', 'consultant' => 'badge-Dark', 'office' => 'badge-secondary'][$type] ?? 'badge-secondary' }}">
                                                    {{ $printer->currentAssignment->locationLabel() }}
                                                </span>
                                            @else
                                                <span class="badge badge-warning">Unassigned</span>
                                            @endif
                                        </td>
                                        <td>{{ $printer->currentAssignment?->start_date?->format('Y-m-d') ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('printers.show', $printer->id) }}" class="btn btn-sm btn-info">View / History</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No rental printers found.</td>
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
