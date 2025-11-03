<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Project Assets Management</h2>
                <p>Manage all project assets including devices and SIM cards</p>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <input type="text" wire:model.live="search" class="form-control" placeholder="Search projects...">
                            </div>
                            <div class="col-sm-4">
                                <select wire:model.live="statusFilter" class="form-control">
                                    <option value="all">All Projects</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Project Code</th>
                                        <th>Manager</th>
                                        <th>Client</th>
                                        <th>Devices</th>
                                        <th>SIM Cards</th>
                                        <th>Total Assets</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($projects as $project)
                                    <tr>
                                        <td>{{ $project->project_name }}</td>
                                        <td>{{ $project->project_code }}</td>
                                        <td>{{ $project->manager->name ?? 'N/A' }}</td>
                                        <td>{{ $project->client->name ?? 'N/A' }}</td>
                                        <td><span class="badge badge-info">{{ $project->devices_count }}</span></td>
                                        <td><span class="badge badge-success">{{ $project->sim_cards_count }}</span></td>
                                        <td><span class="badge badge-primary">{{ $project->total_assets_count }}</span></td>
                                        <td>
                                            @if($project->status == 'in-progress')
                                                <span class="badge badge-warning">In Progress</span>
                                            @else
                                                <span class="badge badge-secondary">Completed</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('project-assets.show', $project->id) }}" class="btn btn-sm btn-primary" title="View Assets">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if($project->status == 'in-progress')
                                                <a href="{{ route('project-assets.receive.create', $project->id) }}" class="btn btn-sm btn-success" title="Receive Assets">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <a href="{{ route('project-assets.clearance.create', $project->id) }}" class="btn btn-sm btn-danger" title="Clear Assets">
                                                    <i class="fa fa-upload"></i>
                                                </a>
                                                <a href="{{ route('project-assets.transfer.create', $project->id) }}" class="btn btn-sm btn-warning" title="Transfer Assets">
                                                    <i class="fa fa-exchange"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No projects found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $projects->links() }}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
