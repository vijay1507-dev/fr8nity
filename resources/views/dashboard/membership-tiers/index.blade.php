@extends('layouts.dashboard')

@section('title', 'Membership Tiers Management')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Membership Tiers Management</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('membership-benefits.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-gift me-2"></i>Manage Benefits
                </a>
                <a href="{{ route('membership-tiers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Tier
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Tier Name</th>
                        <th>Annual Fee</th>
                        <th>Credit Protection</th>
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
            ajax: "{{ route('membership-tiers.index') }}",
            columns: [
                {data: 'order', name: 'order'},
                {data: 'name', name: 'name'},
                {data: 'annual_fee', name: 'annual_fee'},
                {data: 'credit_protection', name: 'credit_protection'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        table.columns.adjust();
    });
</script>
@endsection
