@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Consultant Management</h2>
            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title">Add New Consultant</h5>
                        <div class="row">
                            <div class="col-sm">
                                <form method="post" enctype="multipart/form-data" action="{{ route('consultant.store') }}"
                                    class="form-inline">
                                    @csrf
                                    <div class="row w-100">
                                        <div class="col-12 col-md-6 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Project</h6>
                                            <div class="input-group mb-2 w-100">
                                                <select name="consultant_project_id"
                                                    class="form-control custom-select form-control custom-select-md mt-15">
@foreach ( $allProjects as $project )

<option value="{{  }}" {{ old('consultant_project_id') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
@endforeach

                                                </select>
                                            </div>
                                            @error('consultant_project_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Device Name</h6>
                                            <label class="sr-only" for="AddNewEmployeeCode">Device Name</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Name</div>
                                                </div>
                                                <input type="text" name="device_name" class="form-control"
                                                    id="AddNewEmployeeCode" placeholder="Name Of Device" value="{{ old('device_name') }}">
                                            </div>
                                            @error('device_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row w-100">
                                        <div class="col-12 col-md-6 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Device Image</h6>
                                            <label class="sr-only" for="AddNewEmployeeImage">Device Image</label>
                                            <div class="fileinput fileinput-new input-group w-100"
                                                data-provides="fileinput">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="form-control text-truncate" data-trigger="fileinput"><i
                                                        class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                                        class="fileinput-filename"></span></div>
                                                <span class="input-group-append">
                                                    <span class=" btn btn-primary btn-file"><span
                                                            class="fileinput-new">Select Image</span><span
                                                            class="fileinput-exists">Change</span>
                                                        <input id="AddNewEmployeeImage" onchange="showPreview(event)"
                                                            type="file" name="main_image">
                                                    </span>
                                                    <a href="#" class="btn btn-secondary fileinput-exists"
                                                        data-dismiss="fileinput">Remove</a>
                                                </span>
                                            </div>
                                            @error('main_image')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <script>
                                                function showPreview(event) {
                                                    if (event.target.files.length > 0) {
                                                        var src = URL.createObjectURL(event.target.files[0]);
                                                        var preview = document.getElementById("image-preview");
                                                        preview.src = src;
                                                        preview.style.display = "block";
                                                    }
                                                }
                                            </script>
                                        </div>

                                        <div class="col-12 col-md-6 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Device Model</h6>
                                            <label class="sr-only" for="AddNewEmployeeName">Model</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Device Model</div>
                                                </div>
                                                <input type="text" name='device_model' class="form-control"
                                                    id="AddNewEmployeeName" placeholder="Device Model" value="{{ old('device_model') }}">
                                            </div>
                                            @error('device_model')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row w-100">
                                        <div class="col-12 col-md-6 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Device Price</h6>
                                            <label class="sr-only" for="AddNewEmployeePersonalMobile">Device
                                                Price</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Device Price</div>
                                                </div>
                                                <input type="text" name='device_price' class="form-control"
                                                    id="AddNewEmployeePersonalMobile" placeholder="device price" value="{{ old('device_price') }}">
                                            </div>
                                            @error('device_price')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Device Brand</h6>
                                            <label class="sr-only" for="AddNewEmployeePersonalMobile">Supplier Or
                                                Brand</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Supplier Or Brand</div>
                                                </div>
                                                <input type="text" name='supplier_name' class="form-control"
                                                    id="AddNewEmployeePersonalMobile" placeholder="Supplier Or Brand" value="{{ old('supplier_name') }}">
                                            </div>
                                            @error('supplier_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row w-100">
                                        <div class="col-6 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Device Serial Number</h6>
                                            <label class="sr-only" for="AddNewEmployeePersonalMobile1">Device Serial
                                                Number</label>
                                            <div class="input-group mb-2 w-100">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Serial Number</div>
                                                </div>
                                                <input type="text" name='serial_number' class="form-control"
                                                    id="AddNewEmployeePersonalMobile1" placeholder="Serial Number" value="{{ old('serial_number') }}">
                                            </div>
                                            @error('serial_number')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-6 col-md-3 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Device Stored Place</h6>
                                            <div class="input-group mb-2 w-100">
                                                <select name="stored_at"
                                                    class="form-control custom-select form-control custom-select-md mt-15">
                                                    <option value="office" {{ old('stored_at') == 'office' ? 'selected' : '' }}>Our Office</option>
                                                    <option value="server" {{ old('stored_at') == 'server' ? 'selected' : '' }}>Server Room</option>
                                                    <option value="store" {{ old('stored_at') == 'store' ? 'selected' : '' }}>Store Area</option>
                                                    <option value="delivered" {{ old('stored_at') == 'delivered' ? 'selected' : '' }}>With Employee</option>
                                                </select>
                                            </div>
                                            @error('stored_at')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-3 form-group">
                                            <h6 for="AddNewEmployeeOrionEmail">Device Health</h6>
                                            <div class="input-group mb-2 w-100">
                                                <select name="health"
                                                    class="form-control custom-select form-control custom-select-md mt-15">
                                                    <option value="New" {{ old('health') == 'New' ? 'selected' : '' }}>New</option>
                                                    <option value="Mediam_use" {{ old('health') == 'Mediam_use' ? 'selected' : '' }}>Medium</option>
                                                    <option value="Bad_use" {{ old('health') == 'Bad_use' ? 'selected' : '' }}>Bad</option>
                                                    <option value="Need_fix" {{ old('health') == 'Need_fix' ? 'selected' : '' }}>Need Maintain</option>
                                                    <option value="Scrap" {{ old('health') == 'Scrap' ? 'selected' : '' }}>Scrap</option>
                                                </select>
                                            </div>
                                            @error('health')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row w-100 mt-2 mx-10">
                                        <h6 class="" for="AddNewEmployeeOrionEmail">Short Description</h6>
                                        <textarea name="short_description" class="form-control mt-15 w-100 " rows="3"
                                            placeholder="Description">{{ old('short_description') }}</textarea>
                                    </div>

                                    <div class="row w-100 mt-2 mx-10">
                                        <h6 class="" for="AddNewEmployeeOrionEmail">Other Notes</h6>
                                        <textarea name="notes" class="form-control mt-15 w-100 " rows="3"
                                            placeholder="Notes">{{ old('notes') }}</textarea>
                                    </div>

                                    <section class="hk-sec-wrapper w-100 mt-5">
                                        <h5 class="hk-sec-title">Device Gallary</h5>
                                        <p class="mb-40">Plz Upload Max 5 images for single Device</p>
                                        <div class="row w-100">
                                            <div class="col-12">
                                                @livewire('device-image-upload')
                                            </div>
                                        </div>
                                    </section>

                                    <br>
                                    <div class="row mt-30">
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary mb-2">Save</button>
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
@endsection
