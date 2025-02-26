<div>
    <div class="row mb-4">
        <div class="col-12">

            @foreach($items as $index => $item)
            <div class="request-item border p-3 mb-3">
                <div class="form-row">
                    <div class="col-md-12 d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-danger btn-sm" wire:click="removeItem({{$index}})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Item Type</label>
                        <select wire:model="items.{{$index}}.item_type" class="form-control custom-select form-control custom-select-md">
                            <option value="Laptop">Laptop</option>
                            <option value="Other">Sim Card</option>
                            <option value="Pc">Pc</option>
                            <option value="Screen">Screen</option>
                            <option value="PC_Element">PC Element</option>
                            <option value="Switch">Switch</option>
                            <option value="Printer">Printer</option>
                            <option value="Electric_Element">Electric Element</option>
                            <option value="Other">Other</option>
                        </select>
                        @error("items.{$index}.item_type") <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label>Quantity</label>
                        <input type="number" wire:model="items.{{$index}}.quantity" class="form-control">
                        @error("items.{$index}.quantity") <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label>For</label>
                        <select wire:model="items.{{$index}}.request_for_type" class="form-control custom-select form-control custom-select-md">
                            <option value="employee">Employee</option>
                            <option value="client">Client</option>
                            <option value="consultant">Consultant</option>
                            <option value="project">Project</option>
                            <option value="other">Other</option>
                        </select>
                        {{-- <input type="text"  class="form-control"> --}}
                        @error("items.{$index}.request_for_type") <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label>Employee ID</label>
                        <input type="text" wire:model="items.{{$index}}.requested_for_id" class="form-control">
                        @error("items.{$index}.requested_for_id") <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>Receiver Name</label>
                        <input type="text" wire:model="items.{{$index}}.requested_for_name" class="form-control">
                        @error("items.{$index}.requested_for_name") <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>Receiver Position</label>
                        <input type="text" wire:model="items.{{$index}}.requested_for_position" class="form-control">
                        @error("items.{$index}.requested_for_position") <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label>Description</label>
                        <textarea wire:model="items.{{$index}}.notes" class="form-control" rows="2"></textarea>
                    </div>

                </div>
            </div>
            @endforeach

            <button type="button" class="btn btn-info" wire:click="addItem">Add Item</button>
            <button type="button" class="btn btn-primary" wire:click="save">save</button>
        </div>
    </div>
</div>
