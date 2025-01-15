<!-- Main Content -->
<div class="hk-pg-wrapper">
    <!-- Container -->
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12 pa-0">
                <div class="faq-search-wrap bg-primary">
                    <div class="container">
                        <h1 class="display-5 text-white mb-20">Choose Department To Add Position To</h1>
                        <div class="row">
                            <div class="col-md-6 mb-10">
                                <select wire:model="selectedDepartment" class="form-control form-control-lg custom-select d-block w-100">
                                    <option value="">Choose Department...</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedDepartment')
                                <div class="alert alert-warning" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mb-10">
                                <div class="input-group">
                                    <input wire:model="newPosition"
                                           wire:keydown.enter="addPosition"
                                           class="form-control form-control-lg filled-input bg-white"
                                           placeholder="Position Name"
                                           type="text">
                                    <button wire:click="addPosition" class="input-group-text">
                                        Add
                                    </button>
                                </div>
                                @error('newPosition')
                                <div class="alert alert-warning" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mt-sm-60 mt-30">
                    <div class="hk-row">
                        <div class="col-xl-4" style="max-height:50vh;overflow-y: scroll;">
                            <div class="card">
                                <h6 class="card-header bg-primary text-white">
                                    Departments
                                </h6>
                                <ul class="list-group list-group-flush">
                                    @foreach ($departments as $department )
                                    <li style="cursor: pointer" wire:click='showPositions({{ $department->id }})'
                                        class="list-group-item d-flex align-items-center {{ $defaultPosition == $department->id ? 'active' : '' }}">

                                        <i class="ion ion-md-sunny mr-15"></i>
                                        {{ $department->name }}
                                        <span class="badge badge-light badge-pill ml-15">{{
                                            $department->positions->count() }}</span>

                                    </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                        <livewire:positions-of-department :departmentId="$defaultPosition" :key="$defaultPosition" />
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->


</div>
<!-- /Main Content -->
