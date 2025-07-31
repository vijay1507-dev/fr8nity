@extends('layouts.dashboard')
@section('title', 'Shipment Enquiries')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Shipment Enquiries</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Shipment Types</th>
                        <th>Mode of Transport</th>
                        <th>Pickup Location</th>
                        <th>Destination</th>
                        <th>Cargo Ready Date</th>
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
            ajax: "{{ route('shipments.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'shipment_types', name: 'shipment_types'},
                {data: 'mode_of_transport', name: 'mode_of_transport'},
                {data: 'pickup_location', name: 'pickup_location'},
                {data: 'destination_location', name: 'destination_location'},
                {data: 'cargo_ready_date', name: 'cargo_ready_date'},
                {data: 'created_at', name: 'created_at'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false,
                },
            ]
        });
    });
</script>
@endsection 