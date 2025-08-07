@extends('layouts.dashboard')
  
@section('title', 'My Quotations')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">My Quotations</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Alternate Email</th>
                        <th>Port of Loading</th>
                        <th>Port of Discharge</th>
                        <th>Specifications</th>
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
            ajax: "{{ route('member.quotations.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                {data: 'alternate_email', name: 'alternate_email'},
                {data: 'port_of_loading', name: 'port_of_loading'},
                {data: 'port_of_discharge', name: 'port_of_discharge'},
                {data: 'specifications', name: 'specifications'},
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
