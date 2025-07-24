<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Dashboard')</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('images/fr8nity_fav.png') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css?v=' . rand(1, 1000000)) }}">
  <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
  <!-- Page-specific scripts -->
  @yield('scripts')
</body>
</html>