@php $supplier = $supplier ?? null; @endphp

<div class="row">
    <div class="col-md-6 form-group">
        <label>Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $supplier->name ?? '') }}" required>
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 form-group">
        <label>TRN Number</label>
        <input type="text" name="trn_number" class="form-control" value="{{ old('trn_number', $supplier->trn_number ?? '') }}">
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label>Responsible Mobile</label>
        <input type="text" name="responsible_mobile" class="form-control" value="{{ old('responsible_mobile', $supplier->responsible_mobile ?? '') }}">
    </div>
    <div class="col-md-6 form-group">
        <label>Responsible Email</label>
        <input type="email" name="responsible_email" class="form-control" value="{{ old('responsible_email', $supplier->responsible_email ?? '') }}">
        @error('responsible_email') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label>Global Email</label>
        <input type="email" name="global_email" class="form-control" value="{{ old('global_email', $supplier->global_email ?? '') }}">
        @error('global_email') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
</div>
<div class="form-group">
    <label>Notes</label>
    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $supplier->notes ?? '') }}</textarea>
</div>
