

{{-- @livewire('employee-deduction', ['employeeId' => $employee->id], key($employee->id)) --}}
@extends('layouts.app')

@section('custom_css')
<style>
    .customize-thumbnails-gallery {
    display: flex;
    justify-content: space-between;
    }
    .customize-thumbnails-gallery a img{
    width: 250px;
    height: 250px;
    }
</style>
@endsection
@section('content')
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Deduction Information</h2>
                <a href="{{ route('deductions.createNewDeduct' , ['id' => $employee->id ]) }}"
                class="btn btn-sm btn-outline-primary btn-rounded btn-wth-icon icon-wthot-bg mb-15"><span
                    class="icon-label"><span class="feather-icon"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg></span> </span><span class="btn-text">Make Deduction</span></a>
            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <h2 class="my-3 text-center" style="font-size: 65px;font-weight: 800">{{ $employee->name }}</h2>
                    <div class="row">
                        <div class="col-12">

                            @if ($employee->deductions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Amount</th>
                                            <th>Reason</th>
                                            <th>Date</th>
                                            <th>Manage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employee->deductions as $deduction)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $deduction->amount }} AED</td>
                                            <td>{{ $deduction->reason }}</td>
                                            <td>{{ $deduction->created_at->format('d M, Y') }}</td>
                                            <td>

                                                <a href="{{ route('deductions.showDeductionReport' , $deduction->id ) }}" class="btn btn-info mr-25 " data-toggle="tooltip" data-original-title="Edit">
                                                    <i class="icon-eye"></i>
                                                </a>



                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter1{{ $loop->iteration }}">
                                                    <i class="icon-trash txt-danger"></i>
                                                </button>

                                                <div class="modal fade" id="exampleModalCenter1{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content alert alert-warning">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Delete Deduction</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this deduction?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <form action="{{ route('deductions.destroy', $deduction->id) }}" method="POST" style="display: inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <div class="alert alert-warning" role="alert">
                                    No deductions found for this employee.
                                </div>
                            @endif
                        </div>

                    </div>

                    <div class="row mt-30">
                        <div class="col-auto">
                            <a href="{{ url()->previous() }}" class="btn btn-danger btn-lg mb-2">Back</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
