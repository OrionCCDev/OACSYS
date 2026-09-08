@extends('layouts.app')

@section('content')
@include('printers.reports._styles')
<style>
    .rpt-monthly th, .rpt-monthly td { vertical-align: middle !important; }
    .rpt-monthly .rpt-supplier-list { margin: 0; padding: 0; list-style: none; }
    .rpt-monthly .rpt-supplier-list li { display: flex; justify-content: space-between; gap: 12px; }
    .rpt-sign { margin-top: 40px; }
    .rpt-sign-line { border-bottom: 1px solid currentColor; height: 46px; }
</style>
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Printers Report &mdash; {{ $month->format('F Y') }}</h2>
                <p>
                    Every printer on rent at any point during the month, by project, supplier and size.
                    <span class="text-muted">A printer transferred mid-month appears under both projects &mdash; both held it.</span>
                </p>
            </div>
            <div class="rpt-noprint">
                <a href="{{ route('printers.index') }}" class="btn btn-secondary mr-2">All Printers</a>
                <a href="{{ route('printers.reports.monthly.pdf', ['month' => $month->format('Y-m')]) }}"
                   class="btn btn-gradient-primary btn-rounded">Export PDF</a>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <form method="GET" action="{{ route('printers.reports.monthly') }}" class="form-inline mb-20 rpt-noprint">
                            <div class="input-group mb-2 mr-2">
                                <div class="input-group-prepend"><div class="input-group-text">Month</div></div>
                                <input type="month" name="month" class="form-control" value="{{ $month->format('Y-m') }}">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Show</button>
                        </form>

                        @php
                            $bigTotal = $printers->where('size', 'big')->count();
                            $smallTotal = $printers->where('size', 'small')->count();
                            $unsetTotal = $printers->whereNull('size')->count();
                        @endphp

                        @if($unsetTotal)
                        <div class="alert alert-warning rpt-noprint">
                            <strong>{{ $unsetTotal }}</strong> printer{{ $unsetTotal == 1 ? '' : 's' }} still {{ $unsetTotal == 1 ? 'has' : 'have' }} no size set,
                            so {{ $unsetTotal == 1 ? 'it appears' : 'they appear' }} on a separate "Not set" line.
                            Set the size on each printer to have them counted as Big or Small.
                        </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered rpt-monthly mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Project Code</th>
                                        <th>Project Name</th>
                                        <th style="min-width:170px">Supplier</th>
                                        <th class="text-center">Sub Total Printers</th>
                                        <th class="text-center">Printer Type</th>
                                        <th class="text-center">Qty</th>
                                        <th>Designation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rows as $row)
                                        @foreach($row['sizes'] as $i => $size)
                                        <tr>
                                            @if($i === 0)
                                                <td rowspan="{{ count($row['sizes']) }}">{{ $row['project']->project_code ?? '-' }}</td>
                                                <td rowspan="{{ count($row['sizes']) }}">{{ $row['project']->project_name ?? '-' }}</td>
                                                <td rowspan="{{ count($row['sizes']) }}">
                                                    <ul class="rpt-supplier-list">
                                                        @foreach($row['suppliers'] as $name => $count)
                                                        <li><span>{{ $name }}</span><strong>{{ $count }}</strong></li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td rowspan="{{ count($row['sizes']) }}" class="text-center"><strong>{{ $row['total'] }}</strong></td>
                                            @endif
                                            <td class="text-center">{{ $size['label'] }}</td>
                                            <td class="text-center">{{ $size['count'] }}</td>
                                            <td>{{ $size['designation'] }}</td>
                                        </tr>
                                        @endforeach
                                    @empty
                                    <tr><td colspan="7" class="text-center">No printers were on rent during {{ $month->format('F Y') }}.</td></tr>
                                    @endforelse
                                </tbody>
                                @if(count($rows))
                                <tfoot>
                                    <tr class="thead-light">
                                        <th colspan="3">{{ count($rows) }} {{ \Illuminate\Support\Str::plural('project', count($rows)) }}</th>
                                        <th class="text-center">{{ $printers->count() }}</th>
                                        <th class="text-center">Big / Small</th>
                                        <th class="text-center">{{ $bigTotal }} / {{ $smallTotal }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
