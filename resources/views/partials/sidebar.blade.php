<aside class="sidebar" id="sidebar">
    <div class="deco d1"></div>
    <div class="deco d2"></div>

    <div class="sidebar-brand">
        <div class="icon">&#9670;</div>
        <span>MyApp</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Main</div>

        <a href="{{ route('dashboard') }}" class="nav-item" data-section="dashboard">
            <span class="nav-icon">&#9671;</span>
            <span>Dashboard</span>
        </a>

        @can('view users')
        <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <span class="nav-icon">&#128101;</span>
            <span>Users</span>
        </a>
        @endcan

        <a href="{{ route('dashboard') }}#profile" class="nav-item" data-section="profile">
            <span class="nav-icon">&#128100;</span>
            <span>Profile</span>
        </a>

        <a href="{{ route('dashboard') }}#settings" class="nav-item" data-section="settings">
            <span class="nav-icon">&#9881;</span>
            <span>Settings</span>
        </a>

        <div class="nav-label" style="margin-top:20px;">Account</div>

        <a href="{{ route('dashboard') }}#security" class="nav-item" data-section="security">
            <span class="nav-icon">&#128274;</span>
            <span>Security</span>
        </a>

        <a href="{{ route('dashboard') }}#billing" class="nav-item" data-section="billing">
            <span class="nav-icon">&#128179;</span>
            <span>Billing</span>
        </a>
    </nav>

    <div class="sidebar-user">
        <div class="user-avatar" id="sidebar-avatar">
            @if(Auth::user()->profile_photo)
                <img src="{{ asset('storage/profile_photos/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}">
            @else
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            @endif
        </div>
        <div class="user-meta">
            <div class="uname">{{ Auth::user()->name }}</div>
            <div class="urole">{{ Auth::user()->role }}</div>
        </div>
    </div>
</aside>
