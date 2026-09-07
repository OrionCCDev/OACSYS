@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Add Supplier</h2>
            </div>
        </div>
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <form action="{{ route('supplier.store') }}" method="POST">
                            @csrf
                            @include('suppliers._form')
                            <button type="submit" class="btn btn-primary">Add Supplier</button>
                            <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
