<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $device->device_code }}</title>
    <style>
        @page {
            size: 40mm 30mm;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 40mm;
            height: 30mm;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        .qr-wrap svg {
            width: 24mm;
            height: 24mm;
            display: block;
        }

        .code {
            font-family: 'Courier New', monospace;
            font-size: 6pt;
            line-height: 1;
            margin-top: 0.8mm;
            white-space: nowrap;
        }

        .screen-controls {
            display: none;
        }

        @media screen {
            html, body {
                width: auto;
                height: auto;
                min-height: 100vh;
                background: #e9ecef;
            }

            .label {
                width: 40mm;
                height: 30mm;
                background: #fff;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
            }

            .screen-controls {
                display: flex;
                gap: 10px;
                margin-top: 16px;
            }

            .screen-controls button,
            .screen-controls a {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 13px;
                padding: 8px 16px;
                border-radius: 4px;
                border: 1px solid #ccc;
                background: #fff;
                color: #333;
                text-decoration: none;
                cursor: pointer;
            }

            .screen-controls button {
                background: #2563eb;
                border-color: #2563eb;
                color: #fff;
            }
        }

        @media print {
            .screen-controls {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="label">
        <div class="qr-wrap">{!! $qrSvg !!}</div>
        <div class="code">{{ $device->device_code }}</div>
    </div>
    <div class="screen-controls">
        <button type="button" onclick="window.print()">Print Now</button>
        <a href="{{ route('device.qr', $device->id) }}">Back</a>
    </div>
</body>
</html>
