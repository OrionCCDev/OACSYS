{{-- Printed/filed copy of the monthly printers sheet. dompdf only handles
     fairly plain CSS, so this is deliberately its own simple template rather
     than the dashboard view with the theme stripped out. --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Printers Report {{ $month->format('F Y') }}</title>
    <style>
        @page { margin: 20px 24px 60px 24px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #111; }
        .head { width: 100%; margin-bottom: 12px; }
        .head td { vertical-align: middle; border: none; }
        .head img { height: 42px; }
        h1 { font-size: 15px; margin: 0 0 2px 0; }
        .sub { font-size: 9px; color: #555; }
        table.grid { width: 100%; border-collapse: collapse; }
        table.grid th, table.grid td { border: 1px solid #999; padding: 4px 5px; }
        table.grid th { background: #dbe5f1; font-size: 9px; text-transform: uppercase; letter-spacing: .3px; }
        .c { text-align: center; }
        .big { background: #e6efdc; }
        .small { background: #fbe0d0; }
        .unset { background: #eee; }
        .sup { width: 100%; border-collapse: collapse; }
        .sup td { border: none; padding: 0; font-size: 9px; }
        .sup td.n { text-align: right; font-weight: bold; }
        tfoot th { background: #dbe5f1; }
        /* keep a project's rows together across a page break */
        tr { page-break-inside: avoid; }
        .sign { margin-top: 26px; width: 100%; }
        .sign td { border: none; padding-top: 6px; font-size: 10px; vertical-align: bottom; }
        .sign .line { border-bottom: 1px solid #333; height: 34px; }
        .foot { position: fixed; bottom: -34px; left: 0; right: 0; font-size: 8px; color: #666; }
    </style>
</head>
<body>
    <table class="head">
        <tr>
            {{-- The PNG, not the site's .webp: dompdf cannot decode WebP and dies
                 trying to allocate ~78MB for it. Every other PDF here uses this
                 same file for that reason. --}}
            <td><img src="{{ resource_path('images/pdf-logo.png') }}" alt=""></td>
            <td style="text-align:right">
                <h1>Printers Report - {{ $month->format('F Y') }}</h1>
                <div class="sub">
                    Generated {{ now()->format('d M Y') }} |
                    {{ $printers->count() }} printer{{ $printers->count() == 1 ? '' : 's' }} across
                    {{ count($rows) }} project{{ count($rows) == 1 ? '' : 's' }}
                </div>
            </td>
        </tr>
    </table>

    <table class="grid">
        <thead>
            <tr>
                <th>Project Code</th>
                <th>Project Name</th>
                <th>Supplier</th>
                <th class="c">Sub Total<br>Printers</th>
                <th class="c">Printer Type</th>
                <th class="c">Qty</th>
                <th>Designation</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
                @foreach($row['sizes'] as $i => $size)
                <tr>
                    @if($i === 0)
                        <td rowspan="{{ count($row['sizes']) }}">{{ $row['project']->project_code ?? '-' }}</td>
                        <td rowspan="{{ count($row['sizes']) }}">{{ $row['project']->project_name ?? '-' }}</td>
                        <td rowspan="{{ count($row['sizes']) }}">
                            <table class="sup">
                                @foreach($row['suppliers'] as $name => $count)
                                <tr><td>{{ $name }}</td><td class="n">{{ $count }}</td></tr>
                                @endforeach
                            </table>
                        </td>
                        <td rowspan="{{ count($row['sizes']) }}" class="c"><strong>{{ $row['total'] }}</strong></td>
                    @endif
                    <td class="c {{ ['Big' => 'big', 'Small' => 'small'][$size['label']] ?? 'unset' }}">{{ $size['label'] }}</td>
                    <td class="c {{ ['Big' => 'big', 'Small' => 'small'][$size['label']] ?? 'unset' }}">{{ $size['count'] }}</td>
                    <td class="{{ ['Big' => 'big', 'Small' => 'small'][$size['label']] ?? 'unset' }}">{{ $size['designation'] }}</td>
                </tr>
                @endforeach
            @empty
            <tr><td colspan="7" class="c">No printers were on rent during {{ $month->format('F Y') }}.</td></tr>
            @endforelse
        </tbody>
        @if(count($rows))
        <tfoot>
            <tr>
                <th colspan="3">Total</th>
                <th class="c">{{ $printers->count() }}</th>
                <th class="c">Big / Small</th>
                <th class="c">{{ $printers->where('size','big')->count() }} / {{ $printers->where('size','small')->count() }}</th>
                <th></th>
            </tr>
        </tfoot>
        @endif
    </table>

    {{-- Signed off by the IT responsible manager. The name is printed when we
         know it; the line is there to sign either way. --}}
    <table class="sign">
        <tr>
            <td style="width:55%"></td>
            <td style="width:45%">
                <div><strong>IT Responsible Manager</strong></div>
                @if($signatory)
                    <div class="sub">{{ $signatory }}</div>
                @endif
                <div class="line"></div>
                <div class="sub">Signature &amp; Date</div>
            </td>
        </tr>
    </table>

    <div class="foot">
        Orion Contracting Company - Printers Report {{ $month->format('F Y') }}
    </div>
</body>
</html>
