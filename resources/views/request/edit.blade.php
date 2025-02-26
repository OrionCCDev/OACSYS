@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header mb-4">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"></span></span>Edit Request</h4>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Edit Request #{{ $request->request_code }}</h5>
            </div>

            <div class="card-body">
                    <!-- Request Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Requester Information</h6>
                            <div class="form-group">
                                <label>Name</label>
                                <h3>{{ $request->employee->name }}</h3>
                            </div>
                            <div class="form-group">
                                <label>Position</label>
                                <h3>{{ $request->employee->position->name }}</h3>
                            </div>
                            <div class="form-group">
                                <label>Department</label>
                                <h3>{{ $request->employee->department->name }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Requested Items -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6>Requested Items</h6>
                            <livewire:request-item-editor :request="$request" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('asset-request.show', $request->id) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addItemBtn = document.getElementById('addItem');
        const itemsContainer = document.getElementById('requestItems');
        let itemCount = {{ count($request->items) }};

        addItemBtn.addEventListener('click', function() {
            const newItem = document.createElement('div');
            newItem.className = 'request-item border p-3 mb-3';
            newItem.innerHTML = `
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Item Type</label>
                        <input type="text" name="items[${itemCount}][item_type]" class="form-control">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Quantity</label>
                        <input type="number" name="items[${itemCount}][quantity]" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label>For</label>
                        <input type="text" name="items[${itemCount}][request_for_type]" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Receiver Name</label>
                        <input type="text" name="items[${itemCount}][requested_for_name]" class="form-control">
                    </div>
                </div>`;
            itemsContainer.appendChild(newItem);
            itemCount++;
        });
    });
</script>
@endpush
@endsection
