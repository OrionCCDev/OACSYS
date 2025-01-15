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

                              {{-- orion mobile number via livewire 3 --}}
                              {{-- ********************************** --}}
                              <livewire:client-employee-form-for-sim-cards />
                              {{-- orion mobile number via livewire 3 --}}
                              {{-- ********************************** --}}

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
                                <label for="exampleDropdownFormpersonalmobileorion">Project</label>
                                <select name="project_id" class="form-control custom-select">
                                  <option @selected(old('project_id') == '')>Select</option>
                                  @foreach ( $projects as $project )
                                  <option @selected(old('project_id') == $project->id) value="{{ $project->id }}">{{
                                    $project->project_name }}</option>
                                  @endforeach
                                </select>
                                @error('project_id')
                                <div class="alert alert-warning" role="alert">
                                  {{ $message }}
                                </div>
                                @enderror
                              </div>
                              <div class="form-group">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput1">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">Upload
                                      Receiving</span>
                                  </div>
                                  <div class="form-control text-truncate" data-trigger="fileinput1"><i
                                      class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                  </div>
                                  <span class="input-group-append">
                                    <span class=" btn btn-primary btn-file"><span class="fileinput-new">Select
                                        Receives</span><span class="fileinput-exists">Change</span>
                                      <input type="file" name="client_receives[]" multiple>
                                    </span>
                                    <a href="#" class="btn btn-secondary fileinput-exists"
                                      data-dismiss="fileinput">Remove</a>
                                  </span>
                                </div>
                                @error('client_receives')
                                <div class="alert alert-warning" role="alert">
                                  {{ $message }}
                                </div>
                                @enderror
                              </div>
                              <div class="form-group">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">Upload
                                      Images</span>
                                  </div>
                                  <div class="form-control text-truncate" data-trigger="fileinput"><i
                                      class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                  </div>
                                  <span class="input-group-append">
                                    <span class=" btn btn-primary btn-file"><span class="fileinput-new">Select
                                        Gallary</span><span class="fileinput-exists">Change</span>
                                      <input type="file" name="client_gallary[]" multiple>
                                    </span>
                                    <a href="#" class="btn btn-secondary fileinput-exists"
                                      data-dismiss="fileinput">Remove</a>
                                  </span>
                                </div>
                                @error('client_gallary')
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
                          <button class="btn btn-success mr-25 " data-toggle="tooltip" data-original-title="Show">
                            <i class="material-icons"></i>
                          </button>
                          <button class="btn btn-info mr-25 " data-toggle="tooltip" data-original-title="Edit">
                            <i class="icon-pencil"></i>
                          </button>
                          <button type="button" class="btn btn-danger"
                          data-toggle="modal"
                          data-target="#exampleModalCenter{{ $clientEmployee->id }}">
                          <i
                          class="icon-trash txt-danger"></i>
                          </button>

                          <div class="modal fade" id="exampleModalCenter{{ $clientEmployee->id }}" tabindex="-1" role="dialog"
                              aria-labelledby="exampleModalCenter{{ $clientEmployee->id }}" aria-hidden="true" style="display: none;">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content  alert alert-warning ">
                                      <div class="modal-header">
                                          <h5 class="modal-title">Deleteing Client Employee</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">×</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                          <p>Are You sure You want to DELETE This  Client Employee </p>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <button type="button" data-dismiss="modal" wire:click='del({{ $clientEmployee->id }})' class="btn btn-danger">Delete</button>
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
