<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Data - {{ $employee->name }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { width: 90%; max-width: 800px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
        .header { text-align: center; margin-bottom: 30px; padding-bottom:20px; border-bottom: 1px solid #eee; }
        .profile-image { display: block; margin: 0 auto 20px auto; width: 150px; height: 150px; border-radius: 50%; border: 3px solid #eee; object-fit: cover; }
        h1 { color: #333; margin-bottom: 5px; font-size: 24px; }
        h2 { color: #444; margin-top: 25px; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 8px; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #f0f0f0; vertical-align: top; }
        th { background-color: #f9f9f9; font-weight: bold; width: 35%; color: #555;}
        .badge {
            display: inline-block;
            padding: 0.3em 0.6em;
            font-size: 85%;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .badge-success { color: #fff; background-color: #28a745; }
        .no-data { color: #777; font-style: italic; }
        .footer { text-align: center; margin-top: 30px; padding-top: 15px; border-top: 1px solid #eee; font-size: 0.9em; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($employee->profile_image && file_exists(public_path('X-Files/Dash/imgs/EmployeeProfilePic/' . $employee->profile_image)))
                <img src="{{ public_path('X-Files/Dash/imgs/EmployeeProfilePic/' . $employee->profile_image) }}" alt="{{ $employee->name }}" class="profile-image">
            @else
                <img src="{{ public_path('X-Files/Dash/imgs/EmployeeProfilePic/default_employee.png') }}" alt="Default Profile" class="profile-image">
            @endif
            <h1>{{ $employee->name }}</h1>
            <p>Employee ID: {{ $employee->employee_id }}</p>
        </div>

        <h2>Basic Information</h2>
        <table>
            <tr><th>Department</th><td>{{ $employee->department->name ?? 'N/A' }}</td></tr>
            <tr><th>Position</th><td>{{ $employee->position->name ?? 'N/A' }}</td></tr>
            <tr><th>Hire Date</th><td>{{ $hireDate ?? 'N/A' }}</td></tr>
            @if($diff)
            <tr><th>Service Duration</th><td>{{ $diff->y }} years, {{ $diff->m }} months, {{ $diff->d }} days</td></tr>
            @endif
        </table>

        <h2>Contact Information</h2>
        <table>
            <tr><th>Orion Mobile</th>
                <td>
                    @if ($employee->sim_card->count() > 0)
                        @foreach ($employee->sim_card as $sim)
                            <span class="badge badge-success">{{ $sim->sim_number }}</span>
                        @endforeach
                    @else
                        <span class="no-data">No SIM card assigned</span>
                    @endif
                </td>
            </tr>
            <tr><th>Orion Email</th>
                <td>
                    @if ($employee->orion_email)
                        {{ $employee->orion_email }}
                    @else
                        <span class="no-data">No Orion email assigned</span>
                    @endif
                </td>
            </tr>
            <tr><th>Personal Mobile</th>
                <td>
                    @if ($employee->personal_mobile)
                        {{ $employee->personal_mobile }}
                    @else
                        <span class="no-data">Not provided</span>
                    @endif
                </td>
            </tr>
            <tr><th>Personal Email</th>
                <td>
                    @if ($employee->personal_email)
                        {{ $employee->personal_email }}
                    @else
                        <span class="no-data">Not provided</span>
                    @endif
                </td>
            </tr>
        </table>

        @if ($employee->project)
            <h2>Project Information</h2>
            <table>
                <tr><th>Project Name</th><td>{{ $employee->project->project_name }}</td></tr>
                <tr><th>Project Code</th><td>{{ $employee->project->project_code }}</td></tr>
            </table>
        @endif

        @if ($employee->notes)
            <h2>Notes</h2>
            <p>{{ $employee->notes }}</p>
        @endif

        <div class="footer">
            Generated on: {{ date('F j, Y, g:i a') }}
        </div>
    </div>
</body>
</html>
