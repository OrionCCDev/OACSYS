{{-- Shared by create and edit. $sim is null when adding. --}}
@php
    $s = $sim ?? null;
    $currentHolder = match (true) {
        (bool) ($s?->employee_id) => 'employee',
        (bool) ($s?->department_id) => 'department',
        (bool) ($s?->project_id) => 'project',
        (bool) ($s?->client_employee_id) => 'client',
        (bool) ($s?->consultant_id) => 'consultant',
        default => '',
    };
    $currentHolderId = $s?->employee_id ?? $s?->department_id ?? $s?->project_id
        ?? $s?->client_employee_id ?? $s?->consultant_id;
    $holderType = old('holder_type', $currentHolder);
    $holderId = old('holder_id', $currentHolderId);
@endphp

<div class="row">
    <div class="col-md-4 form-group">
        <label>SIM Number <span class="text-danger">*</span></label>
        <input type="text" name="sim_number" class="form-control" value="{{ old('sim_number', $s?->sim_number) }}" required>
        @error('sim_number') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 form-group">
        <label>Provider <span class="text-danger">*</span></label>
        <input type="text" name="sim_provider" class="form-control" list="providerList"
               value="{{ old('sim_provider', $s?->sim_provider) }}" placeholder="ETISALAT or DU" required>
        <datalist id="providerList">
            <option value="ETISALAT">
            <option value="DU">
        </datalist>
        @error('sim_provider') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 form-group">
        <label>Account Name</label>
        <input type="text" name="account_name" class="form-control" value="{{ old('account_name', $s?->account_name) }}"
               placeholder="e.g. Eng. Saqer, Orion">
        <small class="form-text text-muted">Who the line is registered to with the provider.</small>
    </div>
</div>

<div class="row">
    <div class="col-md-4 form-group">
        <label>SIM S/N</label>
        <input type="text" name="sim_serial" class="form-control" value="{{ old('sim_serial', $s?->sim_serial) }}">
    </div>
    <div class="col-md-4 form-group">
        <label>Contract No</label>
        <input type="text" name="contract_no" class="form-control" value="{{ old('contract_no', $s?->contract_no) }}">
    </div>
    <div class="col-md-4 form-group">
        <label>Router</label>
        <select name="router_id" class="form-control select2">
            <option value="">Not fitted in a router</option>
            @foreach($routers as $router)
            <option value="{{ $router->id }}" {{ old('router_id', $s?->router_id) == $router->id ? 'selected' : '' }}>
                {{ $router->name }}{{ $router->serial_number ? ' - ' . $router->serial_number : '' }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-4 form-group">
        <label>Account Site</label>
        <select name="holder_type" id="holderType" class="form-control">
            <option value="">Unassigned</option>
            <option value="employee" {{ $holderType == 'employee' ? 'selected' : '' }}>Employee</option>
            <option value="department" {{ $holderType == 'department' ? 'selected' : '' }}>Department</option>
            <option value="project" {{ $holderType == 'project' ? 'selected' : '' }}>Project</option>
            <option value="client" {{ $holderType == 'client' ? 'selected' : '' }}>Client</option>
            <option value="consultant" {{ $holderType == 'consultant' ? 'selected' : '' }}>Consultant</option>
        </select>
        <small class="form-text text-muted">Where the line was delivered.</small>
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

    <div class="col-md-4 form-group">
        <label>Remark</label>
        <input type="text" name="remark" class="form-control" value="{{ old('remark', $s?->remark) }}"
               placeholder="e.g. CAMERA SYS, STOCK, WAS 246">
    </div>
</div>

<div class="row">
    <div class="col-md-4 form-group">
        <label class="d-block">Line Status</label>
        <div class="custom-control custom-checkbox mt-2">
            {{-- Hidden 0 first: an unchecked box sends nothing at all. --}}
            <input type="hidden" name="line_active" value="0">
            <input type="checkbox" name="line_active" value="1" class="custom-control-input" id="lineActive"
                   {{ old('line_active', $s?->line_active ?? true) ? 'checked' : '' }}>
            <label class="custom-control-label" for="lineActive">Line is active with the provider</label>
        </div>
    </div>
</div>

<div class="form-group">
    <label>Notes</label>
    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $s?->notes) }}</textarea>
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
