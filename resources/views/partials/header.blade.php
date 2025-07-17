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
        <ul class="header_nav d-flex align-items-center w-100 justify-content-between flex-wrap">
          <div class="navbar-nav d-flex flex-row flex-wrap align-items-center">
            <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="nav-link active" href="/">Home</a>
            </li>
            <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="nav-link" href="/about">About Us</a>
            </li>

            <!-- Membership Dropdown -->
            <li class="nav-item dropdown d-flex justify-content-center align-items-center">
              <a class="nav-link dropdown-toggle" href="#" id="membershipDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Membership</a>
              <ul class="dropdown-menu" aria-labelledby="membershipDropdown">
                <li><a class="dropdown-item" href="/membership/benefits">Your Benefits</a></li>
                <li><a class="dropdown-item" href="/membership/points">Point System</a></li>
                <li><a class="dropdown-item" href="/membership/faq">FAQ</a></li>
              </ul>
            </li>

            <!-- Events Dropdown -->
            <li class="nav-item dropdown d-flex justify-content-center align-items-center">
              <a class="nav-link dropdown-toggle" href="#" id="eventsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Events</a>
              <ul class="dropdown-menu" aria-labelledby="eventsDropdown">
                <li><a class="dropdown-item" href="/events/calendar">Events Calendar</a></li>
                <li><a class="dropdown-item" href="/events/conference">Conference</a></li>
              </ul>
            </li>
          </div>

          <!-- Logo -->
          <a class="logo" href="/">
            <img src="{{asset('images/navlogo.svg')}}" alt="Nav Logo" />
          </a>

          <div class="navbar-nav d-flex flex-row flex-wrap align-items-center">
            <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="nav-link" href="/spotlight">Spotlight</a>
            </li>
            <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="nav-link" href="/contact">Contact Us</a>
            </li>
            <li class="nav-item d-flex justify-content-center align-items-center">
              <a class="btn btnbg fw-semibold text-dark" href="{{url('login')}}">Login/Register</a>
            </li>
          </div>
        </ul>
      </div>
    </div>
  </nav>
</header>
