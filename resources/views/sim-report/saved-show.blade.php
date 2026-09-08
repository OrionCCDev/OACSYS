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
                <h2 class="hk-pg-title font-weight-600 mb-10">
                    Site Internet SIM Report &mdash; {{ $report->monthLabel() }}
                    @if($report->sequence > 1)
                        <span class="badge badge-secondary ml-2">{{ $report->versionLabel() }}</span>
                    @endif
                </h2>
                <p>
                    Issued {{ $report->created_at->format('d M Y H:i') }}@if($report->creator) by {{ $report->creator->name }}@endif.
                    <span class="text-muted">This is the copy as issued &mdash; later changes to a line do not affect it.</span>
                </p>
            </div>
            <div class="rpt-noprint">
                <a href="{{ route('sim-report.index') }}" class="btn btn-secondary mr-2">All Reports</a>
                <button type="button" class="btn btn-outline-primary mr-2" onclick="window.print()">Print</button>
                <a href="{{ route('sim-report.pdf', $report->id) }}" class="btn btn-gradient-primary btn-rounded">Export PDF</a>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <p class="text-muted">
                            <strong>{{ $report->line_count }}</strong> line{{ $report->line_count == 1 ? '' : 's' }} &mdash;
                            {{ $report->active_count }} active, {{ $report->inactive_count }} not active.
                            @if($report->notes)
                                <span class="d-block mt-1">Note: {{ $report->notes }}</span>
                            @endif
                        </p>

                        <div class="table-responsive">
                            <table class="table table-bordered sim-rpt mb-0">
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
                                    @foreach($report->lines as $line)
                                    <tr @class(['sim-inactive' => !$line->line_active])>
                                        <td class="sl">{{ $line->sl_no }}</td>
                                        <td class="mono">{{ $line->sim_number ?? '-' }}</td>
                                        <td>{{ $line->sim_provider ?? '-' }}</td>
                                        <td>{{ $line->account_name ?? '-' }}</td>
                                        <td>{{ $line->account_site ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $line->line_active ? 'badge-success' : 'badge-danger' }}">
                                                {{ $line->lineStatusLabel() }}
                                            </span>
                                        </td>
                                        <td class="mono">{{ $line->sim_serial ?? '-' }}</td>
                                        <td class="mono">{{ $line->contract_no ?? '-' }}</td>
                                        <td class="mono">{{ $line->router_serial ?? '-' }}</td>
                                        <td>{{ $line->remark ?? '-' }}</td>
                                    </tr>
                                    @endforeach
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
