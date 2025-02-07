@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
  <!-- Container -->
  <div class="container mt-xl-50 mt-sm-30 mt-15">
    <div class="hk-pg-header align-items-top">
      <div>
        <h2 class="hk-pg-title font-weight-600 mb-10">Clients Management</h2>
        {{-- <p>Questions about onboarding lead data? <a href="#">Learn more.</a></p> --}}
      </div>
    </div>
    <!-- Title -->
    <div class="hk-pg">
      <script>
        @if(Session::has('success'))
            $.toast({
                heading: 'Success',
                text: '{{ Session::get("success") }}',
                position: 'top-right',
                loaderBg:'#fff',
                icon: 'success',
                hideAfter: 3500,
                stack: 6
            });
        @endif
    </script>
      <div class="row">

        <div class="col-xl-12">
          <div class="hk-row">
            <div class="col-sm-12">
              <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Add New Client Employee</h5>
                <div class="row">
                  <div class="col-sm">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalForms">
                      Add New Client Employee
                    </button>
                    <div class="modal fade" id="exampleModalForms" tabindex="-1" role="dialog"
                      aria-labelledby="exampleModalForms" aria-hidden="true" style="display: none;">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Employee Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form enctype="multipart/form-data" method="post"
                              action="{{ route('clientEmployee.store') }}">
                              @csrf
                              <div class="form-group">
                                <label for="exampleDropdownFormname1">Name</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="exampleDropdownFormname1"
                                  placeholder="employee name">
                                @error('name')
                                <div class="alert alert-warning" role="alert">
                                  {{ $message }}
                                </div>
                                @enderror
                              </div>
                              <div class="form-group">
                                <label for="exampleDropdownFormpersonalmobileorion">Client
                                  Company</label>
                                <select name="client_id" class="form-control custom-select">
                                  <option @selected(old('client_id') == '')>Select</option>
                                  @foreach ( $Clients as $client )
                                  <option @selected($client->id == old('client_id')) value="{{ $client->id }}">{{ $client->name
                                    }}</option>
                                  @endforeach
                                </select>
                                @error('client_id')
                                <div class="alert alert-warning" role="alert">
                                  {{ $message }}
                                </div>
                                @enderror
                              </div>
                              <div class="form-group">
                                <label for="exampleDropdownFormEmail1">Email
                                  address</label>
                                <input type="email" old('email') name="email" class="form-control" id="exampleDropdownFormEmail1"
                                  placeholder="email@example.com">
                                @error('email')
                                <div class="alert alert-warning" role="alert">
                                  {{ $message }}
                                </div>
                                @enderror
                              </div>



                              <div class="form-group">
                                <label for="exampleDropdownFormpersonalmobile">personal
                                  mobile</label>
                                <input type="text" value="{{ old('mobile_number') }}" name="mobile_number" class="form-control"
                                  id="exampleDropdownFormpersonalmobile" placeholder="+9712345678">
                                @error('mobile_number')
                                <div class="alert alert-warning" role="alert">
                                  {{ $message }}
                                </div>
                                @enderror
                              </div>
                              <div class="form-group">
                                <label for="exampleDropdownFormposition">Position</label>
                                <input type="text" value="{{ old('position') }}" name="position" class="form-control"
                                  id="exampleDropdownFormposition" placeholder="position">
                                @error('position')
                                <div class="alert alert-warning" role="alert">
                                  {{ $message }}
                                </div>
                                @enderror
                              </div>
                              <div class="form-group">
                                <label for="exampleDropdownFormpersonalmobileorion">Project</label>
                                <select name="project_id" class="form-control custom-select">
                                  <option @selected(old('project_id') == '')>Select</option>
                                  @foreach ( $projects as $project )
                                  <option @selected(old('project_id') == $project->id) value="{{ $project->id }}">{{
                                    $project->project_name }} ( {{ $project->project_code }} )</option>
                                  @endforeach
                                </select>
                                @error('project_id')
                                <div class="alert alert-warning" role="alert">
                                  {{ $message }}
                                </div>
                                @enderror
                              </div>
                              <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
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
                            <input type="text" wire:model.live='search' class="form-control" id="" placeholder="Search">
                          </div>
                        </div>

                      </div>
                    </div>

                  </div>

                  <table class="table table-info table-bordered table-hover  mb-0">
                    <thead class="thead-dark">
                      <tr>
                        <th>client Name</th>
                        <th>client company</th>
                        <th>Project</th>
                        <th>Handle</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $clientEmployee )
                      <tr>
                        <th scope="row">{{ $clientEmployee->name }}</th>
                        <th scope="row">{{ $clientEmployee->client->name }}</th>
                        <th scope="row">{{ $clientEmployee->project->project_name }}</th>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('clientEmployee.show' , $clientEmployee->id) }}" class="btn btn-sm btn-success" title="View Details">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('clientEmployee.edit' , $clientEmployee->id) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button  data-toggle="modal"
                                data-target="#exampleModalCenter{{ $clientEmployee->id }}" type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModalCenter8">
                                <i class="icon-trash"></i>
                                </button>
                                <div class="modal fade" id="exampleModalCenter{{ $clientEmployee->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenter{{ $clientEmployee->id }}" aria-hidden="true" style="display: none;">
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
                                            <div class="modal-footer" style="display: flex; justify-content: space-between;">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <form action="{{ route('clientEmployee.destroy' ,  $clientEmployee->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
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
                  {{ $data->links() }}
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

@endsection
