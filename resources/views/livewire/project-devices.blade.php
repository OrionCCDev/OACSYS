<div>
    <div class="row">
        <div class="col-sm-12">
            <!-- Available Devices Section -->
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Available Devices</h5>
                <p class="mb-25">Select from available devices to add to this project</p>

                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap mb-20">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Device ID</th>
                                            <th>Device Name</th>
                                            <th>Device Code</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($this->availableDevices as $device)
                                            <tr wire:key="available-{{ $device->id }}">
                                                <th scope="row">{{ $device->id }}</th>
                                                <td>{{ $device->device_name }}</td>
                                                <td>{{ $device->device_code }}</td>
                                                <td>
                                                    <span class="badge badge-success">Available</span>
                                                </td>
                                                <td class="text-center">
                                                    <button
                                                        wire:click="addDeviceDirectly({{ $device->id }})"
                                                        class="btn btn-sm btn-primary"
                                                        title="Add to Project">
                                                        <i class="icon-plus"></i> Add to Project
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    No available devices found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Devices Table -->
    <div class="row">
        <div class="col-sm-12">
            <div class="table-wrap mb-20">
                <div class="table-responsive">
                    <table class="table table-info table-bordered table-hover mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Device ID</th>
                                <th>Device Name</th>
                                <th>Status</th>
                                <th>Date Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($devices as $projectDevice)

                                <tr wire:key="{{ $projectDevice->id }}">
                                    <th scope="row">{{ $projectDevice->device_code }}</th>
                                    <td>{{ $projectDevice->device_name ?? 'Unknown Device' }}</td>
                                    <td>
                                        <span class="badge badge-warning">Pending</span>
                                    </td>
                                    <td>{{ $projectDevice->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button
                                                wire:click="cancelDevice({{ $projectDevice->id }})"
                                                wire:confirm="Are you sure you want to cancel this device?"
                                                class="btn btn-sm btn-danger"
                                                title="Cancel Device">
                                                <i class="icon-trash"></i> Cancel
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Add this to your existing table just before the @empty check -->
@if(count($devices) > 0)
<tr>
    <td colspan="5" class="text-center bg-light">
        <a href="{{ route('receives.create', ['project_id' => $this->project->id]) }}"
           class="btn btn-primary btn-lg mt-2 mb-2">
            <i class="icon-file-text"></i> Create Receiving Document
        </a>
    </td>
</tr>
@endif

<!-- Rest of your @empty and table content remains the same -->
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        No pending devices found for this project.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Livewire Scripts for Toast Notifications -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('showToastCancel', () => {
                $.toast({
                    heading: 'Device Cancelled',
                    text: '<p>Device has been successfully cancelled</p>',
                    position: 'top-right',
                    loaderBg:'#7a5449',
                    class: 'jq-toast-danger',
                    hideAfter: 3500,
                    stack: 6,
                    showHideTransition: 'fade'
                });
            });

            Livewire.on('showToastAdd', () => {
                $.toast({
                    heading: 'Device Added',
                    text: '<p>New device has been successfully added to the project</p>',
                    position: 'top-right',
                    loaderBg:'#7a5449',
                    class: 'jq-toast-primary',
                    hideAfter: 3500,
                    stack: 6,
                    showHideTransition: 'fade'
                });
            });

            Livewire.on('showToastUpdate', () => {
                $.toast({
                    heading: 'Device Updated',
                    text: '<p>Device status has been updated to pending</p>',
                    position: 'top-right',
                    loaderBg:'#7a5449',
                    class: 'jq-toast-info',
                    hideAfter: 3500,
                    stack: 6,
                    showHideTransition: 'fade'
                });
            });

            Livewire.on('showToastDeviceUpdated', () => {
                $.toast({
                    heading: 'Device Record Updated',
                    text: '<p>Device record has been updated with project assignment</p>',
                    position: 'top-right',
                    loaderBg:'#7a5449',
                    class: 'jq-toast-success',
                    hideAfter: 3500,
                    stack: 6,
                    showHideTransition: 'fade'
                });
            });

            Livewire.on('showToastError', (event) => {
                $.toast({
                    heading: 'Error',
                    text: '<p>' + event.message + '</p>',
                    position: 'top-right',
                    loaderBg:'#7a5449',
                    class: 'jq-toast-danger',
                    hideAfter: 3500,
                    stack: 6,
                    showHideTransition: 'fade'
                });
            });
        });
    </script>
</div>
