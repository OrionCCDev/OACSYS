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
                            {{-- <form action="{{ route('simcards.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="file" name="excel_file" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Import Excel</button>
                            </form>
                             --}}
                            <section class="hk-sec-wrapper">
                                <h5 class="hk-sec-title">Add New SimCard Number</h5>
                                <div class="row">
                                    <div class="col-sm">
                                        <form wire:submit='addNewSimCard' class="form-inline">
                                            <div class="form-row align-items-center">
                                                <div class="col-auto">
                                                    <label class="sr-only" for="AddNewSimCard">Number</label>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">@SimCard</div>
                                                        </div>
                                                        <input type="text" wire:model.lazy='SimCard_number'
                                                            name="SimCard_number" class="form-control"
                                                            id="AddNewSimCard" placeholder="SimCard Number">
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Provider</div>
                                                        </div>
                                                        <select wire:model.lazy='sim_provider' class="form-control">
                                                            <option value="">Select Provider</option>
                                                            <option value="DU">DU</option>
                                                            <option value="Etisalat">E&</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-auto">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Plan</div>
                                                        </div>
                                                        <input type="text" wire:model.lazy='sim_plan'
                                                            class="form-control" placeholder="Data Plan">
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-primary mb-2">Add</button>
                                                </div>
                                            </div>
                                        </form>
                                        @error('SimCard_number')
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
                                                        text: '<p>You have successfully Add New SimCard</p>',
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
                                                        text: '<p>You have successfully Update SimCard</p>',
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
                                                <th>SimCard Number</th>
                                                <th>Plan</th>
                                                <th>Provider</th>
                                                <th>Owner</th>
                                                <th>Handle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $sim )
                                            <tr wire:key="{{ $sim->id }}">
                                                @if ($edtId == $sim->id)
                                                <td>
                                                    <input type="text" wire:model='edtNumber' value="{{ $edtNumber }}" >
                                                    <!-- existing buttons -->
                                                </td>
                                                <td>
                                                    <select wire:model='edtProvider' class="form-control">
                                                        <option value="">Select Provider</option>
                                                        <option value="DU">DU</option>
                                                        <option value="Etisalat">E&</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" wire:model='edtPlan' value="{{ $edtPlan }}" >
                                                    <!-- existing update/cancel buttons -->
                                                </td>
                                            @else
                                                <td>{{ $sim->sim_number }}</td>
                                                <td>{{ $sim->sim_provider }}</td>
                                                <td>{{ $sim->sim_plan }}</td>
                                            @endif
                                                <td>
                                                    @if($sim->employee)
                                                    <span class="badge badge-indigo">{{ $sim->employee->name }}</span>
                                                    @elseif($sim->clientEmployee)
                                                    <span class="badge badge-purple">{{ $sim->clientEmployee->name }}</span>
                                                    @elseif($sim->consultant)
                                                    <span class="badge badge-Dark">{{ $sim->consultant->name }}</span>
                                                    @else
                                                        <span class="badge badge-success">Available</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($edtId == $sim->id)
                                                    <button wire:click="update({{ $sim->id }})" class="btn btn-success mr-25" data-toggle="tooltip" data-original-title="Save">
                                                        <i class="icon-check"></i> Save
                                                    </button>
                                                    <button wire:click="cancel" class="btn btn-danger mr-25" data-toggle="tooltip" data-original-title="Cancel">
                                                        <i class="icon-close"></i> Cancel
                                                    </button>
                                                @else
                                                    <button wire:click='edt({{ $sim->id }})' class="btn btn-info mr-25" data-toggle="tooltip" data-original-title="Edit">
                                                        <i class="icon-pencil"></i> Edit
                                                    </button>
                                                @endif



                                                        <button type="button" class="btn btn-icon btn-danger btn-icon-style-1" data-toggle="modal"
                                                            data-target="#exampleModalCenter{{ $sim->id }}">
                                                            <span class="btn-icon-wrap"><i class="icon-trash"></i></span>
                                                        </button>

                                                        <div class="modal fade" id="exampleModalCenter{{ $sim->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="exampleModalCenter{{ $sim->id }}"
                                                            aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content  alert alert-warning ">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Deleteing Sim</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are You sure You want to DELETE This Sim
                                                                        </p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="button" data-dismiss="modal"
                                                                            wire:click='del({{ $sim->id }})'
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
