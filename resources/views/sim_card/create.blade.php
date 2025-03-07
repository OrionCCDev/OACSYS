@extends('layouts.app')

@section('content')

<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">SimCards Management</h2>
                {{-- <p>Questions about onboarding lead data? <a href="#">Learn more.</a></p> --}}

            </div>
        </div>

        <!-- Title -->
        <div class="hk-pg">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hk-row">
                        <div class="col-sm-12">


                            <div class="container mt-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Assign SIM Card to Employee</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('simCard.store') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="sim_card">Select SIM Card</label>
                                                        <select name="sim_card_id" id="sim_card"
                                                            class="form-control select2">
                                                            <option value="">Select a SIM Card</option>
                                                            @foreach($simCards as $sim)
                                                            <option value="{{ $sim->id }}">
                                                                {{ $sim->sim_number }} - {{ $sim->sim_plan }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('sim_card_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="employee">Select Employee</label>
                                                        <select name="employee_id" id="employee"
                                                            class="form-control select2">
                                                            <option value="">Select an Employee</option>
                                                            @foreach($employees as $employee)
                                                            <option value="{{ $employee->id }}">
                                                                {{ $employee->name }} - {{ $employee->employee_id }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('employee_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mt-4">
                                                <button type="submit" class="btn btn-primary">Assign SIM Card</button>
                                            </div>
                                        </form>
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
@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Search...',
            allowClear: true
        });
    });
</script>
@endpush
