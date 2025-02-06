@extends('layouts.app')


@section('content')
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Consultant Management</h2>
                {{-- <p>Questions about onboarding lead data? <a href="#">Learn more.</a></p> --}}
            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div>
                <div class="row">
                    <div class="col-12">

                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Add New Consultant</h5>
                            <a href="{{ route('consultant.create') }}"
                                class="btn btn-gradient-primary btn-wth-icon btn-rounded icon-right">
                                <span class="btn-text">Add Consultant</span>
                                <span class="icon-label">
                                    <span class="feather-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-arrow-right-circle">
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
                                                        <table class="table table-sm table-hover mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Name</th>
                                                                    <th>Company</th>
                                                                    <th>Project</th>
                                                                    <th>Manage</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($consultants as $consultant)
                                                                <tr>

                                                                    <td>{{ $consultant->id }}</td>
                                                                    <td>{{ $consultant->name }}</td>

                                                                    <td>
                                                                        {{ $consultant->company_name }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $consultant->project?->project_name ?? 'Not
                                                                        Found' }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group" role="group">
                                                                            <a href="{{ route('consultant.show' , $consultant->id) }}"
                                                                                class="btn btn-sm btn-success"
                                                                                title="View Details">
                                                                                <i class="fa fa-eye"></i>
                                                                            </a>
                                                                            <a href="{{ route('consultant.edit' , $consultant->id) }}"
                                                                                class="btn btn-sm btn-info"
                                                                                title="Edit">
                                                                                <i class="fa fa-edit"></i>
                                                                            </a>
                                                                            <button data-toggle="modal"
                                                                                data-target="#exampleModalCenter{{ $consultant->id }}"
                                                                                type="button"
                                                                                class="btn btn-sm btn-danger"
                                                                                data-toggle="modal"
                                                                                data-target="#exampleModalCenter8">
                                                                                <i class="icon-trash"></i>
                                                                            </button>
                                                                            <div class="modal fade"
                                                                                id="exampleModalCenter{{ $consultant->id }}"
                                                                                tabindex="-1" role="dialog"
                                                                                aria-labelledby="exampleModalCenter{{ $consultant->id }}"
                                                                                aria-hidden="true"
                                                                                style="display: none;">
                                                                                <div class="modal-dialog modal-dialog-centered"
                                                                                    role="document">
                                                                                    <div
                                                                                        class="modal-content  alert alert-warning ">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title">
                                                                                                Deleteing Consultant
                                                                                            </h5>
                                                                                            <button type="button"
                                                                                                class="close"
                                                                                                data-dismiss="modal"
                                                                                                aria-label="Close">
                                                                                                <span
                                                                                                    aria-hidden="true">×</span>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <p>Are You sure You want to
                                                                                                DELETE This consultant
                                                                                                <span
                                                                                                    class="badge badge-soft-danger"></span>
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="modal-footer"
                                                                                            style="display: flex; justify-content: space-between;">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-dismiss="modal">Close</button>
                                                                                            <form
                                                                                                action="{{ route('consultant.destroy' , $consultant->id ) }}"
                                                                                                method="post">
                                                                                                @csrf
                                                                                                @method('delete')

                                                                                                <button type="button"
                                                                                                    data-dismiss="modal"
                                                                                                    wire:click='del({{ $consultant->id }})'
                                                                                                    class="btn btn-danger">Delete</button>
                                                                                            </form>
                                                                                        </div>
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
                                                </div>
                                            </div>
                                        </div>
                                        {{ $consultants->links() }}

                                    </div>
                                </div>
                                {{-- end of content --}}

                            </div>
                        </div>
                    </div>




                </div>
            </div>


        </div>
    </div>
</div>
@endsection
