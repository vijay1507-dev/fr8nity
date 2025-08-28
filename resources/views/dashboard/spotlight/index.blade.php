@extends('layouts.dashboard')

@section('title', 'Spotlight Management')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Spotlight Management</h4>
            <a href="{{ route('spotlight.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Spotlight Item
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Order</th>
                        <th>Created By</th>
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
            ajax: "{{ route('spotlight.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'feature_image_thumb', name: 'feature_image', orderable: false, searchable: false},
                {data: 'title', name: 'title'},
                {data: 'type_label', name: 'type'},
                {data: 'order', name: 'order'},
                {data: 'created_by_name', name: 'created_by'},
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

    function deleteSpotlight(id) {
        if (confirm('Are you sure you want to delete this spotlight item?')) {
            $.ajax({
                url: "{{ route('spotlight.destroy', ':id') }}".replace(':id', id),
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('.data-table').DataTable().ajax.reload();
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert('Error deleting spotlight item');
                }
            });
        }
    }
</script>
@endsection
