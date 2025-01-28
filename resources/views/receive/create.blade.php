@extends('layouts.app')


@section('content')
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Make Receiving</h2>
            </div>
        </div>
        <!-- Title -->
        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title">Receiving</h5>
                        <div class="row">
                            <div class="col-sm">
                                <form method="post" enctype="multipart/form-data" action=""
                                    class="form-inline">
                                    @csrf
                                    <div class="row w-100">
                                        {{-- ---------------- --}}
                                        {{-- employee Orion Image --}}
                                        {{-- ---------------- --}}
                                        @livewire('receiver-type-select')
                                        {{-- ----------------------- --}}
                                        {{-- // END employee Orion Image --}}
                                        {{-- ----------------------- --}}
                                    </div>
                                    {{-- <div class="row mt-30">
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary mb-2">Save</button>
                                        </div>
                                    </div> --}}
                            </div>
                            </form>
                            <script>
                                document.addEventListener('livewire:initialized', () => {
                                    Livewire.on('showToast', () => {
                                        $.toast({
                                            heading: 'Well done!',
                                            text: '<p>You have successfully Add New Department</p>',
                                            position: 'top-right',
                                            loaderBg:'#7a5449',
                                            class: 'jq-toast-primary',
                                            hideAfter: 3500,
                                            stack: 6,
                                            showHideTransition: 'fade'
                                        });
                                    });
                                    Livewire.on('showToastOfUpdate', () => {
                                        $.toast({
                                            heading: 'Well done!',
                                            text: '<p>You have successfully Update Department</p>',
                                            position: 'top-left',
                                            loaderBg:'#7a5449',
                                            class: 'jq-toast-info',
                                            hideAfter: 3500,
                                            stack: 6,
                                            showHideTransition: 'fade'
                                        });
                                    });
                                    });
                            </script>
                        </div>
                </div>
                </section>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
