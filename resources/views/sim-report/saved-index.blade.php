@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Issued SIM Reports</h2>
                <p>
                    Every monthly report as it was issued.
                    <span class="text-muted">These are frozen copies &mdash; later edits to a line never change them.</span>
                </p>
            </div>
            <div>
                <a href="{{ route('sim-report.monthly') }}" class="btn btn-gradient-primary btn-rounded">Make Monthly Report</a>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Month</th>
                                        <th class="text-center">Lines</th>
                                        <th class="text-center">Active</th>
                                        <th class="text-center">Not Active</th>
                                        <th>Issued</th>
                                        <th>By</th>
                                        <th>Note</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reports as $report)
                                    <tr>
                                        <td>
                                            <strong>{{ $report->monthLabel() }}</strong>
                                            @if($report->sequence > 1)
                                                <span class="badge badge-secondary ml-1">{{ $report->versionLabel() }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $report->line_count }}</td>
                                        <td class="text-center">{{ $report->active_count }}</td>
                                        <td class="text-center">{{ $report->inactive_count }}</td>
                                        <td>{{ $report->created_at->format('d M Y H:i') }}</td>
                                        <td>{{ $report->creator?->name ?? '-' }}</td>
                                        <td>{{ $report->notes ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('sim-report.show', $report->id) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('sim-report.pdf', $report->id) }}" class="btn btn-sm btn-primary">PDF</a>
                                            <form action="{{ route('sim-report.destroy', $report->id) }}" method="POST" style="display:inline"
                                                  onsubmit="return confirm('Delete the {{ $report->monthLabel() }} report? Issued reports are meant to stay as a record. This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            No reports issued yet. Use <a href="{{ route('sim-report.monthly') }}">Make Monthly Report</a> to issue one.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $reports->links() }}
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
