{{-- Billing coverage for one rental window: how much of the time the printer
     was on rent is actually covered by an invoice, and where it isn't.
     Expects $cov (App\Support\BillingCoverage) and optional $compact. --}}
@php
    $pct = $cov?->percentCovered() ?? 0;
    $state = $pct >= 100 ? '' : ($pct >= 75 ? 'is-short' : 'is-bad');
@endphp

@if(!$cov || $cov->windowDays === 0)
    <span class="text-muted">&mdash;</span>
@else
    <div class="rpt-bar {{ $state }} mb-1"><span style="width: {{ min(100, $pct) }}%"></span></div>
    <small>
        <strong>{{ $pct }}%</strong> billed
        <span class="text-muted">({{ number_format($cov->coveredDays) }} of {{ number_format($cov->windowDays) }} days)</span>
    </small>

    @unless($compact ?? false)
        @if($cov->gaps)
        <div class="mt-2">
            <span class="badge badge-warning">{{ count($cov->gaps) }} uninvoiced {{ \Illuminate\Support\Str::plural('period', count($cov->gaps)) }}</span>
            <ul class="list-unstyled mb-0 mt-1">
                @foreach($cov->gaps as $gap)
                <li><small class="rpt-period">{{ $gap['start']->format('d M Y') }} &ndash; {{ $gap['end']->format('d M Y') }}
                    <span class="text-muted">({{ $gap['start']->diffInDays($gap['end']) + 1 }} days)</span></small></li>
                @endforeach
            </ul>
        </div>
        @endif

        @if($cov->overlaps)
        <div class="mt-2">
            <span class="badge badge-danger">{{ count($cov->overlaps) }} double-billed {{ \Illuminate\Support\Str::plural('period', count($cov->overlaps)) }}</span>
            <ul class="list-unstyled mb-0 mt-1">
                @foreach($cov->overlaps as $ov)
                <li><small class="rpt-period">{{ $ov['start']->format('d M Y') }} &ndash; {{ $ov['end']->format('d M Y') }}</small></li>
                @endforeach
            </ul>
        </div>
        @endif
    @endunless
@endif
