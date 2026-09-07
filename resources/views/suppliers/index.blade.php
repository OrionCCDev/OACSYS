@extends('layouts.app')

@section('sweetalert')
<script>
    @if(session('success'))
        const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
        Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Error', text: '{{ session('error') }}' });
    @endif
</script>
@endsection

@section('content')
<div class="hk-pg-wrapper">
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Suppliers</h2>
            </div>
            <div>
                <a href="{{ route('printers.index') }}" class="btn btn-secondary mr-2">Printers Report</a>
                <a href="{{ route('supplier.create') }}" class="btn btn-gradient-primary btn-rounded">Add Supplier</a>
            </div>
        </div>

        <div class="hk-pg">
            <div class="row">
                <div class="col-12">
                    <section class="hk-sec-wrapper">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>TRN Number</th>
                                        <th>Responsible Mobile</th>
                                        <th>Responsible Email</th>
                                        <th>Global Email</th>
                                        <th>Printers</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $supplier->name }}</td>
                                        <td>{{ $supplier->trn_number ?? '-' }}</td>
                                        <td>{{ $supplier->responsible_mobile ?? '-' }}</td>
                                        <td>{{ $supplier->responsible_email ?? '-' }}</td>
                                        <td>{{ $supplier->global_email ?? '-' }}</td>
                                        <td>{{ $supplier->printers_count }}</td>
                                        <td>
                                            <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-info">Edit</a>
                                            <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this supplier?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No suppliers yet.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $suppliers->links() }}
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
