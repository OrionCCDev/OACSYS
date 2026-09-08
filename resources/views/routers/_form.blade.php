{{-- Shared by create and edit. $router is null when adding. --}}
@php
    $r = $router ?? null;
    $currentHolder = match (true) {
        (bool) ($r?->employee_id) => 'employee',
        (bool) ($r?->department_id) => 'department',
        (bool) ($r?->project_id) => 'project',
        (bool) ($r?->client_employee_id) => 'client',
        (bool) ($r?->consultant_id) => 'consultant',
        default => '',
    };
    $currentHolderId = $r?->employee_id ?? $r?->department_id ?? $r?->project_id
        ?? $r?->client_employee_id ?? $r?->consultant_id;
    $holderType = old('holder_type', $currentHolder);
    $holderId = old('holder_id', $currentHolderId);
@endphp

<div class="row">
    <div class="col-md-6 form-group">
        <label>Router Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $r?->name) }}" required>
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3 form-group">
        <label>Brand</label>
        <input type="text" name="brand" class="form-control" value="{{ old('brand', $r?->brand) }}" placeholder="e.g. Huawei">
    </div>
    <div class="col-md-3 form-group">
        <label>Model</label>
        <input type="text" name="model" class="form-control" value="{{ old('model', $r?->model) }}">
    </div>
</div>

<div class="row">
    <div class="col-md-4 form-group">
        <label>Serial Number</label>
        <input type="text" name="serial_number" class="form-control" value="{{ old('serial_number', $r?->serial_number) }}">
        <small class="form-text text-muted">Shown as "Router S/N" on the SIM report.</small>
    </div>
    <div class="col-md-4 form-group">
        <label>Supplier</label>
        <select name="supplier_id" class="form-control select2">
            <option value="">Select Supplier</option>
            @foreach($suppliers as $supplier)
            <option value="{{ $supplier->id }}" {{ old('supplier_id', $r?->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Status <span class="text-danger">*</span></label>
        <select name="status" class="form-control" required>
            @foreach(['in-stock' => 'In Stock', 'active' => 'Active (in service)', 'faulty' => 'Faulty', 'retired' => 'Retired'] as $val => $label)
            <option value="{{ $val }}" {{ old('status', $r?->status ?? 'in-stock') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-4 form-group">
        <label>Assigned To</label>
        <select name="holder_type" id="holderType" class="form-control">
            <option value="">Unassigned</option>
            <option value="employee" {{ $holderType == 'employee' ? 'selected' : '' }}>Employee</option>
            <option value="department" {{ $holderType == 'department' ? 'selected' : '' }}>Department</option>
            <option value="project" {{ $holderType == 'project' ? 'selected' : '' }}>Project</option>
            <option value="client" {{ $holderType == 'client' ? 'selected' : '' }}>Client</option>
            <option value="consultant" {{ $holderType == 'consultant' ? 'selected' : '' }}>Consultant</option>
        </select>
        <small class="form-text text-muted">Becomes "Account Site" on the SIM report.</small>
    </div>

    @php
        $groups = [
            'employee' => ['label' => 'Employee', 'items' => $employees, 'text' => 'name'],
            'department' => ['label' => 'Department', 'items' => $departments, 'text' => 'name'],
            'project' => ['label' => 'Project', 'items' => $projects, 'text' => 'project_name'],
            'client' => ['label' => 'Client', 'items' => $clientEmployees, 'text' => 'name'],
            'consultant' => ['label' => 'Consultant', 'items' => $consultants, 'text' => 'name'],
        ];
    @endphp
    @foreach($groups as $key => $group)
    <div class="col-md-4 form-group holder-group" data-type="{{ $key }}" style="{{ $holderType != $key ? 'display:none' : '' }}">
        <label>{{ $group['label'] }}</label>
        <select name="holder_id" class="form-control holder-select" {{ $holderType != $key ? 'disabled' : '' }}>
            <option value="">Select {{ $group['label'] }}</option>
            @foreach($group['items'] as $item)
            <option value="{{ $item->id }}" {{ $holderType == $key && $holderId == $item->id ? 'selected' : '' }}>{{ $item->{$group['text']} }}</option>
            @endforeach
        </select>
    </div>
    @endforeach
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label>Image</label>
        <input type="file" name="main_image" class="form-control" accept="image/*">
        @if($r && $r->main_image)
        <small class="form-text text-muted">Choose a file to replace the current image.</small>
        @endif
    </div>
</div>

<div class="form-group">
    <label>Notes</label>
    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $r?->notes) }}</textarea>
</div>

<script>
    // Only the chosen holder's select stays enabled, so exactly one holder_id
    // is ever submitted.
    document.getElementById('holderType').addEventListener('change', function () {
        var type = this.value;
        document.querySelectorAll('.holder-group').forEach(function (group) {
            var match = group.dataset.type === type;
            group.style.display = match ? 'block' : 'none';
            var select = group.querySelector('.holder-select');
            select.disabled = !match;
            if (!match) select.value = '';
        });
    });
</script>
