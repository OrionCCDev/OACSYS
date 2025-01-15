<div class="form-group">
    <label for="exampleDropdownFormpersonalmobile">Orion mobile</label>
    <select wire:model="selectedSim"  name="orion_number" class="form-control select2">
        <option  @selected(old('orion_number') == '') >Select SIM Card</option>
        @foreach($availableSims as $sim)
            <option value="{{ $sim->id }}" @selected(old('orion_number') == $sim->id)>{{ $sim->sim_number }}</option>
        @endforeach
    </select>
</div>
