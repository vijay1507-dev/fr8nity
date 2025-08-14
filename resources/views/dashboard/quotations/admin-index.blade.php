@extends('layouts.dashboard')
  
@section('title', 'All Quotations')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">All Quotations</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Member (Receiver)</th>
                        <th>Company Name</th>
                        <th>Sender Name</th>
                        <th>Sender Email</th>
                        <th>Phone</th>
                        <th>Transaction Value</th>
                        <th>Quotation Status</th>
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
            ajax: "{{ route('admin.quotations.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'member', name: 'member.company_name'},
                {data: 'company_name', name: 'company_name'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'transaction_value', name: 'transaction_value'},
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
    });
</script>
@endsection


