@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Deduction Make</h2>

            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    @livewire('employee-deduction', ['employeeId' => $employee->id], key($employee->id))
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
