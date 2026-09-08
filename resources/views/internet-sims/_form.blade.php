{{-- Shared by create and edit. $sim is null when adding. --}}
@php
    $s = $sim ?? null;
@endphp

<div class="row">
    <div class="col-md-4 form-group">
        <label>SIM Card Number <span class="text-danger">*</span></label>
        <input type="text" name="sim_number" class="form-control" value="{{ old('sim_number', $s?->sim_number) }}" required>
        @error('sim_number') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 form-group">
        <label>ISP Provider <span class="text-danger">*</span></label>
        <input type="text" name="sim_provider" class="form-control" list="providerList"
               value="{{ old('sim_provider', $s?->sim_provider) }}" placeholder="ETISALAT or DU" required>
        <datalist id="providerList">
            <option value="ETISALAT">
            <option value="DU">
        </datalist>
        @error('sim_provider') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 form-group">
        <label>Owner / Account Name</label>
        <input type="text" name="account_name" class="form-control" value="{{ old('account_name', $s?->account_name) }}"
               placeholder="e.g. Eng. Saqer, Orion">
        <small class="form-text text-muted">Who the line is registered to with the provider.</small>
    </div>
</div>

<div class="row">
    <div class="col-md-4 form-group">
        <label>SIM S/N</label>
        <input type="text" name="sim_serial" class="form-control" value="{{ old('sim_serial', $s?->sim_serial) }}"
               placeholder="e.g. 8997112212769842898">
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
        <input type="text" name="account_site" class="form-control" value="{{ old('account_site', $s?->account_site) }}"
               placeholder="e.g. MAIN OFFICE, RAK273-60WAREHOUSES, ENG. FADI">
        <small class="form-text text-muted">Where the line was delivered. Free text.</small>
    </div>
    <div class="col-md-4 form-group">
        <label>Remark</label>
        <input type="text" name="remark" class="form-control" value="{{ old('remark', $s?->remark) }}"
               placeholder="e.g. CAMERA SYS, STOCK, WAS 246">
    </div>
    <div class="col-md-4 form-group">
        <label class="d-block">SIM Status</label>
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
