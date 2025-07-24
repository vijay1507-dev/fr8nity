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

<style>
.dropdown-item {
    cursor: pointer;
}
.nav-icon {
    text-decoration: none;
    color: #344767;
    display: flex;
    align-items: center;
}
.nav-icon:hover {
    color: #435ebe;
}
.avatar {
    width: 36px;
    height: 36px;
    object-fit: cover;
}
.dropdown-menu {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border: none;
    padding: 0.5rem 0;
}
.dropdown-item {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}
.dropdown-item:hover {
    background-color: #f8f9fa;
}
</style>
