<div>
    {{-- resources/views/livewire/request-list.blade.php --}}
<div>
    <div class="table-responsive">
        <table class="table table-sm table-hover mb-0">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th class="text-center">Signature</th>
                    <th class="text-center">Manage</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $req)
                <tr>
                    <td>{{ $req->request_code }}</td>
                    <td>{{ $req->employee->name }}</td>
                    <td>
                        <select wire:change="updateStatus({{ $req->id }}, $event.target.value)" class="form-control form-control-sm">
                            <option value="pending" {{ $req->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $req->status === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $req->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <!-- Your existing signature buttons -->
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button wire:click="showRequest({{ $req->id }})" class="btn btn-sm btn-success">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button wire:click="editRequest({{ $req->id }})" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i>
                            </button>
                            <!-- Your existing delete button -->
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $requests->links() }}
    </div>

    <!-- Show Modal -->
    <div class="modal @if($showModal) show @endif" tabindex="-1" role="dialog" style="display: @if($showModal) block @else none @endif;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Request Details - {{ $request->request_code ?? '' }}</h5>
                    <button type="button" class="close" wire:click="$set('showModal', false)">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($request)
                    <!-- Requester Info -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Requester Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> {{ $request->employee->name }}</p>
                                    <p><strong>Position:</strong> {{ $request->employee->position->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Department:</strong> {{ $request->employee->department->name }}</p>
                                    <p><strong>Status:</strong>
                                        <select wire:model="request.status" class="form-control form-control-sm">
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approved</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Requested Items -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Requested Items</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item Type</th>
                                        <th>Quantity</th>
                                        <th>For</th>
                                        <th>Receiver</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($request->items as $item)
                                    <tr>
                                        <td>{{ $item->item_type }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->request_for_type }}</td>
                                        <td>{{ $item->requested_for_name }}<br>
                                            <small>{{ $item->requested_for_position }}</small>
                                        </td>
                                        <td>{{ $item->notes }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal @if($editModal) show @endif" tabindex="-1" role="dialog" style="display: @if($editModal) block @else none @endif;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Request - {{ $request->request_code ?? '' }}</h5>
                    <button type="button" class="close" wire:click="$set('editModal', false)">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($request)
                    <form wire:submit.prevent="saveRequest">
                        <!-- Add your edit form fields here -->
                        <div class="form-group">
                            <label>Status</label>
                            <select wire:model="request.status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>

                        <!-- Add more edit fields as needed -->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="$set('editModal', false)">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
