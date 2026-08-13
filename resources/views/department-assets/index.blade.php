@extends('layouts.app')

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Department Assets</h2>
                <p>Equipment issued to departments, on the responsibility of the department manager</p>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Department</th>
                                    <th>Manager</th>
                                    <th>Devices</th>
                                    <th>SIM Cards</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($departments as $department)
                                <tr>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ $department->manager->name ?? '—' }}</td>
                                    <td>{{ $department->devices->count() }}</td>
                                    <td>{{ $department->simCards->count() }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('department-assets.show', $department->id) }}" class="btn btn-sm btn-primary" title="View Assets">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if($department->manager)
                                            <a href="{{ route('department-assets.receive.create', $department->id) }}" class="btn btn-sm btn-success" title="Receive Assets">
                                                <i class="fa fa-download"></i>
                                            </a>
                                            <a href="{{ route('department-assets.clearance.create', $department->id) }}" class="btn btn-sm btn-danger" title="Clear Assets">
                                                <i class="fa fa-upload"></i>
                                            </a>
                                            @else
                                            <button type="button" class="btn btn-sm btn-secondary" disabled title="Assign a department manager first">
                                                <i class="fa fa-download"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-secondary" disabled title="Assign a department manager first">
                                                <i class="fa fa-upload"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No departments found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $departments->links() }}
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
