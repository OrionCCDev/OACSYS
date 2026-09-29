{{--
    "Receiving for New Employee": the button and its popup.

    For a new joiner who is not in the system yet. Asks for the three things
    that can be asked on the spot, and which laptop or PC they are getting.

    The button and the popup are printed separately, because the button sits
    inside a heading and the popup must not:

    @include('receive.partials.new-employee-modal', ['part' => 'button'])
    @include('receive.partials.new-employee-modal', ['part' => 'modal'])   // once, at the end of the page
--}}
@php
    $neBag = $errors->getBag(\App\Http\Controllers\NewEmployeeReceiveController::BAG);
    $neKinds = \App\Http\Controllers\NewEmployeeReceiveController::KINDS;
    $neDevices = \App\Http\Controllers\NewEmployeeReceiveController::availableDevices();
    $neKind = old('item_type', 'laptop');
@endphp

@if(($part ?? 'button') === 'button')
<button type="button" class="btn btn-info btn-rounded ml-2" data-toggle="modal" data-target="#newEmployeeReceiveModal">
    Receiving for New Employee
</button>
@else

<div class="modal fade" id="newEmployeeReceiveModal" tabindex="-1" role="dialog"
     aria-labelledby="newEmployeeReceiveTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('receive.new-employee') }}" autocomplete="off">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="newEmployeeReceiveTitle">Receiving for New Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p class="mb-20" style="font-size:14px;text-transform:none">
                        For somebody who is not in the system yet. They are saved as
                        <strong>not registered yet</strong>, and HR can complete their record later.
                    </p>

                    @if($neBag->any())
                    <div class="alert alert-danger" style="text-transform:none">
                        <ul class="mb-0 pl-3">
                            @foreach($neBag->all() as $message)
                            <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="ne_full_name">Full Name <span class="text-danger">*</span></label>
                            <input type="text" id="ne_full_name" name="full_name" required minlength="3" maxlength="255"
                                   class="form-control {{ $neBag->has('full_name') ? 'is-invalid' : '' }}"
                                   value="{{ old('full_name') }}" placeholder="As on their passport or Emirates ID">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ne_personal_email">Personal Email <span class="text-danger">*</span></label>
                            <input type="email" id="ne_personal_email" name="personal_email" required maxlength="255"
                                   class="form-control {{ $neBag->has('personal_email') ? 'is-invalid' : '' }}"
                                   value="{{ old('personal_email') }}" placeholder="name@example.com">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ne_mobile">Mobile <span class="text-danger">*</span></label>
                            <input type="tel" id="ne_mobile" name="mobile" required maxlength="30"
                                   class="form-control {{ $neBag->has('mobile') ? 'is-invalid' : '' }}"
                                   value="{{ old('mobile') }}" placeholder="05XXXXXXXX">
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label class="d-block">What are they receiving? <span class="text-danger">*</span></label>
                        @foreach($neKinds as $value => $label)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input js-ne-kind" name="item_type"
                                   id="ne_kind_{{ $value }}" value="{{ $value }}" {{ $neKind === $value ? 'checked' : '' }}>
                            <label class="custom-control-label" for="ne_kind_{{ $value }}">
                                {{ $label }}
                                <span class="badge badge-light ml-1">{{ $neDevices->where('kind', $value)->count() }} available</span>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="form-group mb-0">
                        <label for="ne_device_id">Device <span class="text-danger">*</span></label>
                        <input type="search" id="ne_device_search" class="form-control mb-2"
                               placeholder="Type a code, name, model or serial number to narrow the list">
                        <select id="ne_device_id" name="device_id" required size="6"
                                class="form-control {{ $neBag->has('device_id') ? 'is-invalid' : '' }}" style="height:auto">
                            @foreach($neDevices as $device)
                            <option value="{{ $device->id }}" data-kind="{{ $device->kind }}"
                                    {{ (string) old('device_id') === (string) $device->id ? 'selected' : '' }}>
                                {{ $device->device_code }} &mdash; {{ $device->device_name ?: $device->device_type }}{{ $device->device_model ? ' / ' . $device->device_model : '' }}{{ $device->serial_number ? ' / S/N ' . $device->serial_number : '' }}
                            </option>
                            @endforeach
                        </select>
                        <small class="form-text" id="ne_device_none" style="text-transform:none" hidden>
                            None available. Add it under Devices first, or free one up with a clearance.
                        </small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Make Receiving</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var select = document.getElementById('ne_device_id');
        var search = document.getElementById('ne_device_search');
        var none = document.getElementById('ne_device_none');
        var kinds = Array.prototype.slice.call(document.querySelectorAll('.js-ne-kind'));
        if (!select) { return; }

        // Options are taken out of the list rather than hidden: a hidden
        // <option> still shows in some browsers.
        var all = Array.prototype.slice.call(select.options).map(function (option) {
            return { node: option, kind: option.getAttribute('data-kind'), text: option.textContent.toLowerCase() };
        });

        function refresh() {
            var kind = (kinds.filter(function (k) { return k.checked; })[0] || {}).value;
            var term = (search.value || '').trim().toLowerCase();
            var chosen = select.value;

            while (select.firstChild) { select.removeChild(select.firstChild); }
            var shown = 0;
            all.forEach(function (item) {
                if (item.kind === kind && (!term || item.text.indexOf(term) !== -1)) {
                    select.appendChild(item.node);
                    shown++;
                }
            });

            select.value = chosen;
            if (select.selectedIndex === -1 && shown === 1) { select.selectedIndex = 0; }
            none.hidden = shown > 0;
        }

        kinds.forEach(function (k) { k.addEventListener('change', function () { select.value = ''; refresh(); }); });
        search.addEventListener('input', refresh);
        refresh();

        @if($neBag->any())
        // Sent back with something to fix: reopen where they left off.
        if (window.jQuery) { jQuery('#newEmployeeReceiveModal').modal('show'); }
        @endif
    });
</script>
@endif
