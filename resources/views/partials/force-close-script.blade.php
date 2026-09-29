{{-- The "are you sure" for every force close button. Printed once a page. --}}
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
