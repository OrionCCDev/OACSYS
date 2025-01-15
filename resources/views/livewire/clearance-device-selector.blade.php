<div class="col-12">
    <div class="row">
        <div class="col-md-6">
            <select wire:model.live="selectedType" class="form-control">
                <option value="">Select Type</option>
                <option value="employee">Employee</option>
                <option value="client">Client Employee</option>
                <option value="consultant">Consultant</option>
            </select>
        </div>

        <div class="col-md-6">
            <select wire:model.live="selectedEmployee" class="form-control" @if(!$selectedType) disabled @endif>
                <option value="">Select Person</option>
                @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
<style>
    @media print {
    body * {
        visibility: hidden;
    }
    #PrintingArea, #PrintingArea * {
        visibility: visible;
    }
    #PrintingArea {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
    }
}
</style>
    @if($devices && count($devices) > 0)
    <div class="table-responsive mt-4">
        <h5 class="hk-sec-title">Devices</h5>
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Img</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devices as $device)
                <tr>
                    <td>
                        <img class="img-fluid rounded"
                            src="{{ asset('X-Files/Dash/imgs/devices/' . $device->main_image ) }}" width="50"
                            height="50" alt="icon">
                    </td>
                    <td>{{ $device->device_code }}</td>
                    <td>{{ $device->device_name }}</td>
                    <td>{{ $device->device_type }}</td>
                    <td>
                        <button wire:click="addToClearance('device', {{ $device->id }})"
                            class="btn btn-primary btn-rounded" @if(in_array($device->id, $selectedItems['device'] ??
                            [])) disabled @endif>
                            Clear
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($simCards && count($simCards) > 0)
    <div class="table-responsive mt-4">
        <h5 class="hk-sec-title">Sim Cards</h5>
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Serial</th>
                    <th>Number</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($simCards as $sim)
                <tr>
                    <td>{{ $sim->sim_serial }}</td>
                    <td>{{ $sim->sim_number }}</td>
                    <td>
                        <button wire:click="addToClearance('simcard', {{ $sim->id }})"
                            class="btn btn-primary btn-rounded" @if(in_array($sim->id, $selectedItems['simcard'] ?? []))
                            disabled @endif>
                            Clear
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($showPrintArea)
    <div class="mt-4">
        @if(!$clearanceId)
        <button wire:click="createClearance" class="btn btn-primary">
            Create Clearance
        </button>
        @else
        <button wire:click="$set('showUploadModal', true)" class="btn btn-success">
            Upload Signed Clearance
        </button>
        <button wire:click="cancelClearance" class="btn btn-danger">
            Cancel Clearance
        </button>
        <button onclick="window.print()" class="btn btn-info">
            Print Clearance
        </button>
        @endif
        <!-- Upload Modal -->
        @if($showUploadModal)
        <div class="modal show" style="display: block; background: rgba(0,0,0,0.5)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Signed Clearance</h5>
                        <button wire:click="$set('showUploadModal', false)" class="close">×</button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit="uploadSignedClearance">
                            <div class="form-group">
                                <label>Signed Clearance Document</label>
                                <input type="file" wire:model="signedClearanceFile" class="form-control">
                                @error('signedClearanceFile')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="row" id="PrintingArea">

        <div class="col-xl-12">
            <section class="hk-sec-wrapper hk-invoice-wrap pa-35">
                <div class="invoice-from-wrap">
                    <div class="row">
                        <div class="col-sm-6 mb-20 text-center justify-self-center">
                            <img class="img-fluid invoice-brand-img d-block mb-20" width="250"
                                src="{{ asset('X-Files/Dash/imgs/logo-blue.webp') }}" alt="brand">
                        </div>
                        <div class="col-sm-6 mb-20">
                            <h4 class="mb-35 font-weight-600">Clearance Details Of Orion Devices</h4>
                            <h4 class="mb-35 font-weight-600">Clearance <span style="color:#174094 "
                                    class="d-block font-18 font-weight-600">
                                    <h4>#{{ $clearanceCode }}</h4>
                                </span></h4>
                        </div>

                    </div>
                </div>
                <hr class="mt-0">
                <div class="invoice-to-wrap pb-20">
                    <div class="row">
                        <div class="col-12 mb-30 text-center" style="justify-items: center">



                        </div>
                    </div>
                </div>
                <h3 class="text-center px-5" style="color:#174094 ">I, the undersigned,<br> confirm that the mentioned
                    <br>
                    devices and Items has been returned to the company</h3>
                <h5 class="mt-3" style="color:#174094 ">Items</h5>
                <hr>
                <div class="invoice-details" style="min-height:550px">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            @if(count($selectedDevices) > 0)
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Model</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($selectedDevices as $device)
                                    <tr>
                                        <td>{{ $device->device_code }}</td>
                                        <td>{{ $device->device_name }}</td>
                                        <td>{{ $device->device_type }}</td>
                                        <td>{{ $device->device_model }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            @endif

                        </div>
                    </div>



                    @if(count($selectedSimCards) > 0)
                    <div class="table-wrap" style="margin-top: 50px">
                        <div class="table-responsive">
                            <h5>SIM Cards</h5>
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Number</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($selectedSimCards as $sim)
                                    <tr>
                                        <td>{{ $sim->sim_serial }}</td>
                                        <td>{{ $sim->sim_number }}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    @endif

                </div>
                <div class="row mt-30">
                    <div class="col-4 text-center" style="padding-bottom: 70px">
                        <h6>Receiver Signature</h6>
                    </div>
                    <div class="col-4 text-center" style="padding-bottom: 70px">
                        <h6>IT Manager</h6>
                    </div>
                    <div class="col-4 text-center" style="padding-bottom: 70px">
                        <h6>Top Management Signature</h6>
                    </div>
                </div>
                <hr>
                <ul class="invoice-terms-wrap font-14 list-ul">
                    <h6>By Signing This paper You Accept The Following Roles</h6>
                    <li>Do not make any unauthorized modifications or repairs to the equipment.</li>
                    <li>Handle all equipment with care to avoid damage.</li>
                    <li>Use appropriate packaging and protective materials during transportation and storage.</li>
                    <li>For any updates, modifications, or fixes, the equipment must be returned to the IT department.
                    </li>
                    <li>Contact the IT department through the provided channels for any necessary changes or repairs.
                    </li>
                    <li>Any damage caused to the equipment due to negligence or misuse will be the responsibility of the
                        receiver.</li>
                </ul>
            </section>
        </div>
    </div>
    @endif
</div>
