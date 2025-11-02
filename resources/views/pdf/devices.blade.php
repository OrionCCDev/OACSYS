<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Devices Report</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #2c3e50;
        }
        .header p {
            margin: 3px 0;
            color: #7f8c8d;
            font-size: 9px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 8px;
        }
        th {
            background-color: #34495e;
            color: white;
            padding: 5px 3px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #2c3e50;
            font-size: 8px;
        }
        td {
            padding: 4px 3px;
            border: 1px solid #bdc3c7;
            font-size: 8px;
            word-wrap: break-word;
        }
        tr:nth-child(even) {
            background-color: #ecf0f1;
        }
        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 2px;
            font-size: 7px;
            font-weight: bold;
            white-space: nowrap;
        }
        .badge-success {
            background-color: #27ae60;
            color: white;
        }
        .badge-info {
            background-color: #3498db;
            color: white;
        }
        .badge-warning {
            background-color: #f39c12;
            color: white;
        }
        .badge-danger {
            background-color: #e74c3c;
            color: white;
        }
        .badge-dark {
            background-color: #34495e;
            color: white;
        }
        .badge-purple {
            background-color: #9b59b6;
            color: white;
        }
        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 7px;
            color: #7f8c8d;
            border-top: 1px solid #bdc3c7;
            padding-top: 5px;
        }
        /* Column width optimization for A4 */
        .col-code { width: 8%; }
        .col-name { width: 12%; }
        .col-type { width: 10%; }
        .col-model { width: 10%; }
        .col-serial { width: 11%; }
        .col-health { width: 8%; }
        .col-status { width: 10%; }
        .col-owner { width: 12%; }
        .col-price { width: 9%; }
        .col-supplier { width: 10%; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Devices Report</h1>
        <p>Generated on: {{ $generatedDate }}</p>
        <p>Total Devices: {{ $devices->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-code">Code</th>
                <th class="col-name">Name</th>
                <th class="col-type">Type</th>
                <th class="col-model">Model</th>
                <th class="col-serial">Serial Number</th>
                <th class="col-health">Health</th>
                <th class="col-status">Status</th>
                <th class="col-owner">Owner</th>
                <th class="col-price">Price</th>
                <th class="col-supplier">Supplier</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $device)
            <tr>
                <td class="col-code"><span class="badge badge-purple">{{ $device->device_code }}</span></td>
                <td class="col-name">{{ $device->device_name }}</td>
                <td class="col-type">{{ $device->device_type }}</td>
                <td class="col-model">{{ $device->device_model ?? 'N/A' }}</td>
                <td class="col-serial">{{ $device->serial_number ?? 'N/A' }}</td>
                <td class="col-health">
                    @if($device->health == 'New')
                        <span class="badge badge-success">New</span>
                    @elseif($device->health == 'Mediam_use')
                        <span class="badge badge-info">Med Use</span>
                    @elseif($device->health == 'Bad_use')
                        <span class="badge badge-dark">Bad Use</span>
                    @elseif($device->health == 'Scrap')
                        <span class="badge badge-danger">Scrap</span>
                    @elseif($device->health == 'Need_fix')
                        <span class="badge badge-warning">Fix</span>
                    @else
                        {{ $device->health }}
                    @endif
                </td>
                <td class="col-status">
                    @if($device->status == 'available')
                        <span class="badge badge-success">Available</span>
                    @elseif($device->status == 'taken')
                        <span class="badge badge-info">Taken</span>
                    @elseif($device->status == 'pending-receiving')
                        <span class="badge badge-warning">Pend Recv</span>
                    @elseif($device->status == 'pending-cancel')
                        <span class="badge badge-warning">Pend Clear</span>
                    @elseif($device->status == 'In-Project-Site')
                        <span class="badge badge-info">Project Site</span>
                    @else
                        {{ ucfirst(str_replace('-', ' ', $device->status)) }}
                    @endif
                </td>
                <td class="col-owner">
                    @if($device->employee)
                        {{ $device->employee->name }}
                    @elseif($device->consultant)
                        {{ $device->consultant->name }}
                    @elseif($device->clientEmployee)
                        {{ $device->clientEmployee->name }}
                    @elseif($device->project)
                        {{ $device->project->project_name }}
                    @else
                        -
                    @endif
                </td>
                <td class="col-price">{{ $device->device_price ?? 'N/A' }}</td>
                <td class="col-supplier">{{ $device->supplier_name ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report was automatically generated by the OACSYS Device Management System</p>
        <p>&copy; {{ date('Y') }} ORION AC SYS. All rights reserved.</p>
    </div>
</body>
</html>
