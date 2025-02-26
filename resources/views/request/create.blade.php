{{-- @extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Make Asset Request</h2>
            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title">Requests</h5>
                        <div class="row">
                            <div class="col-sm">

                                <form method="post" enctype="multipart/form-data" action="{{ route('device.store') }}"
                                    class="form-inline">
                                    @csrf

                                    <div class="item-request-part">
                                        <div class="row w-100">
                                            <div class="col-12 col-md-4 col-lg-3 form-group">
                                                <h6 for="AddNewEmployeeOrionEmail">Device Type</h6>
                                                <div class="input-group mb-2 w-100">
                                                    <select name="item_type" id="item_type"
                                                        class="form-control custom-select form-control custom-select-md mt-15">
                                                        <option value="Laptop" {{ old('item_type') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                                                        <option value="Other" {{ old('item_type') == 'sim_card' ? 'selected' : '' }}>Sim Card</option>
                                                        <option value="Pc" {{ old('item_type') == 'Pc' ? 'selected' : '' }}>Pc</option>
                                                        <option value="Screen" {{ old('item_type') == 'Screen' ? 'selected' : '' }}>Screen</option>
                                                        <option value="PC_Element" {{ old('item_type') == 'PC_Element' ? 'selected' : '' }}>PC Element</option>
                                                        <option value="Switch" {{ old('item_type') == 'Switch' ? 'selected' : '' }}>Switch</option>
                                                        <option value="Printer" {{ old('item_type') == 'Printer' ? 'selected' : '' }}>Printer</option>
                                                        <option value="Electric_Element" {{ old('item_type') == 'Electric_Element' ? 'selected' : '' }}>Electric Element</option>
                                                    </select>
                                                </div>
                                                @error('item_type')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-3 form-group">
                                                <h6 for="AddNewEmployeeOrionEmail">Request For</h6>
                                                <div class="input-group mb-2 w-100">
                                                    <select name="request_for_type" id="request_for_type"
                                                        class="form-control custom-select form-control custom-select-md mt-15">
                                                        <option value="employee" {{ old('request_for_type') == 'Employee' ? 'selected' : '' }}>Employee</option>
                                                        <option value="client" {{ old('request_for_type') == 'client' ? 'selected' : '' }}>Client</option>
                                                        <option value="consultant" {{ old('request_for_type') == 'consultant' ? 'selected' : '' }}>Consultant</option>
                                                        <option value="project" {{ old('request_for_type') == 'project' ? 'selected' : '' }}>Project</option>

                                                    </select>
                                                </div>
                                                @error('request_for_type')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-3 form-group">
                                                <h6 for="AddNewEmployeeOrionEmail">Receiver ID (If Exist)</h6>
                                                <label class="sr-only" for="AddNewEmployeePersonalMobile">Receiver ID</label>
                                                <div class="input-group mb-2 w-100">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Receiver ID</div>
                                                    </div>
                                                    <input type="text" name='requested_for_id' class="form-control"
                                                        id="AddNewEmployeePersonalMobile" placeholder="Receiver ID" value="{{ old('requested_for_id') }}">
                                                </div>
                                                @error('requested_for_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-3 form-group">
                                                <h6 for="AddNewEmployeeOrionEmail">Quantity</h6>
                                                <label class="sr-only" for="AddNewEmployeePersonalMobile1">Quantity</label>
                                                <div class="input-group mb-2 w-100">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Quantity</div>
                                                    </div>
                                                    <input type="text" name='quantity' class="form-control"
                                                        id="AddNewEmployeePersonalMobile1" placeholder="1" value="{{ old('quantity') }}">
                                                </div>
                                                @error('quantity')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row w-100">
                                            <div class="col-12 col-md-6 form-group">
                                                <h6 for="AddNewEmployeeOrionEmail">Name Of Receiver</h6>
                                                <label class="sr-only" for="AddNewEmployeeName">Receiver Name</label>
                                                <div class="input-group mb-2 w-100">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Receiver Name</div>
                                                    </div>
                                                    <input type="text" name='requested_for_name' class="form-control"
                                                        id="AddNewEmployeeName" placeholder="Receiver Name" value="{{ old('requested_for_name') }}">
                                                </div>
                                                @error('requested_for_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-12 col-md-6  form-group">
                                                <h6 for="AddNewEmployeeOrionEmail">Receiver Position</h6>
                                                <label class="sr-only" for="AddNewEmployeePersonalMobile">Receiver Position</label>
                                                <div class="input-group mb-2 w-100">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Receiver Position</div>
                                                    </div>
                                                    <input type="text" name='requested_for_position' class="form-control"
                                                        id="AddNewEmployeePersonalMobile" placeholder="Receiver Position" value="{{ old('requested_for_position') }}">
                                                </div>
                                                @error('requested_for_position')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="row w-100 mt-2 mx-10">
                                            <h6 class="" for="AddNewEmployeeOrionEmail">Note</h6>
                                            <textarea name="notes" class="form-control mt-15 w-100 " rows="3"
                                                placeholder="Description">{{ old('notes') }}</textarea>
                                        </div>

                                    </div>


                                    <br>
                                    <div class="row mt-30">
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
                                                text: '<p>You have successfully Add New Department</p>',
                                                position: 'top-right',
                                                loaderBg: '#7a5449',
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
                                                loaderBg: '#7a5449',
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
        </div>
    </div>
</div>
@endsection --}}
@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Make Asset Request</h2>
            </div>
        </div>
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="hk-sec-title">Requests</h5>
                            <button type="button" class="btn btn-primary" id="addRequestPart">
                                <i class="fa fa-plus"></i> Add More Items
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <form method="post" enctype="multipart/form-data" action="{{ route('asset-request.store') }}"
                                    class="form-inline">
                                    @csrf
                                    <input type="hidden" name="request_code" value="{{ 'REQ-' . time() . '-' . rand(1000,9999) }}">
                                    <div id="requestPartsContainer">
                                        <div class="item-request-part">
                                            <div class="card mt-3 mb-3">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="btn btn-danger btn-sm remove-request-part" style="display: none;">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <div class="row w-100">
                                                        <div class="col-12 col-md-4 col-lg-3 form-group">
                                                            <h6>Device Type</h6>
                                                            <div class="input-group mb-2 w-100">
                                                                <select name="requests[0][item_type]" class="form-control custom-select form-control custom-select-md mt-15">
                                                                    <option value="Laptop">Laptop</option>
                                                                    <option value="Other">Sim Card</option>
                                                                    <option value="Pc">Pc</option>
                                                                    <option value="Screen">Screen</option>
                                                                    <option value="PC_Element">PC Element</option>
                                                                    <option value="Switch">Switch</option>
                                                                    <option value="Printer">Printer</option>
                                                                    <option value="Electric_Element">Electric Element</option>
                                                                    <option value="Other">Other</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-3 form-group">
                                                            <h6>Request For</h6>
                                                            <div class="input-group mb-2 w-100">
                                                                <select name="requests[0][request_for_type]" class="form-control custom-select form-control custom-select-md mt-15">
                                                                    <option value="employee">Employee</option>
                                                                    <option value="client">Client</option>
                                                                    <option value="consultant">Consultant</option>
                                                                    <option value="project">Project</option>
                                                                    <option value="other">Other</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-3 form-group">
                                                            <h6>Receiver ID (If Exist)</h6>
                                                            <div class="input-group mb-2 w-100">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">Receiver ID</div>
                                                                </div>
                                                                <input type="text" name="requests[0][requested_for_id]" class="form-control" placeholder="Receiver ID">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-3 form-group">
                                                            <h6>Quantity</h6>
                                                            <div class="input-group mb-2 w-100">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">Quantity</div>
                                                                </div>
                                                                <input type="text" name="requests[0][quantity]" class="form-control" placeholder="1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row w-100">
                                                        <div class="col-12 col-md-6 form-group">
                                                            <h6>Name Of Receiver</h6>
                                                            <div class="input-group mb-2 w-100">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">Receiver Name</div>
                                                                </div>
                                                                <input type="text" name="requests[0][requested_for_name]" class="form-control" placeholder="Receiver Name">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 form-group">
                                                            <h6>Receiver Position</h6>
                                                            <div class="input-group mb-2 w-100">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">Receiver Position</div>
                                                                </div>
                                                                <input type="text" name="requests[0][requested_for_position]" class="form-control" placeholder="Receiver Position">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row w-100 mt-2 mx-10">
                                                        <h6>Note</h6>
                                                        <textarea name="requests[0][notes]" class="form-control mt-15 w-100" rows="3" placeholder="Description"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-30">
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary mb-2">Make</button>
                                            <a href="{{ route('asset-request.index') }}" type="submit" class="btn btn-info mb-2">Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let requestCount = 0;
    const container = document.getElementById('requestPartsContainer');
    const addButton = document.getElementById('addRequestPart');

    // Function to update name attributes
    function updateNameAttributes() {
        document.querySelectorAll('.item-request-part').forEach((part, index) => {
            part.querySelectorAll('select, input, textarea').forEach(element => {
                const name = element.getAttribute('name');
                if (name) {
                    element.setAttribute('name', name.replace(/requests\[\d+\]/, `requests[${index}]`));
                }
            });
        });
    }

    // Add new request part
    addButton.addEventListener('click', function() {
        requestCount++;
        const template = container.querySelector('.item-request-part').cloneNode(true);

        // Clear any values in the cloned form
        template.querySelectorAll('input, textarea').forEach(input => input.value = '');
        template.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

        // Show remove button for all but the first item
        const removeButtons = document.querySelectorAll('.remove-request-part');
        removeButtons.forEach(button => button.style.display = 'block');

        container.appendChild(template);
        updateNameAttributes();
    });

    // Remove request part
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-request-part')) {
            const requestPart = e.target.closest('.item-request-part');
            if (container.querySelectorAll('.item-request-part').length > 1) {
                requestPart.remove();
                updateNameAttributes();
            }
        }
    });
});
</script>
@endsection
