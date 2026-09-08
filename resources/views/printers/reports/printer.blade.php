@extends('layouts.app')

@section('content')
@include('printers.reports._styles')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">{{ $printer->name }} &mdash; Printer Report</h2>
                <p>
                    The whole life of this machine: every project it has served, every PO, every invoice.
                    <span class="text-muted">Generated {{ now()->format('d M Y H:i') }}</span>
                </p>
            </div>
            <div class="rpt-noprint">
                <a href="{{ route('printers.index') }}" class="btn btn-secondary mr-2">All Printers</a>
                <a href="{{ route('printers.show', $printer->id) }}" class="btn btn-info mr-2">Manage</a>
                <button type="button" class="btn btn-outline-primary" onclick="window.print()">Print</button>
            </div>
        </div>

        @if($chain->count() > 1)
        <div class="alert alert-info rpt-noprint">
            This printer has served {{ $chain->count() }} projects.
            Each move is a separate record with its own PO, so the figures above cover all
            {{ $chain->count() }} engagements together.
        </div>
        @endif

        <div class="hk-pg">
            {{-- Identity is carried across a transfer, so it can be read off any link --}}
            <div class="row">
                <div class="col-12 col-md-4">
                    <section class="hk-sec-wrapper text-center">
                        <img src="{{ asset('X-Files/Dash/imgs/devices/' . $printer->main_image) }}" alt="" class="img-fluid img-thumbnail mb-20">
                        <table class="table table-sm text-left mb-0">
                            <tr><th style="width:45%">Model</th><td>{{ $printer->model ?? '-' }}</td></tr>
                            <tr><th>Serial Number</th><td>{{ $printer->serial_number ?? '-' }}</td></tr>
                            <tr><th>Supplier</th><td>{{ $printer->supplier->name ?? '-' }}</td></tr>
                            <tr><th>Currently</th>
                                <td>
                                    {{ $chain->last()->project->project_name ?? '-' }}
                                    <span class="badge {{ ['active' => 'badge-success', 'transferred' => 'badge-info', 'cancelled' => 'badge-danger'][$chain->last()->status] ?? 'badge-secondary' }} text-capitalize">{{ $chain->last()->status }}</span>
                                </td>
                            </tr>
                        </table>
                    </section>
                </div>

                <div class="col-12 col-md-8">
                    <div class="row">
                        <div class="col-6 col-md-3">
                            <section class="hk-sec-wrapper text-center">
                                <div class="rpt-metric">{{ $chain->count() }}</div>
                                <div class="rpt-metric-label text-muted">Projects</div>
                            </section>
                        </div>
                        <div class="col-6 col-md-3">
                            <section class="hk-sec-wrapper text-center">
                                <div class="rpt-metric">{{ $invoices->count() }}</div>
                                <div class="rpt-metric-label text-muted">Invoices</div>
                            </section>
                        </div>
                        <div class="col-6 col-md-3">
                            <section class="hk-sec-wrapper text-center">
                                <div class="rpt-metric">{{ number_format($overall->windowDays) }}</div>
                                <div class="rpt-metric-label text-muted">Days On Rent</div>
                            </section>
                        </div>
                        <div class="col-6 col-md-3">
                            <section class="hk-sec-wrapper text-center">
                                <div class="rpt-metric">{{ $overall->percentCovered() }}%</div>
                                <div class="rpt-metric-label text-muted">Billed</div>
                            </section>
                        </div>
                    </div>

                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title mb-15">Billing Coverage &mdash; Whole Life</h5>
                        @if($overall->windowStart)
                        <p class="text-muted mb-10">
                            <small>{{ $overall->windowStart->format('d M Y') }} &ndash; {{ $overall->windowEnd->format('d M Y') }}</small>
                        </p>
                        @endif
                        @include('printers.reports._coverage', ['cov' => $overall, 'compact' => false])
                    </section>
                </div>
            </div>

            {{-- The chain itself, oldest project first --}}
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title mb-15">Project History</h5>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Project</th>
                                <th>PO Number</th>
                                <th>Assigned To</th>
                                <th>Period</th>
                                <th class="text-center">Days</th>
                                <th class="text-center">Invoices</th>
                                <th style="min-width:160px">Coverage</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chain as $i => $link)
                            @php $lc = $coverage[$link->id]; @endphp
                            <tr @class(['rpt-row-current' => $link->id === $printer->id])>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <a href="{{ route('printers.reports.project', $link->project_id) }}">{{ $link->project->project_name ?? '-' }}</a>
                                    @if($link->trashed())
                                        <span class="badge badge-dark ml-1">deleted</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $link->po_number }}
                                    @if($link->po_document)
                                        <a href="{{ asset('X-Files/Dash/imgs/printers/po/' . $link->po_document) }}" target="_blank" class="ml-1"><small>(doc)</small></a>
                                    @endif
                                </td>
                                <td>{{ $link->assignedToLabel() }}</td>
                                <td class="rpt-period">{{ $link->rentalPeriodLabel() }}</td>
                                <td class="text-center">{{ number_format($lc->windowDays) }}</td>
                                <td class="text-center">{{ $link->invoices->count() }}</td>
                                <td>@include('printers.reports._coverage', ['cov' => $lc, 'compact' => true])</td>
                                <td>
                                    <span class="badge {{ ['active' => 'badge-success', 'transferred' => 'badge-info', 'cancelled' => 'badge-danger'][$link->status] ?? 'badge-secondary' }} text-capitalize">{{ $link->status }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Every invoice from every engagement, in billing-period order --}}
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title mb-15">All Invoices ({{ $invoices->count() }})</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Number</th>
                                <th>Project</th>
                                <th>PO Number</th>
                                <th>Released</th>
                                <th>Period Covered</th>
                                <th class="text-center">Days</th>
                                <th>Payment Term</th>
                                <th>Document</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $byId = $chain->keyBy('id'); @endphp
                            @forelse($invoices as $invoice)
                            @php $link = $byId->get($invoice->printer_id); @endphp
                            <tr>
                                <td>{{ $invoice->num }}</td>
                                <td>{{ $link->project->project_name ?? '-' }}</td>
                                <td>{{ $link->po_number ?? '-' }}</td>
                                <td class="rpt-period">{{ $invoice->released_date?->format('d M Y') ?? '-' }}</td>
                                <td class="rpt-period">{{ $invoice->start_date->format('d M Y') }} &ndash; {{ $invoice->end_date->format('d M Y') }}</td>
                                <td class="text-center">{{ $invoice->start_date->diffInDays($invoice->end_date) + 1 }}</td>
                                <td>{{ $invoice->payment_term ?? '-' }}</td>
                                <td>
                                    @if($invoice->invoice_document)
                                        <a href="{{ asset('X-Files/Dash/imgs/printers/invoices/' . $invoice->invoice_document) }}" target="_blank">View</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center text-muted">No invoices have been raised against this printer.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
