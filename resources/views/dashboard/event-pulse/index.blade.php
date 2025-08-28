@extends('layouts.dashboard')

@section('title', 'Event Pulse Management')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Event Pulse Management</h4>
            <a href="{{ route('admin.event-pulse.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Event Pulse
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Created At</th>
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
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            autoWidth: false,
            ajax: "{{ route('admin.event-pulse.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'feature_image_thumb', name: 'feature_image', orderable: false, searchable: false},
                {data: 'title', name: 'title'},
                {data: 'created_at', name: 'created_at'},
                {data: 'status_badge', name: 'status'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ]
        });
        
        table.columns.adjust();
    });
</script>
@endsection