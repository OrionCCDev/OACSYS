@extends('layouts.app')

@section('content')
@include('printers.reports._styles')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Printers by Project</h2>
                <p>Every project holding rental printers, with its POs, invoices and billing coverage. Open one for the full detail.</p>
            </div>
            <div class="rpt-noprint">
                <a href="{{ route('printers.index') }}" class="btn btn-secondary mr-2">All Printers</a>
                <button type="button" class="btn btn-outline-primary" onclick="window.print()">Print</button>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <form method="GET" action="{{ route('printers.reports.projects') }}" class="form-inline mb-20 rpt-noprint">
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend"><div class="input-group-text">Search</div></div>
                                <input type="text" name="search" class="form-control" placeholder="Project name" value="{{ request('search') }}">
                            </div>
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend"><div class="input-group-text">Project Status</div></div>
                                <select name="status" class="form-control">
                                    <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="in-progress" {{ request('status') == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Filter</button>
                            @if(request('search') || request('status'))
                            <a href="{{ route('printers.reports.projects') }}" class="btn btn-secondary mb-2 ml-2">Clear</a>
                            @endif
                        </form>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Project</th>
                                        <th class="text-center">Active</th>
                                        <th class="text-center">Transferred</th>
                                        <th class="text-center">Cancelled</th>
                                        <th class="text-center">Total Printers</th>
                                        <th class="text-center">Invoices</th>
                                        <th style="min-width:190px">Billing Coverage</th>
                                        <th class="rpt-noprint">Report</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($projects as $project)
                                    <tr>
                                        <td>
                                            {{ $project->project_name }}
                                            <span class="badge {{ $project->status === 'completed' ? 'badge-secondary' : 'badge-success' }} ml-1">{{ $project->status }}</span>
                                        </td>
                                        <td class="text-center">{{ $project->active_printers_count }}</td>
                                        <td class="text-center">{{ $project->transferred_printers_count }}</td>
                                        <td class="text-center">{{ $project->cancelled_printers_count }}</td>
                                        <td class="text-center"><strong>{{ $project->printers_count }}</strong></td>
                                        <td class="text-center">{{ $project->invoice_count }}</td>
                                        <td>@include('printers.reports._coverage', ['cov' => $project->coverage, 'compact' => true])</td>
                                        <td class="rpt-noprint">
                                            <a href="{{ route('printers.reports.project', $project->id) }}" class="btn btn-sm btn-info">Open</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="8" class="text-center">No project has any printers yet.</td></tr>
                                    @endforelse
                                </tbody>
                                @if($projects->isNotEmpty())
                                <tfoot>
                                    <tr class="thead-light">
                                        <th>{{ $projects->count() }} {{ \Illuminate\Support\Str::plural('project', $projects->count()) }}</th>
                                        <th class="text-center">{{ $projects->sum('active_printers_count') }}</th>
                                        <th class="text-center">{{ $projects->sum('transferred_printers_count') }}</th>
                                        <th class="text-center">{{ $projects->sum('cancelled_printers_count') }}</th>
                                        <th class="text-center">{{ $projects->sum('printers_count') }}</th>
                                        <th class="text-center">{{ $projects->sum('invoice_count') }}</th>
                                        <th colspan="2"></th>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                        <p class="text-muted mb-0"><small>A printer transferred between two projects is counted once on each &mdash; each engagement is its own PO and its own invoices.</small></p>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
