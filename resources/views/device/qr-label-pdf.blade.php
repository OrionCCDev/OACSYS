<!DOCTYPE html>
<html>
<head>
<style>
    @page {
        margin: 0;
    }

    * {
        margin: 0;
        padding: 0;
    }

    html, body {
        width: 40mm;
        height: 30mm;
    }

    table.frame {
        width: 40mm;
        height: 30mm;
        border-collapse: collapse;
    }

    table.frame td {
        width: 40mm;
        height: 30mm;
        text-align: center;
        vertical-align: middle;
    }

    .qr-wrap img {
        width: 24mm;
        height: 24mm;
    }

    .code {
        font-family: 'Mono', monospace;
        font-size: 7pt;
        margin-top: 1mm;
    }
</style>
</head>
<body>
    <table class="frame">
        <tr>
            <td>
                <div class="qr-wrap"><img src="{{ $qrDataUri }}"></div>
                <div class="code">{{ $device->device_code }}</div>
            </td>
        </tr>
    </table>
</body>
</html>
