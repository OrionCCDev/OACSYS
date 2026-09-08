@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Receive Rental Printer</h2>
                <p>Register a printer against its ERP purchase order.</p>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <form action="{{ route('printers.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Project <span class="text-danger">*</span></label>
                                    <select name="project_id" class="form-control select2" required>
                                        <option value="">Select Project</option>
                                        @foreach($projects as $proj)
                                        <option value="{{ $proj->id }}" {{ old('project_id', $project?->id) == $proj->id ? 'selected' : '' }}>{{ $proj->project_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('project_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Printer Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Model</label>
                                    <input type="text" name="model" class="form-control" value="{{ old('model') }}">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Size <span class="text-danger">*</span></label>
                                    <select name="size" class="form-control" required>
                                        <option value="">Select size</option>
                                        <option value="big" {{ old('size') == 'big' ? 'selected' : '' }}>Big</option>
                                        <option value="small" {{ old('size') == 'small' ? 'selected' : '' }}>Small</option>
                                    </select>
                                    <small class="form-text text-muted">Splits the monthly report.</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Serial Number</label>
                                    <input type="text" name="serial_number" class="form-control" value="{{ old('serial_number') }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Supplier</label>
                                    <select name="supplier_id" class="form-control select2">
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">
                                        <a href="{{ route('supplier.create') }}" target="_blank">Add a new supplier</a>
                                    </small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>PO Number <span class="text-danger">*</span></label>
                                    <input type="text" name="po_number" class="form-control" value="{{ old('po_number') }}" placeholder="From the ERP" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>PO Document</label>
                                    <input type="file" name="po_document" class="form-control" accept="image/*,application/pdf">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Assigned To <span class="text-danger">*</span></label>
                                    <select name="delivered_to_type" id="deliveredToType" class="form-control" required>
                                        <option value="">Select who it's assigned to</option>
                                        <option value="client">Client</option>
                                        <option value="consultant">Consultant</option>
                                        <option value="office">Orion (our office)</option>
                                    </select>
                                </div>
                                {{-- shown by the script below once a type is chosen; Orion needs no target --}}
                                <div class="col-md-6 form-group delivery-target-group" data-type="client" style="display:none">
                                    <label>Client</label>
                                    <select name="target_id" class="form-control delivery-target" disabled>
                                        <option value="">Select Client</option>
                                        @foreach($clientEmployees as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group delivery-target-group" data-type="consultant" style="display:none">
                                    <label>Consultant</label>
                                    <select name="target_id" class="form-control delivery-target" disabled>
                                        <option value="">Select Consultant</option>
                                        @foreach($consultants as $consultant)
                                        <option value="{{ $consultant->id }}">{{ $consultant->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Designation</label>
                                    <input type="text" name="designation" class="form-control" value="{{ old('designation') }}"
                                           placeholder="e.g. Ground Floor, DC Office, Mwafaq &amp; Hussain store">
                                    <small class="form-text text-muted">Where it actually sits. Shown on the monthly report; defaults to the assignment above if left blank.</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', now()->toDateString()) }}" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Image</label>
                                    <input type="file" name="main_image" class="form-control" accept="image/*">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Notes</label>
                                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Receive Printer</button>
                            <a href="{{ $project ? route('project.details', $project->id) : route('printers.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('deliveredToType').addEventListener('change', function () {
        const type = this.value;
        document.querySelectorAll('.delivery-target-group').forEach(function (group) {
            const isMatch = group.dataset.type === type;
            group.style.display = isMatch ? 'block' : 'none';
            const select = group.querySelector('.delivery-target');
            select.disabled = !isMatch;
            select.required = isMatch;
        });
    });
</script>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Search...',
            allowClear: true
        });
    });
</script>
@endpush
@endsection
