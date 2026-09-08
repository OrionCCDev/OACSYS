@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">
                    {{ strtoupper($month->format('M Y')) }} has already been reported
                </h2>
                <p>Choose what to do before anything is saved.</p>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <section class="hk-sec-wrapper">
                        <div class="alert alert-warning">
                            <strong>{{ $existingReports->count() }}</strong>
                            report{{ $existingReports->count() == 1 ? '' : 's' }} already
                            exist{{ $existingReports->count() == 1 ? 's' : '' }} for
                            {{ strtoupper($month->format('M Y')) }}.
                            Making another does not replace {{ $existingReports->count() == 1 ? 'it' : 'them' }} &mdash;
                            {{ $existingReports->count() == 1 ? 'it is' : 'they are' }} kept as history.
                        </div>

                        <h5 class="hk-sec-title mb-15">Already issued</h5>
                        <div class="table-responsive mb-20">
                            <table class="table table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Version</th>
                                        <th class="text-center">Lines</th>
                                        <th>Issued</th>
                                        <th>By</th>
                                        <th>Note</th>
                                        <th>Open</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($existingReports as $existing)
                                    <tr>
                                        <td>{{ $existing->versionLabel() ?: 'v1' }}</td>
                                        <td class="text-center">{{ $existing->line_count }}</td>
                                        <td>{{ $existing->created_at->format('d M Y H:i') }}</td>
                                        <td>{{ $existing->creator?->name ?? '-' }}</td>
                                        <td>{{ $existing->notes ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('sim-report.show', $existing->id) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('sim-report.pdf', $existing->id) }}" class="btn btn-sm btn-outline-info">PDF</a>
                                            <a href="{{ route('sim-report.excel', $existing->id) }}" class="btn btn-sm btn-outline-success">Excel</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <h5 class="hk-sec-title mb-15">What next?</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <h6>Pick a different month</h6>
                                    <p class="text-muted"><small>If this was the wrong month, go back and choose another.</small></p>
                                    <form method="GET" action="{{ route('sim-report.monthly') }}" class="form-inline">
                                        <input type="month" name="month" class="form-control mr-2 mb-2"
                                               value="{{ $month->format('Y-m') }}">
                                        <button type="submit" class="btn btn-secondary mb-2">Change Month</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <h6>Make a new report for {{ strtoupper($month->format('M Y')) }}</h6>
                                    <p class="text-muted">
                                        <small>
                                            Carry on to the routers list and tick what belongs on it. The
                                            {{ $existingReports->count() == 1 ? 'existing report' : 'existing reports' }}
                                            above {{ $existingReports->count() == 1 ? 'stays' : 'stay' }} as history, and this
                                            one becomes v{{ $existingReports->max('sequence') + 1 }}.
                                        </small>
                                    </p>
                                    <a href="{{ route('sim-report.monthly', ['month' => $month->format('Y-m'), 'new' => 1]) }}"
                                       class="btn btn-gradient-primary btn-rounded">Continue Anyway</a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-12 col-lg-4">
                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title mb-15">Or leave it</h5>
                        <p class="text-muted"><small>Nothing has been changed. You can simply go elsewhere.</small></p>
                        <a href="{{ route('sim-report.index') }}" class="btn btn-info btn-block mb-2">All Reports</a>
                        <a href="{{ route('routers.index') }}" class="btn btn-secondary btn-block mb-2">Routers</a>
                        <a href="{{ route('internet-sims.index') }}" class="btn btn-secondary btn-block">Internet SIMs</a>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
