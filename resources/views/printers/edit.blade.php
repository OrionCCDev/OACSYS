@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Edit Printer</h2>
                <p>Correct this printer's details. To move it to another project under a new PO use Transfer instead, so its history is kept.</p>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <form action="{{ route('printers.update', $printer->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Project <span class="text-danger">*</span></label>
                                    <select name="project_id" class="form-control select2" required>
                                        @foreach($projects as $proj)
                                        <option value="{{ $proj->id }}" {{ old('project_id', $printer->project_id) == $proj->id ? 'selected' : '' }}>{{ $proj->project_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('project_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Printer Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $printer->name) }}" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Model</label>
                                    <input type="text" name="model" class="form-control" value="{{ old('model', $printer->model) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Serial Number</label>
                                    <input type="text" name="serial_number" class="form-control" value="{{ old('serial_number', $printer->serial_number) }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Supplier</label>
                                    <select name="supplier_id" class="form-control select2">
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $printer->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>PO Number <span class="text-danger">*</span></label>
                                    <input type="text" name="po_number" class="form-control" value="{{ old('po_number', $printer->po_number) }}" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>PO Document</label>
                                    <input type="file" name="po_document" class="form-control" accept="image/*,application/pdf">
                                    <small class="form-text text-muted">
                                        @if($printer->po_document)
                                            <a href="{{ asset('X-Files/Dash/imgs/printers/po/' . $printer->po_document) }}" target="_blank">Current document</a> &mdash; choose a file to replace it.
                                        @else
                                            No document uploaded yet.
                                        @endif
                                    </small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Assigned To <span class="text-danger">*</span></label>
                                    <select name="delivered_to_type" id="deliveredToType" class="form-control" required>
                                        <option value="client" {{ old('delivered_to_type', $printer->delivered_to_type) == 'client' ? 'selected' : '' }}>Client</option>
                                        <option value="consultant" {{ old('delivered_to_type', $printer->delivered_to_type) == 'consultant' ? 'selected' : '' }}>Consultant</option>
                                        <option value="office" {{ old('delivered_to_type', $printer->delivered_to_type) == 'office' ? 'selected' : '' }}>Orion (our office)</option>
                                    </select>
                                </div>
                                @php $currentType = old('delivered_to_type', $printer->delivered_to_type); @endphp
                                <div class="col-md-6 form-group delivery-target-group" data-type="client" style="{{ $currentType != 'client' ? 'display:none' : '' }}">
                                    <label>Client</label>
                                    <select name="target_id" class="form-control delivery-target" {{ $currentType != 'client' ? 'disabled' : '' }}>
                                        <option value="">Select Client</option>
                                        @foreach($clientEmployees as $client)
                                        <option value="{{ $client->id }}" {{ old('target_id', $printer->client_employee_id) == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group delivery-target-group" data-type="consultant" style="{{ $currentType != 'consultant' ? 'display:none' : '' }}">
                                    <label>Consultant</label>
                                    <select name="target_id" class="form-control delivery-target" {{ $currentType != 'consultant' ? 'disabled' : '' }}>
                                        <option value="">Select Consultant</option>
                                        @foreach($consultants as $consultant)
                                        <option value="{{ $consultant->id }}" {{ old('target_id', $printer->consultant_id) == $consultant->id ? 'selected' : '' }}>{{ $consultant->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $printer->start_date?->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Image</label>
                                    <input type="file" name="main_image" class="form-control" accept="image/*">
                                    <small class="form-text text-muted">Choose a file to replace the current image.</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Notes</label>
                                <textarea name="notes" class="form-control" rows="2">{{ old('notes', $printer->notes) }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="{{ route('printers.show', $printer->id) }}" class="btn btn-secondary">Cancel</a>
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
        $('.select2').select2({ placeholder: 'Search...', allowClear: true });
    });
</script>
@endpush
@endsection
