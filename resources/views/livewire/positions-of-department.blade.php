<div class="col-xl-8">
    <div class="card card-lg">
        <h3 class="card-header bg-primary text-white border-bottom-0">
            {{ $departmentPositionsSelected ? $departmentPositionsSelected->name : 'Select a Department' }}
        </h3>
        @foreach ($departmentPositionsSelected->positions as $position )
            <div class="accordion accordion-type-2 accordion-flush" id="accordion_2{{ $departmentPositionsSelected->id }}">
                <div class="card" wire:key="{{ $position->id }}">
                    <div class="card-header d-flex justify-content-between activestate">
                        @if ($editablePositionName == $position->name)
                            <div class="form-row align-items-center">
                                <div class="col-auto">
                                    <input type="text" class="form-control" wire:model='editablePositionName' value="{{ $editablePositionName }}" >
                                </div>
                                <div class="col-auto">
                                    <button wire:click="update({{ $position->id }})" class="btn btn-warning btn-wth-icon btn-rounded icon-right btn-sm"><span class="btn-text">Update</span> <span class="icon-label"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg></span> </span></button>
                                    <button wire:click="cancel" class="btn btn-danger btn-wth-icon btn-rounded icon-right btn-sm"><span class="btn-text">Cancel</span> <span class="icon-label"><i class="fa fa-times"></i> </span></button>
                                </div>
                            </div>





                        @error('editablePositionName')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                        @else

                        <a role="button" data-toggle="collapse" href="#collapse_1i{{ $position->id }}" aria-expanded="true">
                            {{ $position->name }}
                        </a>
                        @endif
                    </div>
                    <div id="collapse_1i{{ $position->id }}" class="collapse " data-parent="#accordion_2{{ $departmentPositionsSelected->id }}" role="tabpanel">
                        <div class="card-body pa-15">

                            <button wire:click='edt({{ $position->id }})' class="btn btn-icon btn-info btn-icon-style-1"><span class="btn-icon-wrap"><i class="fa fa-pencil"></i></span></button>
                            <button type="button" class="btn btn-icon btn-danger btn-icon-style-1" data-toggle="modal"
                            data-target="#exampleModalCenter{{ $position->id }}">
                            <span class="btn-icon-wrap"><i class="icon-trash"></i></span>
                        </button>

                        <div class="modal fade" id="exampleModalCenter{{ $position->id }}"
                            tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenter{{ $position->id }}"
                            aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content  alert alert-warning ">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Deleteing Position</h5>
                                        <button type="button" class="close"
                                            data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are You sure You want to DELETE This Position
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" data-dismiss="modal"
                                            wire:click='del({{ $position->id }})'
                                            class="btn btn-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
</div>
