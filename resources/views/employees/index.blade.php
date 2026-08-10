@extends('layouts.app')

@section('sweetalert')
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true
    });
    @if(session('success'))
        Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
    @endif
    @if(session('error'))
        Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
    @endif
</script>
@endsection

@section('content')
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Employees Management</h2>
                {{-- <p>Questions about onboarding lead data? <a href="#">Learn more.</a></p> --}}
            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            @livewire('employee-table')
            
        </div>
    </div>
</div>
@endsection
