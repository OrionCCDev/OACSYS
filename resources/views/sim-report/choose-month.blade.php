@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Make Monthly Report</h2>
                <p>Which month is this report for?</p>
            </div>
            <div>
                <a href="{{ route('sim-report.index') }}" class="btn btn-info mr-2">All Reports</a>
                <a href="{{ route('internet-sims.index') }}" class="btn btn-secondary">Internet SIMs</a>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12 col-lg-7">
                    <section class="hk-sec-wrapper">
                        <form method="GET" action="{{ route('sim-report.monthly') }}">
                            <div class="form-group">
                                <label>Report month <span class="text-danger">*</span></label>
                                <input type="month" name="month" class="form-control form-control-lg"
                                       style="max-width:280px" value="{{ $suggested->format('Y-m') }}" required>
                                <small class="form-text text-muted">
                                    Suggested: <strong>{{ $suggested->format('F Y') }}</strong> &mdash; the month just finished.
                                </small>
                            </div>
                            <button type="submit" class="btn btn-gradient-primary btn-rounded">Continue</button>
                        </form>

                        <hr class="mt-30">
                        <p class="text-muted mb-0">
                            <small>
                                Next you will see the routers and SIM lines for that month, where any of them can be
                                left off before the report is saved. If the month has already been reported you will
                                be told first.
                            </small>
                        </p>
                    </section>
                </div>

                <div class="col-12 col-lg-5">
                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title mb-15">Recently issued</h5>
                        @forelse($recent as $report)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>{{ $report->monthLabel() }}</strong>
                                @if($report->sequence > 1)
                                    <span class="badge badge-secondary ml-1">{{ $report->versionLabel() }}</span>
                                @endif
                                <small class="text-muted d-block">
                                    {{ $report->line_count }} lines &mdash; {{ $report->created_at->format('d M Y') }}
                                </small>
                            </div>
                            <a href="{{ route('sim-report.show', $report->id) }}" class="btn btn-sm btn-info">View</a>
                        </div>
                        @empty
                        <p class="text-muted mb-0">No reports issued yet.</p>
                        @endforelse
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
