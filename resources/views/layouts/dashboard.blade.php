<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="robots" content="noindex, nofollow">
  <title>@yield('title', 'Dashboard')</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('images/fr8nity_fav.png') }}">
  <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Wix+Madefor+Display:wght@400..800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css?v=' . rand(1, 1000000)) }}">
  @yield('styles')
</head>
<body>
  <div class="wrapper">
    @include('dashboard.partials.sidebar')
    <div class="main">
      @include('dashboard.partials.navbar')
      <div class="content">
        @yield('content')
      </div>
    </div>
  </div>
  <!-- Core scripts -->
  <script src="{{asset('js/bootstrap.js')}}"></script>
  <script src="{{asset('js/script.js')}}" defer></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- member add --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
    {{-- end member add --}}
  <script>
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
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
  <!-- Page-specific scripts -->
  @yield('scripts')
  
  @if(session('warning'))
  <script>
    Swal.fire({
      title: "",
      text: "{{ session('warning')['message'] }}",
      icon: "warning",
      showCancelButton: false,
      confirmButtonColor: "#ffc107",
      confirmButtonText: "Complete Profile Now"
    }).then((result) => {
      if (result.isConfirmed) {
        // The URL is already correct as we're on the edit profile page
        document.getElementById('profile_photo').focus();
      }
    });
  </script>
  @endif
</body>
</html>