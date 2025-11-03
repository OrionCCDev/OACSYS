<!-- filepath: /d:/orioncc/Orion-Github/OACSYS/resources/views/clearance/select.blade.php -->
@extends('layouts.app')

@section('content')
{{-- @dd($devicesData , $receiver , $receiver_type) --}}
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Devices Make Clearance</h2>
                {{-- <p>Questions about onboarding lead data? <a href="#">Learn more.</a></p> --}}
            </div>
            <div class="hk-pg-header mb-10">
                <div class="container">
                    <h1 class="text-center">Select Devices and SIM Cards for Clearance</h1>
                    <h3 class="text-center">Selected Person: {{ $person->name }}</h3>
                    @if ($type == 'employee')

                        <h3 class="text-center">Selected ID: {{ $person->employee_id }}</h3>
                    @endif


                </div>
            </div>
        </div>
        <!-- Title -->
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">All His Devices & Sims</h5>

            <div class="row">
                <div class="col-sm">
                    <div class="card">
                        <form method="POST" action="{{ route('clearance.selectedDevicesAndSimCardsToMakeClearance') }}">
                            @csrf
                            <input type="hidden" name="person_id" value="{{ $person->id }}">
                            <input type="hidden" name="person_type" value="{{ $type }}">

                            <div class="row">
                                <div class="col-12">

                                    <div class="card-deck row">
                                        @foreach($devices as $device)
                                            <div class="item card mb-3 p-3 col-4" onclick="toggleCheckbox(event)">
                                                <input type="checkbox" name="devices[]" value="{{ $device->id }}" class="device-checkbox" style="position: absolute; opacity: 0; pointer-events: none;">
                                                <img class="card-img-top" src="{{ asset('X-Files/Dash/imgs/devices/' . $device->main_image) }}" alt="Card image cap">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $device->device_name }}</h5>
                                                    <p class="card-text">{{ $device->device_type }}</p>
                                                    <p class="card-text">{{ $device->device_code }}</p>
                                                    <div class="overlay">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-12">

                                    <div class="card-deck row">
                                        @foreach($simCards as $simCard)
                                            <div class="item card mb-3 p-3 col-4" onclick="toggleCheckbox(event)">
                                                <input type="checkbox" name="simCards[]" value="{{ $simCard->id }}" class="simcard-checkbox" style="position: absolute; opacity: 0; pointer-events: none;">
                                                <img class="card-img-top" src="{{ asset('X-Files/Dash/imgs/simcard.png') }}" alt="Card image cap">

                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $simCard->sim_number }}</h5>
                                                    <p class="card-text">{{ $simCard->sim_plan }}</p>
                                                    <div class="overlay">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Make Clearance</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

<script>
    function toggleCheckbox(event) {
        const item = event.currentTarget;
        const checkbox = item.querySelector('input[type="checkbox"]');
        checkbox.checked = !checkbox.checked;
        if (checkbox.checked) {
            item.classList.add('checked');
        } else {
            item.classList.remove('checked');
        }
    }
</script>

<style>
    .item {
        position: relative;
        cursor: pointer;
    }
    .item .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(33, 22, 88, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 2rem;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .item.checked .overlay {
        opacity: 1;
    }
</style>
    </div>
</div>
@endsection
