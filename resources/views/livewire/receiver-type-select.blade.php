<div class="col-12">
    <div class="row">
        <div class="col-12 col-md-6 form-group">
            <h6>Receiver Type</h6>
            <div class="input-group mb-2 w-100">
                <select wire:model.live="selectedType" name="receiver_type"
                    class="form-control custom-select form-control custom-select-md mt-15">
                    <option value="employee">Employee</option>
                    <option value="client">Client</option>
                    <option value="consultant">Consultant</option>
                </select>
            </div>
        </div>

        <div class="col-12 col-md-6 form-group">
            <h6>Select Receiver</h6>
            <div class="input-group mb-2 w-100 d-flex flex-column">
                @if($selectedType === 'employee')
                    <input type="text"
                           wire:model.live="searchEmployeeId"
                           wire:change="selectEmployeeBySearch"
                           class="form-control w-100"
                           placeholder="Search by Employee ID"
                           value="{{ $selectedPerson ? $this->getSelectedEmployeeId() : '' }}">
                @endif
                <select wire:model.live='selectedPerson'
                        wire:change="updateSearchInput"
                        name="receiver_id"
                        class="form-control w-100 custom-select form-control custom-select-md mt-15">
                    <option value="" selected>Select {{ ucfirst($selectedType) }}</option>
                    @foreach($receivers as $receiver)
                    <option value="{{ $receiver->id }}">{{ $receiver->employee_id }} - {{ $receiver->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <section class="hk-sec-wrapper">
        <h5 class="hk-sec-title">All Receives</h5>
        <p class="mb-25">Receives</p>
        <div class="row">
            <div class="col-sm">
                <div class="accordion" id="accordion_2">
                    <div class="card">

                        <div class="card-header d-flex justify-content-between">
                            <a role="button" data-toggle="collapse" href="#collapse_2" aria-expanded="false"
                                class="collapsed">Pending Upload</a>
                            <span class="collapse-icon"></span>
                        </div>
                        <div id="collapse_2" class="collapse" data-parent="#accordion_2" role="tabpanel">
                            <div class="card">
                                <div class="table-wrap">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0 mt-2">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Received At</th>
                                                    <th>Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($this->getReceives() as $receive)
                                                <tr>

                                                    <td>{{ $receive->code }}</td>
                                                    <td>{{ $receive->created_at }}</td>

                                                    <td>
                                                        @if ($receive->status == 'pending')
                                                        <a href="{{ route('receive.show' , ['receive'=> $receive->id]) }}"
                                                            class="btn btn-warning btn-wth-icon icon-wthot-bg btn-rounded icon-right">
                                                            <span class="btn-text">Up-Signature</span><span
                                                                class="icon-label"><i class="fa fa-angle-right"></i>
                                                            </span>
                                                        </a>
                                                        @else
                                                        <button
                                                            class="btn btn-danger btn-wth-icon icon-wthot-bg btn-rounded icon-right">
                                                            <span class="btn-text">Clearance</span><span
                                                                class="icon-label"><i class="fa fa-angle-right"></i>
                                                            </span>
                                                        </button>
                                                        <a href="{{ route('receive.show' , ['receive' => $receive->id]) }}"
                                                            class="btn btn-success btn-wth-icon icon-wthot-bg btn-rounded icon-right"><span
                                                                class="btn-text">Show</span><span class="icon-label"><i
                                                                    class="fa fa-angle-right"></i> </span></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="hk-sec-wrapper" id="selectedDevices" style="background-color: cornflowerblue;">
        <h5 class="hk-sec-title">Selected Devices To Make Receive</h5>
        <div class="row">
            <div class="card col-12">

                <div class="table-wrap w-100">
                    <div class="table-responsive  w-100">
                        <table class="table table-hover mb-0 mt-2  w-100">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Img</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($this->selectedDevices as $device)
                                @php
                                $selectedDevice = \App\Models\Device::find($device);
                                @endphp
                                <tr>
                                    <td>
                                        <span class="badge badge-primary">{{ $selectedDevice->device_code }}</span>
                                    </td>
                                    <td>
                                        <img class="img-fluid rounded" width="75"
                                            src="{{ asset('X-Files/Dash/imgs/devices/' . $selectedDevice->main_image) }}"
                                            alt="icon">
                                    </td>
                                    <td>
                                        {{ $selectedDevice->device_name }}
                                    </td>
                                    <td>
                                        {{ $selectedDevice->device_type }}
                                    </td>
                                    <td>
                                        <button type="button"
                                            wire:click="removeFromPersonDevices({{ $selectedDevice->id }})"
                                            class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Remove From Receiving
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                @foreach($this->selectedSimCards as $selectedSim)
                                <tr>
                                    <td colspan="2">
                                        <span class="badge badge-primary">{{ $selectedSim->sim_plan }}</span>
                                    </td>
                                    <td colspan="2">
                                        {{ $selectedSim->sim_number }}
                                    </td>

                                    <td>
                                        <button type="button"
                                            wire:click="removeSimFromSelection({{ $selectedSim->id }})"
                                            class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Remove From Receiving
                                        </button>
                                    </td>
                                </tr>
                                @endforeach

                    </tbody>
                    </table>
                    <div class="row mt-30">
                        <div class="col-auto">
                            <button type="button" wire:click="makeReceiving"
                            {{ empty($selectedPerson) || (empty($selectedDevices) && empty($selectedSimcards)) ? 'disabled' : '' }}
                            class="btn btn-gradient-space mb-2">
                            Make Receiving
                        </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
<section class="hk-sec-wrapper">
    <h5 class="hk-sec-title">Select Devices To Deleiver To {{ $selectedPersonName ?? 'NoT Selected' }}</h5>
    <div class="row">
        <div class="card col-12">
            <div class="form-group row">
                <h2 class="col-12 text-center p-3" for="basic-url">Search By Name Or Code Or SerialNumber</h2>
                <div class="input-group col-12">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">Device Code Or Name Or Serial</span>
                    </div>
                    <input type="text" value="" wire:model.live='searchOfDevice' class="form-control" id="basic-url"
                        aria-describedby="basic-addon3">
                </div>
            </div>
            <div class="table-wrap w-100">
                <div class="table-responsive  w-100">
                    <table class="table table-hover mb-0 mt-2  w-100">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Img</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($devices as $device)
                            <tr>
                                <td><span class="badge badge-primary">{{ $device->device_code }}</span></td>
                                <td><img class="img-fluid rounded" width="75"
                                        src="{{ asset('X-Files/Dash/imgs/devices/' . $device->main_image) }}"
                                        alt="icon"></td>
                                <td>
                                    {{ $device->device_name }}
                                </td>
                                <td>
                                    {{ $device->device_type }}
                                </td>

                                <td>
                                    <button type="button" {{ empty($this->selectedPerson) ? 'disabled' : '' }}
                                        wire:click="addDeviceToSelection({{ $device->id }})" class="btn
                                        btn-gradient-sunset btn-wth-icon btn-rounded icon-right">
                                        <span class="btn-text">Add To List</span>
                                        <span class="icon-label">
                                            <span class="feather-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-arrow-right-circle">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <polyline points="12 16 16 12 12 8"></polyline>
                                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                                </svg>
                                            </span>
                                        </span>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $devices->links() }}

                </div>
            </div>
        </div>
    </div>
</section>
<section class="hk-sec-wrapper">
    <h5 class="hk-sec-title">Available SIM Cards</h5>
    <p class="mb-25">Select SIM Cards to Assign</p>
    <div class="row">
        <div class="form-group row col-12">
            <h2 class="col-12 text-center p-3">Search SIM Card</h2>
            <div class="input-group col-12">
                <div class="input-group-prepend">
                    <span class="input-group-text">SIM Number</span>
                </div>
                <input type="text" wire:model.live='searchOfSim' class="form-control" placeholder="Enter SIM number">
            </div>
        </div>
        <div class="card col-12">
            <div class="table-wrap w-100">
                <div class="table-responsive w-100">
                    <table class="table table-hover mb-0 mt-2">
                        <thead>
                            <tr>
                                <th>SIM Number</th>
                                <th>SIM Provider</th>
                                <th>SIM Plan</th>
                                <th>Status</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($this->getSimCards() as $sim)
                            <tr>
                                <td><span class="badge badge-primary ">{{ $sim->sim_number }}</span></td>
                                <td><span class="badge badge-primary ">{{ $sim->sim_provider }}</span></td>
                                <td><span class="badge badge-primary ">{{ $sim->sim_plan }}</span></td>

                                <td><span class="badge badge-success">{{ $sim->status }}</span></td>

                                <td>
                                    <button type="button" {{ empty($this->selectedPerson) ? 'disabled' : '' }}
                                        wire:click="addSimToSelection({{ $sim->id }})" class="btn btn-gradient-sunset
                                        btn-wth-icon btn-rounded icon-right">
                                        <span class="btn-text">Add SIM</span>
                                        <span class="icon-label">
                                            <span class="feather-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-plus-circle">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <line x1="12" y1="8" x2="12" y2="16" />
                                                    <line x1="8" y1="12" x2="16" y2="12" />
                                                </svg>
                                            </span>
                                        </span>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $this->getSimCards()->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    window.Livewire.on('urlChanged', params => {
        const url = new URL(window.location);
        Object.entries(params).forEach(([key, value]) => {
            if (value) {
                url.searchParams.set(key, value);
            } else {
                url.searchParams.delete(key);
            }
        });
        history.pushState(params, '', url);
    });

    window.addEventListener('popstate', (event) => {
        if (event.state) {
            window.Livewire.emit('historyStateChanged', event.state);
        }
    });
</script>
</div>
