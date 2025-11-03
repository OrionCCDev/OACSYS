@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Complete Receive - {{ $receive->code }}</h2>
                <p>Project: {{ $receive->project->project_name }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Assets to be Received</h5>

                    <!-- Devices -->
                    @if($deviceRecords->count() > 0)
                    <h6 class="mt-3">Devices</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Device Name</th>
                                    <th>Device Code</th>
                                    <th>Type</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deviceRecords as $record)
                                <tr>
                                    <td>{{ $record->device->device_name }}</td>
                                    <td>{{ $record->device->device_code }}</td>
                                    <td>{{ $record->device->device_type }}</td>
                                    <td>{{ $record->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <!-- SIM Cards -->
                    @if($simRecords->count() > 0)
                    <h6 class="mt-3">SIM Cards</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>SIM Number</th>
                                    <th>Provider</th>
                                    <th>Plan</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($simRecords as $record)
                                <tr>
                                    <td>{{ $record->simCard->sim_number }}</td>
                                    <td>{{ $record->simCard->sim_provider }}</td>
                                    <td>{{ $record->simCard->sim_plan }}</td>
                                    <td>{{ $record->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <!-- Signature Upload -->
                    <div class="row mt-4">
                        <div class="col-md-8 offset-md-2">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Upload Receiving Signature</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('project-assets.receive.complete', $receive->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label for="receiving_signature">Signature Image <span class="text-danger">*</span></label>
                                            <input type="file" name="receiving_signature" id="receiving_signature" class="form-control @error('receiving_signature') is-invalid @enderror" accept="image/*" required>
                                            @error('receiving_signature')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Upload the signed receiving document (JPG, PNG, SVG - Max 2MB)</small>
                                        </div>

                                        <div class="form-group">
                                            <img id="signature-preview" src="" alt="Signature Preview" style="display:none; max-width: 100%; max-height: 300px; border: 1px solid #ddd; padding: 10px; margin-top: 10px;">
                                        </div>

                                        <div class="text-right mt-3">
                                            <a href="{{ route('project-assets.show', $receive->project_id) }}" class="btn btn-secondary">Cancel</a>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-check"></i> Complete Receive
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('receiving_signature').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('signature-preview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
