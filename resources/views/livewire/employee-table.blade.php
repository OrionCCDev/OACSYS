<div>
    <div class="row">
        <div class="col-12">

            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Add New Employee</h5>
                <a href="{{ route('employees.create') }}" class="btn btn-gradient-primary btn-wth-icon btn-rounded icon-right">
                    <span class="btn-text">Add Employee</span>
                    <span class="icon-label">
                        <span class="feather-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg></span> </span>
                </a>
            </section>

            <div class="hk-row">
                <div class="col-sm-12">
                    {{-- start of content --}}
                    <div class="table-wrap mb-20">
                        <div class="table-responsive">
                            <div class="container">
                                <div class="row">
                                    <div class="form-row align-items-center">
                                        <div class="col-auto">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">@Search</div>
                                                </div>
                                                <input type="text" wire:model.live="search" class="form-control" placeholder="Search employees...">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body pa-0">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Img</th>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>O-Mobile</th>
                                                        <th>Department</th>
                                                        <th>Position</th>
                                                        <th>Manage</th>

                                                        @if (Auth::user()->hasRole('o-admin') || Auth::user()->hasRole('o-super-admin'))

                                                        <th>Rcv & Clr</th>
                                                        <th>Resign</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($employees as $employee)
                                                    <tr>
                                                        <td><img class="img-fluid rounded"
                                                                src="{{ asset('X-Files/Dash/imgs/EmployeeProfilePic/' . $employee->profile_image) }}" width="50" height="50" alt="icon"></td>
                                                        <td>{{ $employee->employee_id }}</td>
                                                        <td>{{ $employee->name }}</td>
                                                        <td>
                                                            @foreach ($employee->sim_card as $sim)
                                                            <span class="badge badge-success">{{ $sim->sim_number }}</span>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            {{ $employee->department->name }}
                                                        </td>
                                                        <td>
                                                            {{ $employee->position->name }}
                                                        </td>
                                                            <td class="text-center">
                                                                <div class="btn-group" role="group">
                                                                    <a href="{{ route('employees.show' , $employee->id) }}" class="btn btn-sm btn-success" title="View Details">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('employees.edit' , $employee->id) }}" class="btn btn-sm btn-info" title="Edit">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    <button  data-toggle="modal"
                                                                    data-target="#exampleModalCenter{{ $employee->id }}" type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModalCenter8">
                                                                    <i class="icon-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        @if (Auth::user()->hasRole('o-admin') || Auth::user()->hasRole('o-super-admin'))

                                                            <td class="text-center">
                                                                <div class="btn-group btn-group-rounded mr-25" role="group" aria-label="First group">
                                                                    <a href="{{ route('employee.receives' , ['id' => $employee->id ]) }}" class="btn btn-outline-info"><i class="icon-layers"></i></button>
                                                                    <a href="{{ route('employee.clearances' , ['id' => $employee->id ]) }}" class="btn btn-outline-danger"><i class="icon-login"></i></button>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="{{ route('employee.preResign' , ['id' => $employee->id]) }}" class="btn btn-icon btn-icon-circle btn-gradient-danger btn-icon-style-2"><span class="btn-icon-wrap"><i class="icon-rocket"></i></span></a>
                                                            </td>
                                                            <div class="modal fade" id="exampleModalCenter{{ $employee->id }}" tabindex="-1" role="dialog"
                                                                aria-labelledby="exampleModalCenter{{ $employee->id }}" aria-hidden="true" style="display: none;">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content  alert alert-warning ">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Deleteing Employee</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">×</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Are You sure You want to DELETE This  Client Employee <span class="badge badge-soft-danger"></span> with Code <span class="badge badge-soft-danger"></span></p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            <button type="button" data-dismiss="modal" wire:click='del({{ $employee->id }})' class="btn btn-danger">Delete</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </tr>

                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ $employees->links() }}
                        </div>
                    </div>
                    {{-- end of content --}}

                </div>
            </div>
        </div>




    </div>
</div>
