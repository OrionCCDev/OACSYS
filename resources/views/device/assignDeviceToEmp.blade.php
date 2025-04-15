@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Device Management</h2>
            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title">Assign Device To Employee</h5>
                        <div class="row">
                            <div class="col-sm">
                                <div class="card-body">
                                    <form action="{{ route('device.storeAssignDeviceToEmp') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="device_id">Select Device </label>
                                                    <select name="device_id" id="device_id"
                                                        class="form-control select2">
                                                        <option value="">Select Device</option>
                                                        @foreach($devices as $device)
                                                        <option value="{{ $device->id }}">
                                                            {{ $device->device_code }} - {{ $device->device_name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('device_id')
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
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
