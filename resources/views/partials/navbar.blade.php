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
                        $profileImage =
                            $user && $user->profile_image
                                ? asset("images/{$user->profile_image}")
                                : asset('images/men-avtar.png');
                    @endphp

                    <img src="{{ $profileImage }}" class="avatar img-fluid rounded"
                        alt="{{ $user ? $user->name : 'User Avatar' }}">
                    <span class="ms-2">{{ $user ? $user->name : 'User' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="profile.html" class="dropdown-item">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
