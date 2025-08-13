@extends('layouts.dashboard')
@section('title', 'Trade Members')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Trade Members Enquiries</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Email</th>
                        <th>Company Name</th>
                        <th>Product/Industry Category</th>
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
    // Initialize DataTable
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('trade-members.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'designation', name: 'designation'},
                {data: 'email', name: 'email'},
                {data: 'company_name', name: 'company_name'},
                {data: 'product_industry_category', name: 'product_industry_category'},
                {data: 'created_at', name: 'created_at'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false,
                    width: '168px',
                },
            ]
        });
    });
</script>
@endsection