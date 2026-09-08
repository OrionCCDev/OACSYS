@extends('layouts.app')

@section('content')
@include('printers.reports._styles')
<style>
    .sim-rpt td, .sim-rpt th { vertical-align: middle !important; font-size: 13px; }
    .sim-rpt .sl { width: 46px; text-align: center; }
    .sim-rpt .mono { font-family: Consolas, monospace; }
    .sim-inactive td { background: rgba(226, 87, 76, .12); }
    /* a row dropped from this month's sheet */
    .sim-dropped td { opacity: .4; text-decoration: line-through; }
</style>
<div class="hk-pg-wrapper">
    <div class="container-fluid mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Site Internet SIM Report &mdash; {{ strtoupper($month->format('M Y')) }}</h2>
                <p>
                    Check the month over, drop anything that should not be on it, then issue it.
                    <span class="text-muted">Issuing saves a copy that will not change afterwards.</span>
                </p>
            </div>
            <div class="rpt-noprint">
                <a href="{{ route('sim-report.index') }}" class="btn btn-secondary mr-2">Issued Reports</a>
                <a href="{{ route('internet-sims.index') }}" class="btn btn-secondary mr-2">Internet SIMs</a>
                <a href="{{ route('sim-report.monthly.excel', ['month' => $month->format('Y-m')]) }}"
                   class="btn btn-success">Export Excel</a>
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
                            <span class="ml-3 mb-2 text-muted"><small>Defaults to last month.</small></span>
                        </form>

                        {{-- A month that has already been issued must say so, before a
                             second report is made against it by accident. --}}
                        @if($existingReports->isNotEmpty())
                        <div class="alert alert-warning rpt-noprint">
                            <h6 class="mb-2">
                                {{ strtoupper($month->format('M Y')) }} has already been issued
                                @if($existingReports->count() > 1)
                                    ({{ $existingReports->count() }} times)
                                @endif
                            </h6>
                            <ul class="list-unstyled mb-2">
                                @foreach($existingReports as $existing)
                                <li class="mb-1">
                                    <a href="{{ route('sim-report.show', $existing->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('sim-report.pdf', $existing->id) }}" class="btn btn-sm btn-outline-info">PDF</a>
                                    <span class="ml-2">
                                        {{ $existing->line_count }} lines &mdash;
                                        issued {{ $existing->created_at->format('d M Y H:i') }}
                                        @if($existing->creator) by {{ $existing->creator->name }} @endif
                                        {{ $existing->versionLabel() }}
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                            <p class="mb-0">
                                <small>
                                    If the wrong month was picked, change it above. Issuing again is allowed
                                    and keeps the one(s) above as history &mdash; nothing is overwritten.
                                </small>
                            </p>
                        </div>
                        @endif

                        @php
                            $activeCount = $sims->where('line_active', true)->count();
                            $withRouter = $sims->whereNotNull('router_id')->count();
                        @endphp
                        <p class="text-muted rpt-noprint">
                            <small>
                                <strong>Next month:</strong> these lines carry forward on their own &mdash; only change what moved.
                                To edit in Excel instead, use <em>Export Excel</em>, change it, then upload it again
                                from <a href="{{ route('internet-sims.index') }}">Internet SIMs &rarr; Import Sheet</a>.
                            </small>
                        </p>
                        <p class="text-muted">
                            <strong>{{ $sims->count() }}</strong> SIM{{ $sims->count() == 1 ? '' : 's' }} &mdash;
                            {{ $activeCount }} active, {{ $sims->count() - $activeCount }} not active,
                            {{ $withRouter }} fitted in a router.
                        </p>

                        <form method="POST" action="{{ route('sim-report.store') }}" id="issueForm">
                            @csrf
                            <input type="hidden" name="month" value="{{ $month->format('Y-m') }}">

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover sim-rpt mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="sl rpt-noprint">
                                                <input type="checkbox" id="checkAll" checked title="Include all">
                                            </th>
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
                                            <td class="sl rpt-noprint">
                                                <input type="checkbox" class="sim-include" name="sim_ids[]" value="{{ $sim->id }}" checked>
                                            </td>
                                            <td class="sl">{{ $i + 1 }}</td>
                                            <td class="mono">{{ $sim->sim_number ?? '-' }}</td>
                                            <td>{{ $sim->sim_provider ?? '-' }}</td>
                                            <td>{{ $sim->account_name ?? '-' }}</td>
                                            <td>{{ $sim->siteLabel() }}</td>
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
                                        <tr><td colspan="11" class="text-center">No SIM lines had been recorded by the end of {{ $month->format('F Y') }}.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if($sims->isNotEmpty())
                            <div class="mt-20 rpt-noprint">
                                <div class="form-group">
                                    <label>Note on this report (optional)</label>
                                    <input type="text" name="notes" class="form-control" style="max-width:520px"
                                           placeholder="e.g. two lines removed pending replacement">
                                </div>
                                <button type="submit" class="btn btn-gradient-primary btn-rounded">
                                    Issue Monthly Report &mdash; <span id="includedCount">{{ $sims->count() }}</span> line(s)
                                </button>
                                <span class="text-muted ml-2">
                                    <small>Saves a copy of these lines as they are now. You can print or export it afterwards.</small>
                                </span>
                            </div>
                            @endif
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var all = document.getElementById('checkAll');
        var boxes = Array.prototype.slice.call(document.querySelectorAll('.sim-include'));
        var count = document.getElementById('includedCount');

        function refresh() {
            var included = 0;
            boxes.forEach(function (box) {
                var row = box.closest('tr');
                if (box.checked) { included++; row.classList.remove('sim-dropped'); }
                else { row.classList.add('sim-dropped'); }
            });
            if (count) count.textContent = included;
            if (all) all.checked = included === boxes.length;
        }

        boxes.forEach(function (box) { box.addEventListener('change', refresh); });
        if (all) {
            all.addEventListener('change', function () {
                boxes.forEach(function (box) { box.checked = all.checked; });
                refresh();
            });
        }

        // Nothing ticked means nothing to issue - say so rather than posting an
        // empty form and bouncing back with a validation error.
        var form = document.getElementById('issueForm');
        if (form) {
            form.addEventListener('submit', function (e) {
                var included = boxes.filter(function (b) { return b.checked; }).length;
                if (included === 0) {
                    e.preventDefault();
                    alert('Tick at least one line to include in the report.');
                    return;
                }
                var dropped = boxes.length - included;
                if (dropped > 0 && !confirm('Issue this report with ' + included + ' line(s)? ' + dropped + ' line(s) will be left off.')) {
                    e.preventDefault();
                }
            });
        }
    })();
</script>
@endsection
