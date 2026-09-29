{{--
    "Close without document" for a receive or clearance upload form.

    Goes INSIDE the upload form, so it posts to the same place with the same
    hidden fields and the record closes exactly as it would with a file.
    Only administrators see it; the server checks that again.

    @include('partials.force-close', ['what' => 'receive'])   // receive | clearance | resignation
--}}
@php
    $fcWhat = $what ?? 'receive';
    $fcAllowed = (bool) auth()->user()?->hasRole(['o-admin', 'o-super-admin']);
    $fcEffect = [
        'receive' => 'The devices and SIM cards on it will be marked as handed over.',
        'clearance' => 'The devices and SIM cards on it will be released.',
        'resignation' => 'The employee will be marked as resigned and their devices and SIM cards released.',
    ][$fcWhat] ?? '';
@endphp
@if($fcAllowed)
<div class="force-close no-print" style="border-top:1px dashed rgba(125,196,255,.35);padding:12px 16px;margin-top:12px">
    <input type="hidden" name="force_close" value="0">
    <input type="hidden" name="force_close_reason" value="">
    <div class="d-flex flex-wrap align-items-center justify-content-between">
        <small class="mr-2 mb-1">No signed paper to upload?</small>
        <button type="button" class="btn btn-sm btn-danger js-force-close mb-1"
                data-what="{{ $fcWhat }}" data-effect="{{ $fcEffect }}">
            Close without document
        </button>
    </div>
</div>

@include('partials.force-close-script')
@endif
