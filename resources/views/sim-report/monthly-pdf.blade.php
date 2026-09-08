{{-- Printed/filed copy of the monthly site-internet SIM sheet. Its own plain
     template because dompdf handles very little CSS. Note the logo is the PNG
     from resources, not the site's .webp: dompdf cannot decode WebP. --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Site Internet SIM Report {{ strtoupper($month->format('M Y')) }}</title>
    <style>
        @page { margin: 18px 20px 55px 20px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 8.5px; color: #111; }
        .head { width: 100%; margin-bottom: 10px; }
        .head td { vertical-align: middle; border: none; }
        .head img { height: 38px; }
        h1 { font-size: 14px; margin: 0 0 2px 0; }
        .sub { font-size: 8px; color: #555; }
        table.grid { width: 100%; border-collapse: collapse; }
        table.grid th, table.grid td { border: 1px solid #999; padding: 3px 4px; }
        table.grid th { background: #dbe5f1; font-size: 7.5px; text-transform: uppercase; }
        .c { text-align: center; }
        .sl { width: 22px; text-align: center; }
        .off { background: #fbdcdc; }
        .ok { color: #1c6b2e; }
        .no { color: #a11; font-weight: bold; }
        tr { page-break-inside: avoid; }
        thead { display: table-header-group; }
        .sign { margin-top: 22px; width: 100%; }
        .sign td { border: none; padding-top: 6px; font-size: 9px; vertical-align: bottom; }
        .sign .line { border-bottom: 1px solid #333; height: 32px; }
        .foot { position: fixed; bottom: -32px; left: 0; right: 0; font-size: 7px; color: #666; }
    </style>
</head>
<body>
    <table class="head">
        <tr>
            <td><img src="{{ resource_path('images/pdf-logo.png') }}" alt=""></td>
            <td style="text-align:right">
                <h1>Site Internet SIM Report - {{ strtoupper($month->format('M Y')) }}{{ $version ? ' (' . $version . ')' : '' }}</h1>
                <div class="sub">
                    Issued {{ $issuedAt->format('d M Y') }} |
                    {{ count($rows) }} SIM{{ count($rows) == 1 ? '' : 's' }} |
                    {{ collect($rows)->where('line_active', true)->count() }} active,
                    {{ collect($rows)->where('line_active', false)->count() }} not active
                </div>
            </td>
        </tr>
    </table>

    <table class="grid">
        <thead>
            <tr>
                <th class="sl">SL</th>
                <th>SIM Number</th>
                <th>Provider</th>
                <th>Account Name</th>
                <th>Account Site</th>
                <th class="c">SIM Status</th>
                <th>SIM S/N</th>
                <th>Contract No</th>
                <th>Router S/N</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
            <tr class="{{ $row['line_active'] ? '' : 'off' }}">
                <td class="sl">{{ $row['sl_no'] }}</td>
                <td>{{ $row['sim_number'] ?: '-' }}</td>
                <td>{{ $row['sim_provider'] ?: '-' }}</td>
                <td>{{ $row['account_name'] ?: '-' }}</td>
                <td>{{ $row['account_site'] ?: '-' }}</td>
                <td class="c {{ $row['line_active'] ? 'ok' : 'no' }}">{{ $row['line_active'] ? 'active' : 'NOT active' }}</td>
                <td>{{ $row['sim_serial'] ?: '-' }}</td>
                <td>{{ $row['contract_no'] ?: '-' }}</td>
                <td>{{ $row['router_serial'] ?: '-' }}</td>
                <td>{{ $row['remark'] ?: '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="10" class="c">This report has no lines.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- Signed off by the IT manager: a title and a line, no name. --}}
    <table class="sign">
        <tr>
            <td style="width:60%"></td>
            <td style="width:40%">
                <div><strong>IT Manager</strong></div>
                <div class="line"></div>
                <div class="sub">Signature &amp; Date</div>
            </td>
        </tr>
    </table>

    <div class="foot">
        Orion Contracting Company - Site Internet SIM Report {{ strtoupper($month->format('M Y')) }}
    </div>
</body>
</html>
