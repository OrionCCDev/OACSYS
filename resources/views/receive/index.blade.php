@extends('layouts.app')


@section('content')
{{-- @dd($devicesData , $receiver , $receiver_type) --}}
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">All Receives</h2>
                <h2>Make Receiving
                    <a href="{{ route('receive.create') }}"
                        class="btn btn-secondary btn-wth-icon btn-rounded icon-right"><span
                            class="btn-text">Create</span> <span class="icon-label"><span class="feather-icon"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-arrow-right-circle">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 16 16 12 12 8"></polyline>
                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                </svg></span> </span>
                    </a>
                </h2>
            </div>
        </div>
        <!-- Title -->
        <div class="container">
            <section class="hk-sec-wrapper">
                <div class="table-responsive mt-4">
                    <h5 class="hk-sec-title">Receives</h5>
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $recv)
                            <tr>
                                <td>{{ $recv->code }}</td>
                                <td>
                                    @if ($recv->employee_id)
                                    {{ $recv->employee->name }}
                                    @elseif($recv->consultant_id)
                                    {{ $recv->consultant->name }}
                                    @elseif($recv->client_employee_id)
                                    {{ $recv->clientEmployee->name }}
                                    @endif
                                </td>
                                <td>{{ $recv->status }}</td>
                                <td>
                                    <a href="{{ route('receive.show' , ['receive' => $recv->id]) }}"
                                        class="btn btn-success btn-wth-icon icon-wthot-bg btn-rounded icon-right"><span
                                            class="btn-text">Show</span><span class="icon-label"><i
                                                class="fa fa-angle-right"></i> </span></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links('pagination::bootstrap-5') }}
                </div>
            </section>
            <!-- /Title -->

            <!-- Row -->

            <!-- /Row -->
        </div>
    </div>
</div>

@endsection
