{{-- Shared by create and edit. $router and $sim are null when adding.
     One screen per line on the site internet sheet: the router, and the SIM
     fitted in it. --}}
@php
    $r = $router ?? null;
    $s = $sim ?? null;
@endphp

<h5 class="hk-sec-title mb-15">Router</h5>
<div class="row">
    <div class="col-md-4 form-group">
        <label>Router Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $r?->name) }}" required>
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 form-group">
        <label>Brand</label>
        <input type="text" name="brand" class="form-control" value="{{ old('brand', $r?->brand) }}" placeholder="e.g. Huawei">
    </div>
    <div class="col-md-4 form-group">
        <label>Model</label>
        <input type="text" name="model" class="form-control" value="{{ old('model', $r?->model) }}">
    </div>
</div>

<div class="row">
    <div class="col-md-4 form-group">
        <label>Router S/N</label>
        <input type="text" name="serial_number" class="form-control" value="{{ old('serial_number', $r?->serial_number) }}">
        <small class="form-text text-muted">Shown as "Router S/N" on the SIM report.</small>
    </div>
    <div class="col-md-4 form-group">
        <label>ISP Provider</label>
        <input type="text" name="isp_provider" class="form-control" list="ispList"
               value="{{ old('isp_provider', $r?->isp_provider) }}" placeholder="ETISALAT or DU">
        <datalist id="ispList">
            <option value="ETISALAT">
            <option value="DU">
        </datalist>
        <small class="form-text text-muted">Also used as the SIM's provider.</small>
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
    <div class="col-md-8 form-group">
        <label>Account Site</label>
        <input type="text" name="account_site" class="form-control" value="{{ old('account_site', $r?->account_site) }}"
               placeholder="e.g. MAIN OFFICE, RAK273-60WAREHOUSES, ENG. FADI, ATEIA HOME">
        <small class="form-text text-muted">Where it was delivered. Free text &mdash; a person, a site, an office or a store. Shown as "Account Site" on the report.</small>
    </div>
    <div class="col-md-4 form-group">
        <label>Image</label>
        <input type="file" name="main_image" class="form-control" accept="image/*">
        @if($r && $r->main_image && $r->main_image !== 'default_device.png')
        <small class="form-text text-muted">Choose a file to replace the current image.</small>
        @endif
    </div>
</div>

<hr>
<h5 class="hk-sec-title mb-5">SIM Card</h5>
<p class="text-muted mb-15">
    <small>
        The internet line fitted in this router. Leave blank if there is no SIM yet &mdash; you can add it later.
        @if($s)
            Editing here updates the line already recorded against this router.
        @endif
    </small>
</p>

<div class="row">
    <div class="col-md-4 form-group">
        <label>SIM Card Number</label>
        <input type="text" name="sim_number" class="form-control" value="{{ old('sim_number', $s?->sim_number) }}"
               placeholder="e.g. 548888223">
    </div>
    <div class="col-md-4 form-group">
        <label>SIM S/N</label>
        <input type="text" name="sim_serial" class="form-control" value="{{ old('sim_serial', $s?->sim_serial) }}"
               placeholder="e.g. 8997112212769842898">
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
        <label>Contract No</label>
        <input type="text" name="contract_no" class="form-control" value="{{ old('contract_no', $s?->contract_no) }}"
               placeholder="e.g. 36732602/68090131">
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
    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $r?->notes) }}</textarea>
</div>
