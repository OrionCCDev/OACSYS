@extends('layouts.app')

@section('content')
@include('printers.reports._styles')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">{{ $project->project_name }} &mdash; Printer Report</h2>
                <p>
                    Every rental printer this project has held, with its PO, assignment and invoices.
                    <span class="text-muted">Generated {{ now()->format('d M Y H:i') }}</span>
                </p>
            </div>
            <div class="rpt-noprint">
                <a href="{{ route('printers.reports.projects') }}" class="btn btn-secondary mr-2">All Projects</a>
                <a href="{{ route('project.details', $project->id) }}" class="btn btn-info mr-2">Project Page</a>
                <button type="button" class="btn btn-outline-primary" onclick="window.print()">Print</button>
            </div>
        </div>

        <div class="hk-pg">
            {{-- Headline numbers for the whole project --}}
            <div class="row">
                <div class="col-6 col-md-3">
                    <section class="hk-sec-wrapper text-center">
                        <div class="rpt-metric">{{ $printers->count() }}</div>
                        <div class="rpt-metric-label text-muted">Printers</div>
                        <small class="text-muted">{{ $printers->where('status', 'active')->count() }} active</small>
                    </section>
                </div>
                <div class="col-6 col-md-3">
                    <section class="hk-sec-wrapper text-center">
                        <div class="rpt-metric">{{ $invoiceCount }}</div>
                        <div class="rpt-metric-label text-muted">Invoices</div>
                        <small class="text-muted">across all printers</small>
                    </section>
                </div>
                <div class="col-6 col-md-3">
                    <section class="hk-sec-wrapper text-center">
                        <div class="rpt-metric">{{ $suppliers->count() }}</div>
                        <div class="rpt-metric-label text-muted">Suppliers</div>
                        <small class="text-muted">{{ $suppliers->isEmpty() ? '—' : $suppliers->join(', ') }}</small>
                    </section>
                </div>
                <div class="col-6 col-md-3">
                    <section class="hk-sec-wrapper text-center">
                        <div class="rpt-metric">{{ $overall?->percentCovered() ?? 0 }}%</div>
                        <div class="rpt-metric-label text-muted">Billed</div>
                        <small class="text-muted">
                            @if($overall && $overall->windowDays)
                                {{ $overall->windowStart->format('M Y') }} &ndash; {{ $overall->windowEnd->format('M Y') }}
                            @else
                                &mdash;
                            @endif
                        </small>
                    </section>
                </div>
            </div>

            {{-- One block per printer, each with its own invoice table --}}
            @forelse($printers as $printer)
            @php $cov = $coverage[$printer->id]; @endphp
            <section class="hk-sec-wrapper rpt-printer">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-15">
                    <div>
                        <h5 class="hk-sec-title mb-1">
                            {{ $printer->name }}
                            <span class="badge {{ ['active' => 'badge-success', 'transferred' => 'badge-info', 'cancelled' => 'badge-danger'][$printer->status] ?? 'badge-secondary' }} text-capitalize ml-1">{{ $printer->status }}</span>
                        </h5>
                        <p class="mb-0 text-muted">
                            PO {{ $printer->po_number }}
                            @if($printer->po_document)
                                <a href="{{ asset('X-Files/Dash/imgs/printers/po/' . $printer->po_document) }}" target="_blank" class="ml-1">(document)</a>
                            @endif
                        </p>
                    </div>
                    <div class="rpt-noprint">
                        <a href="{{ route('printers.reports.printer', $printer->id) }}" class="btn btn-sm btn-outline-info">Printer Report</a>
                        <a href="{{ route('printers.show', $printer->id) }}" class="btn btn-sm btn-secondary">Manage</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <table class="table table-sm table-bordered mb-0">
                            <tr><th style="width:40%">Model</th><td>{{ $printer->model ?? '-' }}</td></tr>
                            <tr><th>Serial Number</th><td>{{ $printer->serial_number ?? '-' }}</td></tr>
                            <tr><th>Supplier</th><td>{{ $printer->supplier?->name ?? '-' }}</td></tr>
                            <tr><th>Assigned To</th><td>{{ $printer->assignedToLabel() }} <span class="text-muted">({{ $printer->delivered_to_type === 'office' ? 'our office' : $printer->delivered_to_type }})</span></td></tr>
                            <tr><th>On Rent</th><td class="rpt-period">{{ $printer->rentalPeriodLabel() }}</td></tr>
                            @if($printer->transferredFrom)
                            <tr><th>Came From</th><td><a href="{{ route('printers.reports.project', $printer->transferredFrom?->project_id) }}">{{ $printer->transferredFrom?->project?->project_name ?? 'a previous project' }}</a></td></tr>
                            @endif
                            @if($printer->transferredTo)
                            <tr><th>Moved To</th><td><a href="{{ route('printers.reports.project', $printer->transferredTo?->project_id) }}">{{ $printer->transferredTo?->project?->project_name ?? 'another project' }}</a></td></tr>
                            @endif
                            @if($printer->notes)
                            <tr><th>Notes</th><td>{{ $printer->notes }}</td></tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-7">
                        <label class="rpt-metric-label text-muted">Billing Coverage</label>
                        @include('printers.reports._coverage', ['cov' => $cov, 'compact' => false])
                    </div>
                </div>

                <h6 class="mt-20 mb-10">Invoices ({{ $printer->invoices->count() }})</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Number</th>
                                <th>Released</th>
                                <th>Period Covered</th>
                                <th class="text-center">Days</th>
                                <th>Payment Term</th>
                                <th>Document</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($printer->invoices->sortBy('start_date') as $invoice)
                            <tr>
                                <td>{{ $invoice->num }}</td>
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
                            <tr><td colspan="6" class="text-center text-muted">No invoices raised against this printer yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
            @empty
            <section class="hk-sec-wrapper">
                <p class="mb-0 text-center">This project has no rental printers.</p>
            </section>
            @endforelse
        </div>
    </div>
</div>
@endsection
