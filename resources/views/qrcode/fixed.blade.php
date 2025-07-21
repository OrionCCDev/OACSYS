<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed QR Code</title>
</head>
<body>
    <h1>Scan this QR Code</h1>

    @if(file_exists(public_path('images/fixed-qr.png')))
        <img src="{{ asset('images/fixed-qr.png') }}" alt="QR Code" style="max-width: 300px;">
        <p>When scanned, you will be redirected to the target route.</p>
    @else
        <p>QR code not found. Please generate it first.</p>
        <a href="{{ route('generate.qr') }}">Generate QR Code</a>
    @endif
</body>
</html>
