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
                                                <th class="text-center">Clear OR Receive</th>
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
                                                        {{-- <button data-toggle="modal"
                                                            data-target="#exampleModalCenter{{ $employee->id }}"
                                                            type="button" class="btn btn-sm btn-danger"
                                                            data-toggle="modal" data-target="#exampleModalCenter8">
                                                            <i class="icon-trash"></i>
                                                        </button> --}}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    @if ($device->status == 'available')
                                                    <a href="{{ route('receive.create' ,['makeReceiveDeviceId' => $device->id , 'deviceCode' => $device->device_code]) }}"
                                                        class="btn btn-success btn-wth-icon icon-wthot-bg btn-rounded icon-right">
                                                        <span class="btn-text">Make Receive</span><span
                                                            class="icon-label"><i class="fa fa-angle-right"></i>
                                                        </span>
                                                    </a>
                                                    @elseif ($device->status == 'taken')
                                                    @if ($device->receive && $device->receive->status == 'pending')
                                                    <a href="{{ route('receive.show' , ['receive'=> $device->receive->id]) }}"
                                                        class="btn btn-warning btn-wth-icon icon-wthot-bg btn-rounded icon-right">
                                                        <span class="btn-text">Up-Signature</span>
                                                        <span class="icon-label"><i
                                                                class="fa fa-angle-right"></i></span>
                                                    </a>
                                                    @else
                                                    <a href="{{ route('receive.cancel' , ['id'=> $device->id]) }}"
                                                        class="btn btn-danger btn-wth-icon icon-wthot-bg btn-rounded icon-right">
                                                        <span class="btn-text">Clearance</span>
                                                        <span class="icon-label"><i
                                                                class="fa fa-angle-right"></i></span>
                                                    </a>
                                                    @endif

                                                    @elseif ($device->status == 'pending-receiving')
                                                    <a href="{{ route('receive.create' ,['continueReceiveDeviceId' => $device->id]) }}"
                                                        class="btn btn-gradient-info  btn-wth-icon icon-wthot-bg btn-rounded icon-right">
                                                        <span class="btn-text">Comp-Receive</span><span
                                                            class="icon-label"><i class="fa fa-angle-right"></i>
                                                        </span>
                                                    </a>

                                                    @elseif ($device->status == 'pending-cancel')
                                                    <a href="{{ route('comp.clear' ,['id' => $device->id]) }}"
                                                        class="btn btn-gradient-info  btn-wth-icon icon-wthot-bg btn-rounded icon-right">
                                                        <span class="btn-text">Comp-Clear</span><span
                                                            class="icon-label"><i class="fa fa-angle-right"></i>
                                                        </span>
                                                    </a>
                                                    @endif
                                                </td>
                                                {{-- <div class="modal fade" id="exampleModalCenter{{ $employee->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenter{{ $employee->id }}"
                                                    aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content  alert alert-warning ">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Deleteing
                                                                    Employee</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are You sure You want to DELETE This
                                                                    Client Employee <span
                                                                        class="badge badge-soft-danger"></span>
                                                                    with Code <span
                                                                        class="badge badge-soft-danger"></span>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="button" data-dismiss="modal"
                                                                    wire:click='del({{ $employee->id }})'
                                                                    class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
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
