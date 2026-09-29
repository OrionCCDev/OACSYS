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

@once
<script>
    document.addEventListener('click', function (event) {
        var button = event.target.closest('.js-force-close');
        if (!button) { return; }
        event.preventDefault();

        var form = button.closest('form');
        var what = button.getAttribute('data-what');
        var title = 'Close this ' + what + ' without a signed document?';
        var text = button.getAttribute('data-effect') + ' It will be recorded as closed by you, with no paper on file.';

        function send(reason) {
            form.querySelector('[name="force_close"]').value = '1';
            form.querySelector('[name="force_close_reason"]').value = reason || '';
            // Skip the browser's "please choose a file" check, and any
            // handler on the form that insists on one.
            form.noValidate = true;
            HTMLFormElement.prototype.submit.call(form);
        }

        if (window.Swal) {
            // An open Bootstrap modal pulls focus back to itself, which
            // makes the reason box below impossible to type in.
            if (window.jQuery) { jQuery(document).off('focusin.bs.modal'); }

            Swal.fire({
                icon: 'warning',
                title: title,
                text: text,
                input: 'text',
                inputPlaceholder: 'Reason (optional)',
                inputAttributes: { maxlength: 500 },
                showCancelButton: true,
                confirmButtonText: 'Yes, close it',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                // the theme colours headings for a dark page; this one is on white
                didOpen: function (popup) {
                    var heading = popup.querySelector('.swal2-title');
                    if (heading) { heading.style.setProperty('color', '#1f2d3d', 'important'); }
                }
            }).then(function (result) {
                if (result.isConfirmed) { send(result.value); }
            });
        } else if (window.confirm(title + '\n\n' + text)) {
            send(window.prompt('Reason (optional)') || '');
        }
    });
</script>
@endonce
@endif
