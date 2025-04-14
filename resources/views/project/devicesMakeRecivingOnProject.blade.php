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
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Project Device Management</h2>
                <p>Manage devices that are pending for project: <strong>{{ $project->project_name }}</strong></p>
            </div>
        </div>

        <!-- Title -->
        <div class="hk-pg">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hk-row">
                        <div class="col-sm-12">
                            <section class="hk-sec-wrapper">
                                <h5 class="hk-sec-title">Project Pending Devices</h5>
                                <p class="mb-25">You can manage all devices assigned to this project with status "pending-project-device"</p>

                                @livewire('project-devices', ['projectId' => $project->id])

                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
