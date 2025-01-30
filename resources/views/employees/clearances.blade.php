<!-- filepath: /d:/orioncc/Orion-Github/OACSYS/resources/views/employees/clearances.blade.php -->
@extends('layouts.app')

@section('content')
<div>
    <div class="row">
        <div class="col-12">

            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Add New Employee</h5>
                <a href="{{ route('employees.create') }}"
                    class="btn btn-gradient-primary btn-wth-icon btn-rounded icon-right">
                    <span class="btn-text">Add Employee</span>
                    <span class="icon-label">
                        <span class="feather-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-arrow-right-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 16 16 12 12 8"></polyline>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg></span> </span>
                </a>
            </section>

            <div class="hk-row">
                <div class="col-sm-12">
                    {{-- start of content --}}
                    <div class="table-wrap mb-20">
                        <div class="table-responsive">
                            <div class="container">
                                <div class="row">
                                    <div class="container">
                                        <h1>Employee Clearances</h1>

                                        <h2>Received Clearances</h2>
                                        @if($employee->clearance->where('status', 'finished')->isEmpty())
                                        <p>No Finished clearances found for this employee.</p>
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

                                                    @foreach($employee->clearances->where('status', 'received') as $clearance)
                                                    <tr>
                                                        <td>{{ $clearance->id }}</td>
                                                        <td>{{ $clearance->description }}</td>
                                                        <td>{{ $clearance->date }}</td>
                                                        <td><a href="{{ route('employee.clearance.detail', ['id' => $clearance->id]) }}"
                                                                class="btn btn-info">Show</a></td>
                                                    </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                        <h2>Pending Clearances</h2>
                                        @if($employee->clearance->where('status', 'pending')->isEmpty())
                                        <p>No Finished clearances found for this employee.</p>
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
                                                @foreach($employee->clearances->where('status', 'pending') as $clearance)
                                                <tr>
                                                    <td>{{ $clearance->id }}</td>
                                                    <td>{{ $clearance->description }}</td>
                                                    <td>{{ $clearance->date }}</td>
                                                    <td><a href="{{ route('employee.clearance.detail', ['id' => $clearance->id]) }}"
                                                            class="btn btn-info">Show</a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
