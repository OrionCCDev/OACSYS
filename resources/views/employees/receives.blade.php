<!-- filepath: /d:/orioncc/Orion-Github/OACSYS/resources/views/employees/receives.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Employee Receives</h1>

    <h2>Received Receives</h2>
    @if($employee->receives->where('status', 'received')->isEmpty())
    <p>No Pending Receives found for this employee.</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employee->receives->where('status', 'received') as $receive)
                <tr>
                    <td>{{ $receive->id }}</td>
                    <td>{{ $receive->description }}</td>
                    <td>{{ $receive->date }}</td>
                    <td><a href="{{ route('employee.receive.detail', ['id' => $receive->id]) }}" class="btn btn-info">Show</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
    <h2>Pending Receives</h2>
    @if($employee->receives->where('status', 'pending')->isEmpty())
    <p>No Pending Receives found for this employee.</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employee->receives->where('status', 'pending') as $receive)
                <tr>
                    <td>{{ $receive->id }}</td>
                    <td>{{ $receive->description }}</td>
                    <td>{{ $receive->date }}</td>
                    <td><a href="{{ route('employee.receive.detail', ['id' => $receive->id]) }}" class="btn btn-info">Show</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
