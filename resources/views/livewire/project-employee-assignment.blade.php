<div>
    <div class="form-group">
        <input
        type="text"
        wire:model.live.debounce.300ms="search"
        placeholder="Search by name or employee ID..."
        class="w-full p-2 border rounded"
    >
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>$</th>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Position</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>
                    <input
                    type="checkbox"
                    value="{{ $employee->id }}"
                    wire:model.live="selectedEmployeeIds"
                    class="form-checkbox"
                >

                </td>
                <td>{{ $employee->employee_id }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->department?->name ?? 'not assigned' }}</td>
                <td>{{ $employee->position?->name ?? 'not assigned' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- {{ $employees->links() }} --}}

    <button wire:click="addToProject" class="btn btn-primary"
        @if(empty($selectedEmployeeIds)) disabled @endif>
        Add Selected to Project
    </button>

</div>
