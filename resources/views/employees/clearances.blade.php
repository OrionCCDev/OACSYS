<!-- filepath: /d:/orioncc/Orion-Github/OACSYS/resources/views/employees/Clearances.blade.php -->
@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
    <div class="row">
        <div class="col-12">

            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Employee Clearances</h5>
                <h2>Finished Clearances</h2>
            </section>
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Make New Clearance</h5>
                <a href="{{ route('clearance.index') }}" class="btn btn-gradient-primary btn-wth-icon btn-rounded icon-right">
                    <span class="btn-text">Make New</span>
                    <span class="icon-label">
                        <span class="feather-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle">
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

                            <div class="card">
                                <div class="card-body pa-0">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            @if($employee->clearance->where('status', 'finished')->isEmpty())
                                            <p>No Finished Clearances found for this employee.</p>
                                            @else
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>status</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($employee->clearance->where('status', 'finished') as $clr)
                                                    <tr>
                                                        <td>{{ $clr->clear_code }}</td>
                                                        <td>{{ $clr->status }}</td>
                                                        <td>{{ $clr->created_at }}</td>
                                                        <td><a href="{{ route('employee.clearance.detail', ['id' => $clr->id]) }}"
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
        <div class="col-12">

            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Employee Clearances</h5>
                <h2>Pending Clearances</h2>
            </section>

            <div class="hk-row">
                <div class="col-sm-12">
                    {{-- start of content --}}
                    <div class="table-wrap mb-20">
                        <div class="table-responsive">

                            <div class="card">
                                <div class="card-body pa-0">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            @if($employee->clearance->where('status', 'pending')->isEmpty())
                                            <p>No Pending Clearances found for this employee.</p>
                                            @else
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>status</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($employee->clearance->where('status', 'pending') as $clr)
                                                    <tr>
                                                        <td>{{ $clr->clear_code }}</td>
                                                        <td>{{ $clr->status }}</td>
                                                        <td>{{ $clr->created_at }}</td>
                                                        <td><a href="{{ route('employee.clearance.detail', ['id' => $clr->id]) }}"
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
        @if (!$employee->clearance->where('status', 'pending_resign')->isEmpty() || !$employee->clearance->where('status', 'resigned')->isEmpty())
        <div class="col-12">

            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Employee Resign Clearance</h5>

            </section>

            <div class="hk-row">
                <div class="col-sm-12">
                    {{-- start of content --}}
                    <div class="table-wrap mb-20">
                        <div class="table-responsive">

                            <div class="card">
                                <div class="card-body pa-0">
                                    <div class="table-wrap">
                                        <div class="table-responsive">

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>status</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($employee->clearance->whereIn('status', ['pending_resign', 'resigned']) as $clr)
                                                    <tr>
                                                        <td>{{ $clr->clear_code }}</td>
                                                        <td>{{ $clr->status }}</td>
                                                        <td>{{ $clr->created_at }}</td>
                                                        <td><a href="{{ route('employee.clearance.detail', ['id' => $clr->id]) }}"
                                                                class="btn btn-info">Show</a></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
    </div>
    </div>


@endsection
