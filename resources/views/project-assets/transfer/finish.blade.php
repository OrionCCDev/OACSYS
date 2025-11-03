@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Complete Transfer - {{ $transfer->transfer_code }}</h2>
                <p>From: {{ $transfer->fromProject->project_name }} → To: {{ $transfer->toProject->project_name }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Assets to be Transferred</h5>

                    <!-- Devices -->
                    @php
                        $devices = $allTransfers->filter(function($t) { return $t->device_id != null; });
                        $simCards = $allTransfers->filter(function($t) { return $t->sim_card_id != null; });
                    @endphp

                    @if($devices->count() > 0)
                    <h6 class="mt-3">Devices</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Device Name</th>
                                    <th>Device Code</th>
                                    <th>Type</th>
                                    <th>Transfer Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($devices as $transferRecord)
                                <tr>
                                    <td>{{ $transferRecord->device->device_name }}</td>
                                    <td>{{ $transferRecord->device->device_code }}</td>
                                    <td>{{ $transferRecord->device->device_type }}</td>
                                    <td>{{ $transferRecord->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <!-- SIM Cards -->
                    @if($simCards->count() > 0)
                    <h6 class="mt-3">SIM Cards</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>SIM Number</th>
                                    <th>Provider</th>
                                    <th>Plan</th>
                                    <th>Transfer Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($simCards as $transferRecord)
                                <tr>
                                    <td>{{ $transferRecord->simCard->sim_number }}</td>
                                    <td>{{ $transferRecord->simCard->sim_provider }}</td>
                                    <td>{{ $transferRecord->simCard->sim_plan }}</td>
                                    <td>{{ $transferRecord->notes ?? '-' }}</td>
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
                                <div class="card-header bg-warning text-white">
                                    <h5 class="mb-0">Upload Transfer Signature</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('project-assets.transfer.complete', $transfer->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label for="transfer_signature">Signature Image <span class="text-danger">*</span></label>
                                            <input type="file" name="transfer_signature" id="transfer_signature" class="form-control @error('transfer_signature') is-invalid @enderror" accept="image/*" required>
                                            @error('transfer_signature')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Upload the signed transfer document (JPG, PNG, SVG - Max 2MB)</small>
                                        </div>

                                        <div class="form-group">
                                            <img id="signature-preview" src="" alt="Signature Preview" style="display:none; max-width: 100%; max-height: 300px; border: 1px solid #ddd; padding: 10px; margin-top: 10px;">
                                        </div>

                                        <div class="text-right mt-3">
                                            <a href="{{ route('project-assets.show', $transfer->from_project_id) }}" class="btn btn-secondary">Cancel</a>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fa fa-check"></i> Complete Transfer
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
    document.getElementById('transfer_signature').addEventListener('change', function(e) {
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
