@extends('layouts.dashboard')
@section('title', 'Freight Members')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Freight Members</h4>
            <a href="{{ route('members.add') }}" class="btn btn-primary">Add Member</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company Name</th>
                        <th>Company Telephone</th>
                        <th>Current Tier</th>
                        <th>Status</th>
                        <th width="100px">Action</th>
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
            ajax: "{{ route('members.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'company_name', name: 'company_name'},
                {data: 'company_telephone', name: 'company_telephone'},
                {data: 'current_tier', name: 'current_tier'},
                {
                    data: 'status', 
                    name: 'status',
                    render: function (data, type, row) {
                        return data.charAt(0).toUpperCase() + data.slice(1);
                    }
                },
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ]
        });
    });
</script>
@endsection