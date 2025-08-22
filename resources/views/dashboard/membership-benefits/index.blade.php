@extends('layouts.dashboard')

@section('title', 'Membership Benefits Management')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Membership Benefits Management</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('membership-tiers.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-layer-group me-2"></i>Manage Tiers
                </a>
                <a href="{{ route('membership-benefits.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Benefit
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Benefit Title</th>
                        <th>Tiers Using</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    // Initialize DataTable
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            autoWidth: false,
            ajax: "{{ route('membership-benefits.index') }}",
            columns: [
                {data: 'sort_order', name: 'sort_order'},
                {data: 'title', name: 'title'},
                {data: 'tiers', name: 'tiers'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        table.columns.adjust();
    });
</script>
@endsection
