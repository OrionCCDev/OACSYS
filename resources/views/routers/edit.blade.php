@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Edit Router &mdash; {{ $router->name }}</h2>
            </div>
        </div>
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <form action="{{ route('routers.update', $router->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @include('routers._form')
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="{{ route('routers.show', $router->id) }}" class="btn btn-secondary">Cancel</a>
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
