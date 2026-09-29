{{--
    A force close button that stands on its own - for a list row or the top
    of a record page, where there is no upload form to sit in.

    @include('partials.force-close-button', [
        'route' => route('receive.force-close', $receive->id),
        'what'  => 'receive',            // receive | clearance | resignation
        'class' => 'btn btn-danger',     // optional
        'label' => 'Force Close',        // optional
    ])
--}}
@php
    $fcbWhat = $what ?? 'receive';
    $fcbEffect = [
        'receive' => 'The devices and SIM cards on it will be marked as handed over.',
        'clearance' => 'The devices and SIM cards on it will be released.',
        'resignation' => 'The employee will be marked as resigned and their devices and SIM cards released.',
    ][$fcbWhat] ?? '';
@endphp
@if(auth()->user()?->hasRole(['o-admin', 'o-super-admin']))
<form action="{{ $route }}" method="POST" class="d-inline-block no-print" style="margin:0">
    @csrf
    <input type="hidden" name="force_close" value="0">
    <input type="hidden" name="force_close_reason" value="">
    <button type="button" class="{{ $class ?? 'btn btn-danger' }} js-force-close"
            data-what="{{ $fcbWhat }}" data-effect="{{ $fcbEffect }}"
            title="Close without uploading the signed document">
        {{ $label ?? 'Force Close' }}
    </button>
</form>
@include('partials.force-close-script')
@endif
