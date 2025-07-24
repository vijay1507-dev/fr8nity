@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Members</h4>
            <a href="{{ route('members.add') }}" class="btn btn-primary">Add Member</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
/* Toastr customization */
.toast-success {
    background-color: #51A351 !important;
}
#toast-container > .toast-success {
    background-image: none !important;
}
#toast-container > div {
    padding: 15px 15px 15px 15px;
    width: 300px;
    opacity: 1;
    border-radius: 4px;
}
</style>

<script type="text/javascript">
// Configure toastr options
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

// Show success message if exists in session storage
document.addEventListener('DOMContentLoaded', function() {
    const successMessage = sessionStorage.getItem('successMessage');
    if (successMessage) {
        toastr.success(successMessage);
        sessionStorage.removeItem('successMessage');
    }

    // Show Laravel flash message if exists
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif
});

// Initialize DataTable
window.addEventListener('load', function() {
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.DataTable !== 'undefined') {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('members.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {
                    data: 'status', 
                    name: 'status',
                },
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ]
        });
    } else {
        console.error('Required libraries not loaded');
    }
});
</script>
@endsection