<header>
  <nav class="navbar navbar-expand-lg navbar-dark blackbg">
    <div class="container">
      <!-- small screen logo -->
      <a class="logo d-inline-block d-lg-none" href="/">
        <img src="{{asset('images/navlogo.svg')}}" alt="Nav Logo" width="60px" />
      </a>

      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
        aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Collapsible content -->
      <div class="collapse navbar-collapse align-items-center" id="mainNavbar">
        <!-- Close button for small screens -->
        <button class="navbar-close d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Close navigation">
          &times;
        </button>
        <ul class="header_nav">
          <div class="navbar-nav d-flex flex-row flex-wrap align-items-center">
            <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
            </li>
            <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="nav-link {{ request()->routeIs('about-us') ? 'active' : '' }}"
                href="{{route('about-us')}}">About Us</a>
            </li>
            <!-- Membership Dropdown -->
            <li class="nav-item dropdown d-flex justify-content-center align-items-center">
              <a class="nav-link dropdown-toggle {{ request()->is('membership*') ? 'active' : '' }}" href="#"
                id="membershipDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Membership</a>
              <ul class="dropdown-menu" aria-labelledby="membershipDropdown">
                <li class="dropdown-submenu">
                  <a class="dropdown-item {{ request()->is('membership/register') ? 'active' : '' }}"
                    href="{{route('register')}}">Freight Member</a>
                  <ul class="dropdown-menu frt_submenu">
                    <li><a class="dropdown-item" href="{{ route('membership.explorer') }}">Explorer</a></li>
                    <li><a class="dropdown-item" href="{{ route('membership.elevate') }}">Elevate</a></li>
                    <li><a class="dropdown-item" href="{{ route('membership.summit') }}">Summit</a></li>
                    <li><a class="dropdown-item" href="{{ route('membership.pinnacle') }}">Pinnacle</a></li>
                  </ul>
                </li>
                <li class="dropdown-submenu">
                  <a class="dropdown-item {{ request()->is('membership/trade-member') ? 'active' : '' }}" href="#">Trade
                    Member</a>
                  <ul class="dropdown-menu frt_submenu">
                    <li><a class="dropdown-item" href="{{route('membership.join-member')}}">Join as Member</a></li>
                    <li><a class="dropdown-item" href="{{route('membership.shipment-enquiry')}}">Submit Shipment
                        Enquiry</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <!-- Events Dropdown -->
            <li class="nav-item dropdown d-flex justify-content-center align-items-center">
              <a class="nav-link dropdown-toggle {{ request()->is('events*') ? 'active' : '' }}" href="#"
                id="eventsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Events</a>
              <ul class="dropdown-menu" aria-labelledby="eventsDropdown">
                <li><a class="dropdown-item {{ request()->is('events/calendar') ? 'active' : '' }}"
                    href="/events/calendar">Events Calendar</a></li>
                <li><a class="dropdown-item {{ request()->is('events/conference') ? 'active' : '' }}"
                    href="/events/conference">Conference</a></li>
              </ul>
            </li>
          </div>

          <!-- Logo -->
          <a class="logo d-none d-lg-inline-block" href="/">
            <img src="{{asset('images/navlogo.svg')}}" alt="Nav Logo" />
          </a>

          <div class="navbar-nav d-flex flex-row flex-wrap align-items-center">
            <!-- Spotlight Dropdown -->
            <li class="nav-item dropdown d-flex justify-content-center align-items-center">
              <a class="nav-link dropdown-toggle {{ request()->is('spotlight*') ? 'active' : '' }}" href="#"
                id="spotlightDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Spotlight</a>
              <ul class="dropdown-menu" aria-labelledby="spotlightDropdown">
                <li><a class="dropdown-item {{ request()->is('spotlight/event-pulse') ? 'active' : '' }}"
                    href="{{route('spotlight.event-pulse')}}">Event Pulse</a></li>
                <li><a class="dropdown-item {{ request()->is('spotlight/partner-showcase') ? 'active' : '' }}"
                    href="{{route('spotlight.partner-showcase')}}">Partner Showcase</a></li>
              </ul>
            </li>
            <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="nav-link {{ request()->is('contact-us') ? 'active' : '' }}"
                href="{{route('contact-us')}}">Contact Us</a>
            </li>
            <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="nav-link {{ request()->is('faq') ? 'active' : '' }}" href="{{route('faq')}}">FAQ</a>
            </li>
            @auth
            <!-- My Account Dropdown for logged-in users -->
            <li class="nav-item dropdown d-flex justify-content-center align-items-center user_dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="accountDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('images/men-avtar.png') }}" alt="User Icon" class="" />
                {{Auth::user()->name}}
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                <li><a class="dropdown-item" href="{{ route('profile') }}">My Profile</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <form method="POST" action="{{ route('logout') }}" class="dropdown-item p-0">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                  </form>
                </li>
              </ul>
            </li>
            @else
            <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="btn btnbg fw-semibold text-dark" href="{{url('login')}}">Login/Register</a>
            </li>
            @endauth
          </div>
        </ul>
      </div>
    </div>
  </nav>
</header>

@push('scripts')
<script>
  document.querySelectorAll('.dropdown-submenu > a').forEach(function(element) {
      element.addEventListener('click', function(e) {
          if (window.innerWidth <= 991) {
              e.preventDefault();
              e.stopPropagation();
              const submenu = this.nextElementSibling;
              // Close other open submenus
              document.querySelectorAll('.dropdown-submenu .dropdown-menu.show').forEach(function(openMenu) {
                  if (openMenu !== submenu) {
                      openMenu.classList.remove('show');
                  }
              });
              // Toggle current submenu
              if (submenu && submenu.classList.contains('dropdown-menu')) {
                  submenu.classList.toggle('show');
              }
          }
      });
  });
  document.addEventListener('click', function(e) {
      if (window.innerWidth <= 991) {
          if (!e.target.closest('.dropdown-submenu')) {
              document.querySelectorAll('.dropdown-submenu .dropdown-menu.show').forEach(function(openMenu) {
                  openMenu.classList.remove('show');
              });
          }
      }
  });
  window.addEventListener('resize', function() {
      if (window.innerWidth > 991) {
          document.querySelectorAll('.dropdown-submenu .dropdown-menu.show').forEach(function(openMenu) {
              openMenu.classList.remove('show');
          });
      }
  });
</script>
@endpush
