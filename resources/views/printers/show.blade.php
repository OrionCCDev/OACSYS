@extends('layouts.app')

@section('sweetalert')
<script>
    @if(session('success'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    @endif
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}'
        });
    @endif
</script>
@endsection

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">{{ $device->device_name }}</h2>
                <p>Rental Printer &mdash; {{ $device->device_code }}</p>
            </div>
            <div>
                <a href="{{ route('printers.index') }}" class="btn btn-secondary mr-2">Back to Report</a>
                <a href="{{ route('device.show', $device->id) }}" class="btn btn-info">View in Devices</a>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12 col-md-4">
                    <section class="hk-sec-wrapper text-center">
                        <img src="{{ asset('X-Files/Dash/imgs/devices/' . $device->main_image) }}" alt="" class="img-fluid img-thumbnail mb-20">
                        <table class="table table-sm">
                            <tr><th>Model</th><td>{{ $device->device_model ?? '-' }}</td></tr>
                            <tr><th>Supplier</th><td>{{ $device->supplier_name ?? '-' }}</td></tr>
                            <tr><th>Serial Number</th><td>{{ $device->serial_number ?? '-' }}</td></tr>
                            <tr><th>Rental Start</th><td>{{ $device->rental_start_date?->format('Y-m-d') ?? '-' }}</td></tr>
                            <tr>
                                <th>Current Location</th>
                                <td>
                                    @if($device->currentAssignment)
                                        {{ $device->currentAssignment->locationLabel() }}
                                        <br><small class="text-muted">Since {{ $device->currentAssignment->start_date->format('Y-m-d') }}</small>
                                    @else
                                        <span class="text-muted">Unassigned</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#reassignPrinterModal">
                            Reassign Printer
                        </button>
                    </section>
                </div>

                <div class="col-12 col-md-8">
                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title">Assignment History</h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Location</th>
                                        <th>Type</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Assigned By</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($device->printerAssignments as $assignment)
                                    <tr>
                                        <td>{{ $assignment->locationLabel() }}</td>
                                        <td class="text-capitalize">{{ $assignment->location_type }}</td>
                                        <td>{{ $assignment->start_date->format('Y-m-d') }}</td>
                                        <td>
                                            @if($assignment->end_date)
                                                {{ $assignment->end_date->format('Y-m-d') }}
                                            @else
                                                <span class="badge badge-success">Current</span>
                                            @endif
                                        </td>
                                        <td>{{ $assignment->assignedBy->name ?? '-' }}</td>
                                        <td>{{ $assignment->notes ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No assignment history yet.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reassign Printer Modal -->
<div class="modal fade" id="reassignPrinterModal" tabindex="-1" role="dialog" aria-labelledby="reassignPrinterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('printers.assign', $device->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="reassignPrinterModalLabel">Reassign {{ $device->device_name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Assign To</label>
                        <select name="location_type" id="locationType" class="form-control" required>
                            <option value="project">Project</option>
                            <option value="client">Client</option>
                            <option value="consultant">Consultant</option>
                            <option value="office">Our Office</option>
                        </select>
                    </div>

                    <div class="form-group location-target-group" data-type="project">
                        <label>Project</label>
                        <select name="target_id" class="form-control location-target" required>
                            <option value="">Select Project</option>
                            @foreach($projects as $proj)
                            <option value="{{ $proj->id }}">{{ $proj->project_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group location-target-group" data-type="client" style="display:none">
                        <label>Client</label>
                        <select name="target_id" class="form-control location-target" disabled>
                            <option value="">Select Client</option>
                            @foreach($clientEmployees as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group location-target-group" data-type="consultant" style="display:none">
                        <label>Consultant</label>
                        <select name="target_id" class="form-control location-target" disabled>
                            <option value="">Select Consultant</option>
                            @foreach($consultants as $consultant)
                            <option value="{{ $consultant->id }}">{{ $consultant->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ now()->toDateString() }}" required>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Reassign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('locationType').addEventListener('change', function () {
        const type = this.value;
        document.querySelectorAll('.location-target-group').forEach(function (group) {
            const isMatch = group.dataset.type === type;
            group.style.display = isMatch ? 'block' : 'none';
            const select = group.querySelector('.location-target');
            select.disabled = !isMatch;
            select.required = isMatch;
        });
    });
</script>
@endsection
