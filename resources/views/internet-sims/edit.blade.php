@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Edit Internet SIM &mdash; {{ $sim->sim_number }}</h2>
                <p>{{ $sim->sim_provider }}{{ $sim->account_name ? ' | ' . $sim->account_name : '' }}</p>
            </div>
        </div>
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <form action="{{ route('internet-sims.update', $sim->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            @include('internet-sims._form')
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="{{ route('internet-sims.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>$(document).ready(function() { $('.select2').select2({ placeholder: 'Search...', allowClear: true }); });</script>
@endpush
@endsection
