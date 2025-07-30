<nav class="navbar navbar-expand px-3">
    <button class="btn" id="sidebar-toggle" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse navbar">
        <ul class="navbar-nav">
            <li class="nav-item dropdown ms-3">
                <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                    @php
                        $user = auth()->user();
                    @endphp
                    @if($user->profile_photo)
                    <img src="{{ Storage::url($user->profile_photo) }}" alt="Profile Photo" class="avatar img-fluid rounded">
                    @else
                    <img src="{{ asset('images/men-avtar.png') }}" alt="Default Profile" class="avatar img-fluid rounded">
                    @endif
                    <span class="ms-2">{{ $user ? $user->name : 'User' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{ route('profile') }}" class="dropdown-item">Profile</a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                        @csrf
                    </form>
                    <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>