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
            @if(request('country'))
                <div class="alert alert-info mb-3">
                    <strong>Filtered by Country:</strong> {{ $countryName ?? request('country') }}
                    <a href="{{ route('members.index') }}" class="btn btn-sm btn-outline-secondary ms-2">Clear Filter</a>
                </div>
            @endif
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company Name</th>
                        <th>Company Telephone</th>
                        <th>Current Tier</th>
                        <th>Registered At</th>
                        <th>Membership Start At</th>
                        <th>Membership Expires At</th>
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
            ajax: {
                url: "{{ route('members.index') }}",
                data: function (d) {
                    @if(request('country'))
                        d.country = "{{ request('country') }}";
                    @endif
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'company_name', name: 'company_name'},
                {data: 'company_telephone', name: 'company_telephone'},
                {data: 'current_tier', name: 'current_tier'},
                {data: 'created_at', name: 'created_at'},
                {data: 'membership_start_at', name: 'membership_start_at'},
                {data: 'membership_expires_at', name: 'membership_expires_at'},
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
            ],
            "createdRow": function (row, data, dataIndex) {
                // Check if membership expires in 15 days or less
                if (data.membership_expires_at && data.membership_expires_at !== 'N/A') {
                    var expiryDate = new Date(data.membership_expires_at.split('-').reverse().join('-'));
                    var today = new Date();
                    var diffTime = expiryDate.getTime() - today.getTime();
                    var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    
                    if (diffDays <= 15 && diffDays >= 0) {
                        $(row).addClass('expiring-soon');
                        // Add blinking effect only to the expiry date cell
                        $(row).find('td:eq(7)').addClass('expiry-cell blink');
                        // Add a tooltip to show days remaining
                        $(row).attr('title', '⚠️ URGENT: Membership expires in ' + diffDays + ' days');
                        // Add data attribute for easier identification
                        $(row).attr('data-expiry-days', diffDays);
                    } else if (diffDays < 0) {
                        $(row).addClass('expiring-soon');
                        $(row).attr('title', '❌ EXPIRED: Membership expired ' + Math.abs(diffDays) + ' days ago');
                        $(row).attr('data-expiry-days', diffDays);
                    }
                }
            }
            });
            table.columns.adjust();
    });
</script>
@endsection