<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Department Management</h2>
                {{-- <p>Questions about onboarding lead data? <a href="#">Learn more.</a></p> --}}
            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div class="row">

                <div class="col-xl-12">
                    <div class="hk-row">
                        <div class="col-sm-12">
                            <section class="hk-sec-wrapper">
                                <h5 class="hk-sec-title">Add New Department</h5>
                                <div class="row">
                                    <div class="col-sm">
                                        <form wire:submit='addNewDepartment' class="form-inline">
                                            <div class="form-row align-items-center">
                                                <div class="col-auto">
                                                    <label class="sr-only" for="AddNewDepartment">Username</label>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">@Department Name</div>
                                                        </div>
                                                        <input type="text" wire:model.lazy='department_name'
                                                            name="department_name" class="form-control"
                                                            id="AddNewDepartment" placeholder="Department Name">

                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-primary mb-2">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                        @error('department_name')
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <h4 class="alert-heading mb-5">Oh Take Care!</h4> {{ $message }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        @enderror
                                        <script>
                                            document.addEventListener('livewire:initialized', () => {
                                                Livewire.on('showToast', () => {
                                                    $.toast({
                                                        heading: 'Well done!',
                                                        text: '<p>You have successfully Add New Department</p>',
                                                        position: 'top-right',
                                                        loaderBg:'#7a5449',
                                                        class: 'jq-toast-primary',
                                                        hideAfter: 3500,
                                                        stack: 6,
                                                        showHideTransition: 'fade'
                                                    });
                                                });
                                                Livewire.on('showToastOfUpdate', () => {
                                                    $.toast({
                                                        heading: 'Well done!',
                                                        text: '<p>You have successfully Update Department</p>',
                                                        position: 'top-left',
                                                        loaderBg:'#7a5449',
                                                        class: 'jq-toast-info',
                                                        hideAfter: 3500,
                                                        stack: 6,
                                                        showHideTransition: 'fade'
                                                    });
                                                });
                                            });
                                        </script>

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
                                                        <input type="text" name="search" wire:model.live='search'
                                                            class="form-control" id="" placeholder="Search">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <table class="table table-info table-bordered table-hover  mb-0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Department Name</th>

                                                <th>Handle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $department )
                                            <tr wire:key="{{ $department->id }}">
                                                <th scope="row">{{ $department->id }}</th>

                                                @if ($edtId == $department->id)
                                                <td>
                                                    <input type="text" wire:model='edtName' value="{{ $edtName }}">
                                                    <button wire:click="update({{ $department->id }})"
                                                        class="btn btn-warning btn-wth-icon btn-rounded icon-right btn-sm"><span
                                                            class="btn-text">Update</span> <span
                                                            class="icon-label"><span class="feather-icon"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-arrow-right-circle">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <polyline points="12 16 16 12 12 8"></polyline>
                                                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                                                </svg></span> </span></button>
                                                    <button wire:click="cancel"
                                                        class="btn btn-danger btn-wth-icon btn-rounded icon-right btn-sm"><span
                                                            class="btn-text">Cancel</span> <span class="icon-label"><i
                                                                class="fa fa-times"></i> </span></button>
                                                    @error('edtName')
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </td>
                                                @else

                                                <td>{{ $department->name }}</td>
                                                @endif


                                                <td>
                                                    <button wire:click='edt({{ $department->id }})'
                                                        class="btn btn-info mr-25 " data-toggle="tooltip"
                                                        data-original-title="Edit">
                                                        <i class="icon-pencil"></i>
                                                    </button>
                                                    {{-- <a href="#" class="" data-toggle="tooltip"
                                                        data-original-title="Delete"> <i
                                                            class="icon-trash txt-danger"></i> </a> --}}


                                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target="#exampleModalCenter{{ $department->id }}">
                                                        <i class="icon-trash txt-danger"></i>
                                                    </button>

                                                    <div class="modal fade" id="exampleModalCenter{{ $department->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalCenter{{ $department->id }}"
                                                        aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content  alert alert-warning ">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Deleteing Department</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Are You sure You want to DELETE This Department
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="button" data-dismiss="modal"
                                                                        wire:click='del({{ $department->id }})'
                                                                        class="btn btn-danger">Delete</button>
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
