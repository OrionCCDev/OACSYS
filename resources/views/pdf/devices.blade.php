<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Devices Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        .header p {
            margin: 5px 0;
            color: #7f8c8d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #34495e;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #2c3e50;
        }
        td {
            padding: 8px;
            border: 1px solid #bdc3c7;
        }
        tr:nth-child(even) {
            background-color: #ecf0f1;
        }
        tr:hover {
            background-color: #d5dbdb;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
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
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #bdc3c7;
            padding-top: 10px;
        }
        .summary {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #ecf0f1;
            border-left: 4px solid #3498db;
        }
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
                <th>#</th>
                <th>Code</th>
                <th>Name</th>
                <th>Type</th>
                <th>Model</th>
                <th>Serial Number</th>
                <th>Health</th>
                <th>Stored At</th>
                <th>Status</th>
                <th>Price</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $index => $device)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><span class="badge badge-purple">{{ $device->device_code }}</span></td>
                <td>{{ $device->device_name }}</td>
                <td>{{ $device->device_type }}</td>
                <td>{{ $device->device_model ?? 'N/A' }}</td>
                <td>{{ $device->serial_number ?? 'N/A' }}</td>
                <td>
                    @if($device->health == 'New')
                        <span class="badge badge-success">New</span>
                    @elseif($device->health == 'Mediam_use')
                        <span class="badge badge-info">Medium Use</span>
                    @elseif($device->health == 'Bad_use')
                        <span class="badge badge-dark">Bad Use</span>
                    @elseif($device->health == 'Scrap')
                        <span class="badge badge-danger">Scrap</span>
                    @elseif($device->health == 'Need_fix')
                        <span class="badge badge-warning">Need Fix</span>
                    @else
                        {{ $device->health }}
                    @endif
                </td>
                <td>{{ ucfirst($device->stored_at) }}</td>
                <td>
                    @if($device->status == 'available')
                        <span class="badge badge-success">Available</span>
                    @elseif($device->status == 'taken')
                        <span class="badge badge-info">Taken</span>
                    @elseif($device->status == 'pending-receiving')
                        <span class="badge badge-warning">Pending Receive</span>
                    @elseif($device->status == 'pending-cancel')
                        <span class="badge badge-warning">Pending Clear</span>
                    @elseif($device->status == 'In-Project-Site')
                        <span class="badge badge-info">In Project Site</span>
                    @else
                        {{ ucfirst(str_replace('-', ' ', $device->status)) }}
                    @endif
                </td>
                <td>{{ $device->device_price ?? 'N/A' }}</td>
                <td>{{ $device->supplier_name ?? 'N/A' }}</td>
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
