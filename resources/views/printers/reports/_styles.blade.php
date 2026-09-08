{{-- Shared look for the printer reports, plus the print rules that strip the
     app chrome so a report can be handed over on paper. --}}
<style>
    .rpt-bar { height: 8px; border-radius: 4px; background: rgba(255,255,255,.12); overflow: hidden; }
    .rpt-bar > span { display: block; height: 100%; border-radius: 4px; background: #35c46a; }
    .rpt-bar.is-short > span { background: #e8a13a; }
    .rpt-bar.is-bad > span { background: #e2574c; }
    .rpt-metric { font-size: 26px; font-weight: 600; line-height: 1.1; }
    .rpt-metric-label { font-size: 12px; text-transform: uppercase; letter-spacing: .06em; }
    .rpt-printer + .rpt-printer { margin-top: 22px; }
    .rpt-period { white-space: nowrap; }

    /* Marks the engagement you arrived from. Bootstrap's .table-active can't be
       used here: it paints a light background, which on this dark theme leaves
       light text on light and the row unreadable. */
    .rpt-row-current > td {
        background: rgba(127, 231, 255, .10);
        box-shadow: inset 3px 0 0 #4fb8cf;
    }

    @media print {
        .hk-nav-wrapper, .hk-nav, .navbar, .hk-footer, .rpt-noprint, .btn { display: none !important; }
        .hk-pg-wrapper, .hk-wrapper, .container { margin: 0 !important; padding: 0 !important; max-width: 100% !important; }
        .hk-sec-wrapper { box-shadow: none !important; border: 1px solid #ccc !important; page-break-inside: avoid; }
        body, .hk-pg-wrapper { background: #fff !important; color: #000 !important; }
        a { color: #000 !important; text-decoration: none !important; }
        .rpt-printer { page-break-inside: avoid; }
        .rpt-row-current > td { background: #f2f2f2 !important; box-shadow: none !important; }
    }
</style>
