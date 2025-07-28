<!-- Navbar -->
<header>
  <nav class="navbar navbar-expand-lg navbar-dark blackbg">
    <div class="container">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Collapsible content -->
      <div class="collapse navbar-collapse justify-content-center align-items-center" id="mainNavbar">
        <ul class="header_nav">
          <div class="navbar-nav d-flex flex-row flex-wrap align-items-center">
            <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
            </li>
            <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="nav-link {{ request()->routeIs('about-us') ? 'active' : '' }}" href="{{route('about-us')}}">About Us</a>
            </li>
            <!-- Membership Dropdown -->
            <li class="nav-item dropdown d-flex justify-content-center align-items-center">
              <a class="nav-link dropdown-toggle {{ request()->is('membership*') ? 'active' : '' }}" href="#" id="membershipDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Membership</a>
              <ul class="dropdown-menu" aria-labelledby="membershipDropdown">
                <li class="dropdown-submenu">
                  <a class="dropdown-item {{ request()->is('membership/register') ? 'active' : '' }}" href="{{route('register')}}">Freight Member</a>
                  <ul class="dropdown-menu frt_submenu">
                    <li><a class="dropdown-item" href="{{route('register', ['type' => 'freight', 'tier' => 'explorer'])}}">Explorer</a></li>
                    <li><a class="dropdown-item" href="{{route('register', ['type' => 'freight', 'tier' => 'elevate'])}}">Elevate</a></li>
                    <li><a class="dropdown-item" href="{{route('register', ['type' => 'freight', 'tier' => 'summit'])}}">Summit</a></li>
                    <li><a class="dropdown-item" href="{{route('register', ['type' => 'freight', 'tier' => 'founder'])}}">Founder</a></li>
                  </ul>
                </li>
                <li><a class="dropdown-item {{ request()->is('membership/trade-member') ? 'active' : '' }}" href="{{route('membership.trade-member')}}">Trade Member</a></li>
              </ul>
            </li>
            <!-- Events Dropdown -->
            <li class="nav-item dropdown d-flex justify-content-center align-items-center">
              <a class="nav-link dropdown-toggle {{ request()->is('events*') ? 'active' : '' }}" href="#" id="eventsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Events</a>
              <ul class="dropdown-menu" aria-labelledby="eventsDropdown">
                <li><a class="dropdown-item {{ request()->is('events/calendar') ? 'active' : '' }}" href="/events/calendar">Events Calendar</a></li>
                <li><a class="dropdown-item {{ request()->is('events/conference') ? 'active' : '' }}" href="/events/conference">Conference</a></li>
              </ul>
            </li>
          </div>

          <!-- Logo -->
          <a class="logo" href="/">
            <img src="{{asset('images/navlogo.svg')}}" alt="Nav Logo" />
          </a>

          <div class="navbar-nav d-flex flex-row flex-wrap align-items-center">
            <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="nav-link {{ request()->is('spotlight') ? 'active' : '' }}" href="{{route('spotlight')}}">Spotlight</a>
            </li>
            <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="nav-link {{ request()->is('contact-us') ? 'active' : '' }}" href="{{route('contact-us')}}">Contact Us</a>
            </li>
             <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="nav-link {{ request()->is('faq') ? 'active' : '' }}" href="{{route('faq')}}">FAQ</a>
            </li>
            @auth
              <!-- My Account Dropdown for logged-in users -->
              <li class="nav-item dropdown d-flex justify-content-center align-items-center user_dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="{{ asset('images/men-avtar.png') }}" alt="User Icon" class="" />
                  {{Auth::user()->name}}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                  <li><a class="dropdown-item" href="{{ route('profile') }}">My Profile</a></li>
                  <li><hr class="dropdown-divider"></li>
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
