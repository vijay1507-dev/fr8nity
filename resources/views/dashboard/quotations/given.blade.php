@extends('layouts.dashboard')
  
@section('title', 'Given Quotations')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Given Quotations</h4>
            <a href="{{ route('member.quotations.create', ['type' => 'given']) }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add enquiries given offline
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Receiver</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Port of Loading</th>
                        <th>Port of Discharge</th>
                        <th>Specifications</th>
                        <th>Status</th>
                        <th>Created At</th>
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
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            autoWidth: false,
            ajax: "{{ route('member.quotations.given') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'receiver', name: 'receiver'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                {data: 'port_of_loading', name: 'port_of_loading'},
                {data: 'port_of_discharge', name: 'port_of_discharge'},
                {data: 'specifications', name: 'specifications'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ],
        });
        table.columns.adjust();
    });
</script>
@endsection
