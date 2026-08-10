<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>{{ $pdfTitle ?? 'Document' }}</title>
<style>
    @page {
        margin: 100px 40px 70px 40px;
    }
    * { box-sizing: border-box; }
    body {
        font-family: 'Sans', sans-serif;
        font-size: 10.5px;
        color: #171E27;
        line-height: 1.5;
        margin: 0;
    }
    .mono { font-family: 'Mono', monospace; }

    /* ---- fixed running header / footer ---- */
    #doc-header {
        position: fixed;
        top: -80px;
        left: 0px;
        right: 0px;
        height: 60px;
    }
    #doc-header table { width: 100%; border-collapse: collapse; }
    #doc-header .brand-cell { vertical-align: middle; }
    #doc-header img { height: 34px; }
    #doc-header .brand-name {
        font-size: 12.5px;
        font-weight: 700;
        letter-spacing: 0.03em;
        color: #171E27;
    }
    #doc-header .brand-sub {
        font-size: 8px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #8992A0;
    }
    #doc-header .doctype-cell {
        text-align: right;
        vertical-align: middle;
    }
    #doc-header .doctype {
        font-size: 9px;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #A9611F;
        font-weight: 600;
    }
    #doc-header .doccode {
        font-size: 13px;
        font-weight: 600;
        color: #171E27;
    }
    #doc-header .rule {
        margin-top: 10px;
        border: none;
        border-top: 1.6px solid #171E27;
    }

    #doc-footer {
        position: fixed;
        bottom: -55px;
        left: 0px;
        right: 0px;
        height: 40px;
        border-top: 0.75px solid #D8DEE2;
        padding-top: 6px;
        font-size: 8px;
        color: #8992A0;
    }
    #doc-footer table { width: 100%; }
    #doc-footer .right { text-align: right; }

    /* ---- shared content components ---- */
    h1.doc-title {
        font-size: 17px;
        font-weight: 700;
        margin: 6px 0 2px;
        color: #171E27;
    }
    p.doc-lede {
        font-size: 9.5px;
        color: #5B6672;
        margin: 0 0 16px;
        max-width: 440px;
    }

    table.meta {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 16px;
        border: 0.75px solid #D8DEE2;
    }
    table.meta td {
        padding: 7px 12px;
        border-bottom: 0.75px solid #D8DEE2;
        font-size: 9.5px;
        vertical-align: top;
    }
    table.meta tr:last-child td { border-bottom: none; }
    table.meta td.k {
        width: 26%;
        color: #8992A0;
        font-size: 8px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        font-weight: 600;
    }
    table.meta td.v { font-weight: 500; }
    table.meta td.divider { background: #F3F5F6; font-weight: 700; }

    .section-label {
        font-size: 8.5px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #8992A0;
        font-weight: 700;
        border-bottom: 0.75px solid #171E27;
        padding-bottom: 4px;
        margin: 18px 0 8px;
    }

    table.items {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 6px;
    }
    table.items th {
        text-align: left;
        font-size: 8px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #5B6672;
        background: #F3F5F6;
        padding: 6px 8px;
        border-bottom: 1px solid #C2CAD0;
    }
    table.items td {
        padding: 6px 8px;
        border-bottom: 0.75px solid #E9ECEE;
        font-size: 9.5px;
    }
    table.items tr { page-break-inside: avoid; }

    ul.terms {
        margin: 0;
        padding-left: 14px;
        font-size: 8px;
        color: #5B6672;
        line-height: 1.65;
    }
    ul.terms li { margin-bottom: 2px; }

    table.sigblock {
        width: 100%;
        border-collapse: collapse;
        margin-top: 26px;
        page-break-inside: avoid;
    }
    table.sigblock td {
        width: 33.33%;
        vertical-align: bottom;
        padding: 0 14px;
        text-align: center;
    }
    table.sigblock .line {
        border-top: 0.75px solid #171E27;
        margin-top: 40px;
        padding-top: 5px;
        font-size: 8px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #5B6672;
        font-weight: 600;
    }

    .attest {
        font-size: 10px;
        color: #171E27;
        text-align: center;
        margin: 6px 0 14px;
        line-height: 1.6;
    }
</style>
@stack('pdf-styles')
</head>
<body>

    <div id="doc-header">
        <table>
            <tr>
                <td class="brand-cell" style="width:60%">
                    <table style="width:auto; border-collapse:collapse;">
                        <tr>
                            <td style="padding-right:10px; vertical-align:middle;">
                                <img src="{{ resource_path('images/pdf-logo.png') }}" alt="Orion">
                            </td>
                            <td style="vertical-align:middle;">
                                <div class="brand-name">ORION CONTRACTING COMPANY</div>
                                <div class="brand-sub">IT Asset &amp; Personnel Control</div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="doctype-cell" style="width:40%">
                    <div class="doctype">{{ $documentType ?? 'Document' }}</div>
                    <div class="doccode mono">{{ $documentCode ?? '' }}</div>
                </td>
            </tr>
        </table>
        <hr class="rule">
    </div>

    <div id="doc-footer">
        <table>
            <tr>
                <td class="mono">{{ $documentCode ?? '' }}</td>
                <td class="right">Generated {{ now()->format('Y-m-d H:i') }} &middot; Orion Contracting Company</td>
            </tr>
        </table>
    </div>

    @yield('content')

</body>
</html>
