{{--
    Shows the signed paper somebody actually uploaded - the PDF or photo
    itself, not the on-screen form it was printed from - with links to open
    it full size or save a copy.

    @include('partials.uploaded-document', [
        'file' => $clearance->clear_image,      // stored filename, may be null
        'dir'  => 'clearance',                  // folder under X-Files/Dash/imgs
        'name' => 'clearance-' . $clearance->clear_code,   // optional download name
        'title' => 'Signed Clearance',          // optional heading
    ])

    A record can name a file that is no longer on disk, so that case is
    reported rather than left as a broken image.
--}}
@php
    $docFile = $file ?? null;
    $docDir = trim($dir ?? '', '/');
    $docPath = $docFile ? public_path('X-Files/Dash/imgs/' . $docDir . '/' . $docFile) : null;
    $docExists = $docFile && is_file($docPath);
    $docUrl = $docExists ? asset('X-Files/Dash/imgs/' . $docDir . '/' . $docFile) : null;
    $docExt = $docFile ? strtolower(pathinfo($docFile, PATHINFO_EXTENSION)) : '';
    $docIsPdf = $docExt === 'pdf';
    // Keep the real extension on the saved copy, whatever we call the file.
    $docDownload = ($name ?? 'document') . ($docExt ? '.' . $docExt : '');
@endphp

<div class="uploaded-document">
    @if(!$docFile)
        <div class="alert alert-secondary mb-0">No signed document has been uploaded yet.</div>
    @elseif(!$docExists)
        <div class="alert alert-warning mb-0">
            This record refers to <strong>{{ $docFile }}</strong>, but that file is missing from the server.
        </div>
    @else
        <div class="d-flex justify-content-between align-items-center mb-10 no-print">
            <h5 class="mb-0">{{ $title ?? 'Uploaded Document' }}</h5>
            <div>
                <a href="{{ $docUrl }}" target="_blank" rel="noopener" class="btn btn-sm btn-info">
                    Open {{ $docIsPdf ? 'PDF' : 'Image' }} in New Tab
                </a>
                {{-- same-origin, so the browser saves it instead of navigating --}}
                <a href="{{ $docUrl }}" download="{{ $docDownload }}" class="btn btn-sm btn-primary">
                    Download
                </a>
            </div>
        </div>

        @if($docIsPdf)
            <iframe src="{{ $docUrl }}" width="100%" height="700" style="border:1px solid #ddd;" title="{{ $title ?? 'Uploaded document' }}"></iframe>
            <p class="mt-2 text-muted no-print">
                <small>If the PDF does not display above, use "Open PDF in New Tab" or Download.</small>
            </p>
        @else
            <img src="{{ $docUrl }}" alt="{{ $title ?? 'Uploaded document' }}" class="img-fluid" style="max-width:100%;">
        @endif
    @endif
</div>
