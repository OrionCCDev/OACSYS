@extends('layouts.app')

@section('content')
@include('printers.reports._styles')
<style>
    .sim-rpt td, .sim-rpt th { vertical-align: middle !important; font-size: 13px; }
    .sim-rpt .sl { width: 46px; text-align: center; }
    .sim-rpt .mono { font-family: Consolas, monospace; }
    .sim-inactive td { background: rgba(226, 87, 76, .12); }
</style>
<div class="hk-pg-wrapper">
    <div class="container-fluid mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Site Internet SIM Report &mdash; {{ strtoupper($month->format('M Y')) }}</h2>
                <p>
                    Every SIM line recorded by the end of the month, who the account is registered to,
                    where it ended up, and the router it is fitted in.
                </p>
            </div>
            <div class="rpt-noprint">
                <a href="{{ route('simCard.index') }}" class="btn btn-secondary mr-2">SIM Cards</a>
                <a href="{{ route('routers.index') }}" class="btn btn-secondary mr-2">Routers</a>
                <a href="{{ route('sim-report.monthly.pdf', ['month' => $month->format('Y-m')]) }}"
                   class="btn btn-gradient-primary btn-rounded">Export PDF</a>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <form method="GET" action="{{ route('sim-report.monthly') }}" class="form-inline mb-20 rpt-noprint">
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend"><div class="input-group-text">Month</div></div>
                                <input type="month" name="month" class="form-control" value="{{ $month->format('Y-m') }}">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Show</button>
                        </form>

                        @php
                            $activeCount = $sims->where('line_active', true)->count();
                            $withRouter = $sims->whereNotNull('router_id')->count();
                        @endphp
                        <p class="text-muted">
                            <strong>{{ $sims->count() }}</strong> SIM{{ $sims->count() == 1 ? '' : 's' }} &mdash;
                            {{ $activeCount }} active, {{ $sims->count() - $activeCount }} not active,
                            {{ $withRouter }} fitted in a router.
                        </p>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover sim-rpt mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="sl">SL No</th>
                                        <th>SIM Number</th>
                                        <th>Provider</th>
                                        <th>Account Name</th>
                                        <th>Account Site</th>
                                        <th class="text-center">SIM Status</th>
                                        <th>SIM S/N</th>
                                        <th>Contract No</th>
                                        <th>Router S/N</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sims as $i => $sim)
                                    <tr @class(['sim-inactive' => !$sim->line_active])>
                                        <td class="sl">{{ $i + 1 }}</td>
                                        <td class="mono">{{ $sim->sim_number ?? '-' }}</td>
                                        <td>{{ $sim->sim_provider ?? '-' }}</td>
                                        <td>{{ $sim->account_name ?? '-' }}</td>
                                        <td>{{ $sim->holderLabel() }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $sim->line_active ? 'badge-success' : 'badge-danger' }}">
                                                {{ $sim->lineStatusLabel() }}
                                            </span>
                                        </td>
                                        <td class="mono">{{ $sim->sim_serial ?? '-' }}</td>
                                        <td class="mono">{{ $sim->contract_no ?? '-' }}</td>
                                        <td class="mono">
                                            @if($sim->router)
                                                <a href="{{ route('routers.show', $sim->router->id) }}">{{ $sim->router->serial_number ?? $sim->router->name }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $sim->remark ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="10" class="text-center">No SIM cards had been recorded by the end of {{ $month->format('F Y') }}.</td></tr>
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
