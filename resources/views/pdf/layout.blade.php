<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>{{ $pdfTitle ?? 'Document' }}</title>
<style>
    @page {
        margin: 108px 40px 70px 40px;
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

    /* ---- accent color schemes (one per document type) ---- */
    .scheme-sapphire { --accent: #2F4CDB; --accent-dark: #1E36B0; --accent-tint: #EAF0FF; --accent-tint-strong: #D7E2FF; }
    .scheme-emerald  { --accent: #0E9F6E; --accent-dark: #0B7A55; --accent-tint: #E7F8F1; --accent-tint-strong: #CFF1E2; }
    .scheme-ruby     { --accent: #D6483D; --accent-dark: #AD332A; --accent-tint: #FCEBE9; --accent-tint-strong: #F8D4D1; }

    /* ---- top band + fixed running header / footer ---- */
    #doc-topband {
        position: fixed;
        top: -108px;
        left: 0px;
        right: 0px;
        height: 6px;
        background: var(--accent);
    }
    #doc-header {
        position: fixed;
        top: -88px;
        left: 0px;
        right: 0px;
        height: 68px;
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
    .doctype-badge {
        display: inline-block;
        font-size: 8.5px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--accent-dark);
        background: var(--accent-tint);
        border: 0.75px solid var(--accent-tint-strong);
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
    }
    #doc-header .doccode {
        font-size: 13px;
        font-weight: 600;
        color: #171E27;
        margin-top: 5px;
    }
    #doc-header .rule {
        margin-top: 10px;
        border: none;
        border-top: 1.6px solid var(--accent);
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
    #doc-footer .mono { color: var(--accent-dark); }

    /* ---- shared content components ---- */
    h1.doc-title {
        font-size: 19px;
        font-weight: 700;
        margin: 6px 0 2px;
        color: #171E27;
        border-left: 4px solid var(--accent);
        padding-left: 10px;
    }
    p.doc-lede {
        font-size: 9.5px;
        color: #5B6672;
        margin: 4px 0 16px 14px;
        max-width: 440px;
    }

    table.meta {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 16px;
        border: 0.75px solid #D8DEE2;
        border-left: 3px solid var(--accent);
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
    table.meta td.divider { background: var(--accent-tint); font-weight: 700; color: var(--accent-dark); }

    .section-label {
        font-size: 8.5px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--accent-dark);
        font-weight: 700;
        border-bottom: 1.5px solid var(--accent);
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
        color: var(--accent-dark);
        background: var(--accent-tint);
        padding: 6px 8px;
        border-bottom: 1px solid var(--accent-tint-strong);
    }
    table.items td {
        padding: 6px 8px;
        border-bottom: 0.75px solid #E9ECEE;
        font-size: 9.5px;
    }
    table.items tbody tr:nth-child(even) td { background: #FAFBFC; }
    table.items tr { page-break-inside: avoid; }

    .terms-box {
        background: #FAFBFC;
        border: 0.75px solid #E9ECEE;
        border-left: 3px solid var(--accent);
        border-radius: 4px;
        padding: 10px 14px;
    }
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
        border-top: 1.5px solid var(--accent);
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
<body class="scheme-{{ $colorScheme ?? 'sapphire' }}">

    <div id="doc-topband"></div>

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
                    <span class="doctype-badge">{{ $documentType ?? 'Document' }}</span>
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
