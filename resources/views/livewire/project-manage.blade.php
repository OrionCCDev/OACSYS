<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Project Management</h2>
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
                                <h5 class="hk-sec-title">Add New Project</h5>
                                <div class="row">
                                    <div class="col-sm">
                                        <!-- Improve form validation feedback -->
                                        <form wire:submit.prevent='addNewProject' class="form-inline">
                                            <div class="form-row align-items-center">
                                                <!-- Project Name -->
                                                <div class="col-auto">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">@Project Name</span>
                                                            </div>
                                                            <input type="text"
                                                                   wire:model.defer='project_name'
                                                                   class="form-control @error('project_name') is-invalid @enderror"
                                                                   placeholder="Project Name">
                                                        </div>
                                                        @error('project_name')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-auto">
                                                    <label class="sr-only" for="AddNewProject">Code</label>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">@Project Code</div>
                                                        </div>
                                                        <input type="text" wire:model.lazy='project_code'
                                                            name="project_code" class="form-control"
                                                            id="AddNewProject" placeholder="Project Code">
                                                        </div>
                                                        @error('project_code')
                                                        <div class="alert alert-warning" role="alert">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                </div>
                                                <div class="col-auto">
                                                    <label class="sr-only" for="AddNewProject">Manager</label>
                                                    <div class="input-group mb-2">
                                                        <select wire:model.lazy='project_manager' class="form-control custom-select ">
                                                            <option selected="">Managers</option>
                                                            @foreach ($managers as $manager )
                                                            <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('project_manager')
                                                        <div class="alert alert-warning" role="alert">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-primary mb-2">Save</button>
                                                </div>
                                            </div>
                                        </form>

                                        <script>
                                            document.addEventListener('livewire:initialized', () => {
                                                Livewire.on('showToast', () => {
                                                    $.toast({
                                                        heading: 'Well done!',
                                                        text: '<p>You have successfully Add New Project</p>',
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
                                                        text: '<p>You have successfully Update Project</p>',
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
                                                        <input type="text"
                                                            name="search" wire:model.live='search' class="form-control"
                                                            id="" placeholder="Search">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-info table-bordered table-hover  mb-0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Project Code</th>
                                                <th>Project Name</th>
                                                <th>Project Manager</th>
                                                <th>Handle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $Project )
                                            <tr wire:key="{{ $Project->id }}">
                                                @if ($edtId == $Project->id  && $editProjectCode == true)
                                                <th scope="row">
                                                        <input type="text" wire:model='edtedCode' value="{{ $Project->project_code }}" >
                                                        <button wire:click="updateProjectCode({{ $Project->id }})" class="btn btn-warning btn-wth-icon btn-rounded icon-right btn-sm"><span class="btn-text">Update</span> <span class="icon-label"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg></span> </span></button>
                                                        <button wire:click="cancel" class="btn btn-danger btn-wth-icon btn-rounded icon-right btn-sm"><span class="btn-text">Cancel</span> <span class="icon-label"><i class="fa fa-times"></i> </span></button>
                                                        @error('edtedCode')
                                                        <div class="alert alert-danger" role="alert">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror

                                                </th>
                                                @else
                                                <th scope="row" style="position: relative">

                                                    {{ $Project->project_code }}
                                                    <button style="position:absolute;top:5px;right:5px"
                                                    wire:click='edtProjectCode({{ $Project->id }})' class="btn btn-icon btn-primary  btn-sm"><span class="btn-icon-wrap"><i class="icon-pencil"></i></span></button>
                                                </th>
                                                @endif
                                                @if ($edtId == $Project->id  && $editProjectName == true)
                                                    <td>
                                                        <input type="text" wire:model='edtedName' value="{{ $edtedName }}" >
                                                        <button wire:click="update({{ $Project->id }})" class="btn btn-warning btn-wth-icon btn-rounded icon-right btn-sm"><span class="btn-text">Update</span> <span class="icon-label"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg></span> </span></button>
                                                        <button wire:click="cancel" class="btn btn-danger btn-wth-icon btn-rounded icon-right btn-sm"><span class="btn-text">Cancel</span> <span class="icon-label"><i class="fa fa-times"></i> </span></button>
                                                        @error('edtedName')
                                                        <div class="alert alert-danger" role="alert">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </td>
                                                @else
                                                <td style="position: relative">
                                                    {{ $Project->project_name }}
                                                    <button style="position:absolute;top:5px;right:5px"
                                                    wire:click='edtProjectName({{ $Project->id }})' class="btn btn-icon btn-primary  btn-sm"><span class="btn-icon-wrap"><i class="icon-pencil"></i></span></button>
                                                </td>

                                                @endif
                                                {{--  manager name  --}}
                                                @if ($edtId == $Project->id && $editProjectManger == true)
                                                <td>
                                                    <select wire:model.lazy='project_manager_edited' class="form-control custom-select ">
                                                        <option>Managers</option>
                                                        @foreach ($managers as $manager2 )
                                                        <option value="{{ $manager2->id }}" {{ $manager2->id == $Project->project_manager_id ? 'selected' : '' }} >
                                                            {{ $manager2->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    <button wire:click="updateProjectManager({{ $Project->id }},{{ $manager2->id }})" class="btn btn-warning btn-wth-icon btn-rounded icon-right btn-sm"><span class="btn-text">Update</span> <span class="icon-label"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg></span> </span></button>
                                                    <button wire:click="cancel" class="btn btn-danger btn-wth-icon btn-rounded icon-right btn-sm"><span class="btn-text">Cancel</span> <span class="icon-label"><i class="fa fa-times"></i> </span></button>
                                                    @error('project_manager_edited')
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </td>
                                                @else
                                                <td style="position: relative">
                                                    {{ $Project->manager->name }}
                                                    <button style="position:absolute;top:5px;right:5px"
                                                    wire:click='edtProjectManager({{ $Project->id }})' class="btn btn-icon btn-primary  btn-sm"><span class="btn-icon-wrap"><i class="icon-pencil"></i></span></button>
                                                </td>
                                                @endif


                                                {{--  manager name  --}}


                                                    <td class="text-center">
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('project.details', $Project->id) }}"
                                                               class="btn btn-sm btn-success"
                                                               title="View Details">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <button wire:click="editProject({{ $Project->id }})"
                                                                    class="btn btn-sm btn-info"
                                                                    title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#exampleModalCenter{{ $Project->id }}">
                                                            <i class="icon-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>



                                                    <div class="modal fade" id="exampleModalCenter{{ $Project->id }}" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalCenter{{ $Project->id }}" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content  alert alert-warning ">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Deleteing Project</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Are You sure You want to DELETE This Project <span class="badge badge-soft-danger">{{ $Project->project_name }}</span> with Code <span class="badge badge-soft-danger">{{ $Project->project_code }}</span></p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="button" data-dismiss="modal" wire:click='del({{ $Project->id }})' class="btn btn-danger">Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


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
