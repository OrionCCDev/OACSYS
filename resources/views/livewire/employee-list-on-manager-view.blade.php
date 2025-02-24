<div>
    {{-- resources/views/livewire/employee-list.blade.php --}}
<div>
    <div class="profile-card">
        <div class="card-header p-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold">
                My Employees
                <span class="badge badge-success">{{ $employees->total() }}</span>
            </h3>
            <div class="search-box">
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Search by name or ID..."
                    class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <div class="table-container">
            <table class="profile-table">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr wire:key="{{ $employee->id }}">
                            <td>{{ $employee->employee_id }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->position->name }}</td>
                            <td>{{ $employee->department->name }}</td>
                            <td>
                                <a href="{{ route('employees.show' , ['employee' => $employee->id]) }}" class="btn btn-info">
                                    <i class="ion ion-md-eye"></i> View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                @if($search)
                                    No employees found matching "{{ $search }}"
                                @else
                                    No employees found
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $employees->links() }}
        </div>
    </div>

    <style>
        /* Add these styles to your existing CSS */
        .search-box input {
            min-width: 300px;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .pagination > * {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            background: #f9fafb;
            color: #374151;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .pagination .active {
            background: #2563eb;
            color: white;
        }

        .pagination a:hover:not(.active) {
            background: #e5e7eb;
        }

        /* Loading State */
        .opacity-50 {
            opacity: 0.5;
        }

        /* Loading Spinner */
        .spinner {
            width: 1.5rem;
            height: 1.5rem;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #2563eb;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    {{-- Loading States --}}
    <div wire:loading class="fixed top-0 left-0 right-0">
        <div class="bg-blue-500 h-1 animate-pulse"></div>
    </div>
</div>
</div>
