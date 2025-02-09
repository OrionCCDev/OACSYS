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
</script>
@endsection
@section('content')
<div class="hk-pg-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 my-80">
                <h1 class="mb-20"> Available Devices </h1>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <livewire:devices-assignment-table project_id="{{ $project->id }}" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
