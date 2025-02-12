<div>
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
                                        <input type="text" name="search" wire:model.live='search' class="form-control"
                                            id="" placeholder="Search">
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
                                                <th>Health</th>
                                                <th>Code</th>
                                                <th>Img</th>
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>Stored In</th>
                                                <th>Status</th>
                                                <th class="text-center">Manage</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($devices as $device )
                                            <tr>
                                                <td>

                                                    @if ($device->health == 'New')

                                                    <div class="avatar-group-sm avatar-group">
                                                        <div class="avatar">
                                                            <span
                                                                class="avatar-text avatar-text-success  rounded-circle"><span
                                                                    class="initial-wrap"><span>NW</span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @elseif ($device->health == 'Mediam_use')
                                                    <div class="avatar-group-sm avatar-group">
                                                        <div class="avatar">
                                                            <span
                                                                class="avatar-text avatar-text-info  rounded-circle"><span
                                                                    class="initial-wrap"><span>MD</span></span>
                                                        </div>
                                                    </div>
                                                    @elseif ($device->health == 'Bad_use')
                                                    <div class="avatar-group-sm avatar-group">
                                                        <div class="avatar">
                                                            <span
                                                                class="avatar-text avatar-text-dark  rounded-circle"><span
                                                                    class="initial-wrap"><span>BD</span></span>
                                                        </div>
                                                    </div>
                                                    @elseif ($device->health == 'Scrap')
                                                    <div class="avatar-group-sm avatar-group">
                                                        <div class="avatar">
                                                            <span
                                                                class="avatar-text avatar-text-red rounded-circle"><span
                                                                    class="initial-wrap"><span>SC</span></span>
                                                        </div>
                                                    </div>
                                                    @elseif ($device->health == 'Need_fix')
                                                    <div class="avatar-group-sm avatar-group">
                                                        <div class="avatar">
                                                            <span
                                                                class="avatar-text avatar-text-warning  rounded-circle"><span
                                                                    class="initial-wrap"><span>FX</span></span>
                                                        </div>
                                                    </div>
                                                    @endif

                                                </td>
                                                <td>
                                                    <span class="badge badge-purple">{{
                                                        $device->device_code }}</span>

                                                </td>
                                                <td>
                                                    <img class="img-fluid rounded"
                                                        src="{{ asset('X-Files/Dash/imgs/devices/' . $device->main_image ) }}"
                                                        width="50" height="50" alt="icon">
                                                </td>
                                                <td>
                                                    {{ $device->device_type }}
                                                </td>
                                                <td>
                                                    {{ $device->device_name }}
                                                </td>
                                                <td>
                                                    {{ $device->stored_at }}
                                                </td>
                                                <td>
                                                    @if ($device->status == 'available')
                                                    <span class="badge badge-success">Available</span>
                                                    @elseif ($device->status == 'taken')
                                                    <span class="badge badge-indigo">Not
                                                        Available</span>
                                                    @elseif ($device->status == 'pending-receiving')
                                                    <span class="badge badge-warning">Pending
                                                        Receive</span>
                                                    @elseif ($device->status == 'pending-cancel')
                                                    <span class="badge badge-warning">Pending
                                                        Clear</span>
                                                    @elseif ($device->status == 'In-Project-Site')
                                                    <span class="badge badge-info">In Project Site</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('device.show', $device->id) }}"
                                                            class="btn btn-sm btn-brown" title="View Details">
                                                            <i class="fa fa-eye" style="color: white"></i>
                                                        </a>
                                                        <a href="{{ route('device.edit' , $device->id) }}"
                                                            class="btn btn-sm btn-info" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                         <button data-toggle="modal"
                                                            data-target="#exampleModalCenter{{ $device->id }}"
                                                            type="button" class="btn btn-sm btn-danger"
                                                            data-toggle="modal">
                                                            <i class="icon-trash"></i>
                                                        </button>
                                                        <div class="modal fade" id="exampleModalCenter{{ $device->id }}" tabindex="-1" role="dialog"
                                                            aria-labelledby="exampleModalCenter{{ $device->id }}" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content  alert alert-warning ">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Deleteing Device</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are You sure You want to DELETE This  Device <span class="badge badge-soft-danger"></span></p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="button" data-dismiss="modal" wire:click='del({{ $device->id }})' class="btn btn-danger">Delete</button>
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
                    {{ $devices->links('pagination::bootstrap-5') }}
                </div>
            </div>
            {{-- end of content --}}

        </div>
    </div>
</div>
