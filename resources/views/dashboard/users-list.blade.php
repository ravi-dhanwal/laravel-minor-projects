<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Users</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background: #f0f2ff; min-height: 100vh; display: flex; }

    /* SIDEBAR */
    .sidebar {
        width: 240px;
        min-height: 100vh;
        background: linear-gradient(160deg, #667eea 0%, #764ba2 100%);
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0; left: 0; bottom: 0;
        z-index: 100;
        overflow: hidden;
    }

    .sidebar .deco { position: absolute; border-radius: 50%; background: rgba(255,255,255,0.07); }
    .sidebar .deco.d1 { width: 180px; height: 180px; top: -50px; right: -50px; }
    .sidebar .deco.d2 { width: 120px; height: 120px; bottom: 80px; left: -40px; }

    .sidebar-brand {
        padding: 28px 24px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid rgba(255,255,255,0.15);
        z-index: 1;
    }

    .sidebar-brand .icon {
        width: 40px; height: 40px;
        background: rgba(255,255,255,0.2);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
        border: 1px solid rgba(255,255,255,0.3);
    }

    .sidebar-brand span { color: #fff; font-size: 18px; font-weight: 700; }

    .sidebar-nav { padding: 24px 16px; flex: 1; z-index: 1; }

    .nav-label {
        color: rgba(255,255,255,0.45);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        padding: 0 8px;
        margin-bottom: 8px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 14px;
        border-radius: 10px;
        color: rgba(255,255,255,0.75);
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: 0.2s;
        margin-bottom: 4px;
        text-decoration: none;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        font-family: 'Inter', sans-serif;
    }

    .nav-item:hover { background: rgba(255,255,255,0.12); color: #fff; }
    .nav-item.active { background: rgba(255,255,255,0.2); color: #fff; }
    .nav-item .nav-icon { font-size: 17px; width: 20px; text-align: center; }

    .sidebar-user {
        padding: 18px 20px;
        border-top: 1px solid rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 1;
    }

    .user-avatar {
        width: 38px; height: 38px;
        background: rgba(255,255,255,0.25);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; font-weight: 700; color: #fff;
        flex-shrink: 0;
        border: 2px solid rgba(255,255,255,0.3);
        overflow: hidden;
    }
    .user-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }

    .user-meta .uname { color: #fff; font-size: 13px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .user-meta .urole { color: rgba(255,255,255,0.55); font-size: 11px; text-transform: capitalize; }

    /* MAIN */
    .main-content { margin-left: 240px; flex: 1; padding: 32px 36px; min-height: 100vh; }

    .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
    .topbar h2 { font-size: 22px; font-weight: 700; color: #1a1a2e; }
    .topbar .date { font-size: 13px; color: #999; margin-top: 2px; }

    .logout-btn {
        display: flex; align-items: center; gap: 8px;
        background: #fff;
        border: 1.5px solid #e2e6f0;
        color: #555;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px; font-weight: 500;
        font-family: 'Inter', sans-serif;
        cursor: pointer; transition: 0.2s;
    }
    .logout-btn:hover { border-color: #667eea; color: #667eea; }

    .card {
        background: #fff; border-radius: 16px; padding: 24px;
        box-shadow: 0 2px 12px rgba(102,126,234,0.08);
        border: 1px solid rgba(102,126,234,0.07);
    }

    /* USERS TABLE */
    .users-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
    .users-header h3 { font-size: 16px; font-weight: 700; color: #1a1a2e; }
    .users-count { font-size: 12px; color: #999; margin-top: 2px; }

    .search-box {
        display: flex; align-items: center; gap: 8px;
        background: #fff; border: 1.5px solid #e2e6f0;
        border-radius: 10px; padding: 8px 14px;
        font-size: 13px; color: #555; transition: 0.2s;
    }
    .search-box:focus-within { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
    .search-box input { border: none; outline: none; font-family: 'Inter', sans-serif; font-size: 13px; color: #333; width: 180px; background: transparent; }

    .users-table-wrap { overflow-x: auto; border-radius: 16px; box-shadow: 0 2px 12px rgba(102,126,234,0.08); border: 1px solid rgba(102,126,234,0.07); }

    .users-table { width: 100%; border-collapse: collapse; background: #fff; font-size: 13px; }
    .users-table thead { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .users-table thead th { color: #fff; font-weight: 600; padding: 14px 18px; text-align: left; white-space: nowrap; font-size: 12px; letter-spacing: 0.3px; }

    .users-table tbody tr { border-bottom: 1px solid #f0f2ff; transition: 0.15s; }
    .users-table tbody tr:last-child { border-bottom: none; }
    .users-table tbody tr:hover { background: #f8f9ff; }
    .users-table td { padding: 14px 18px; color: #444; vertical-align: middle; }

    .user-cell { display: flex; align-items: center; gap: 10px; }
    .user-cell .avatar {
        width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 13px; font-weight: 700;
        overflow: hidden;
    }
    .user-cell .avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .user-cell .uinfo .uname { font-weight: 600; color: #1a1a2e; font-size: 13px; }
    .user-cell .uinfo .uemail { font-size: 11px; color: #999; }

    .pill { display: inline-block; padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .pill.admin  { background: linear-gradient(135deg,#667eea,#764ba2); color: #fff; }
    .pill.user   { background: rgba(66,153,225,0.12); color: #2b6cb0; }
    .pill.active { background: rgba(72,187,120,0.12); color: #276749; }

    .empty-state { text-align: center; padding: 48px 20px; color: #bbb; font-size: 14px; }

    /* Hamburger button — hidden on desktop */
    .hamburger {
        display: none;
        flex-direction: column; justify-content: center;
        gap: 5px; cursor: pointer;
        background: none; border: none; padding: 6px;
        border-radius: 8px; transition: 0.2s;
    }
    .hamburger span {
        display: block; width: 22px; height: 2px;
        background: #555; border-radius: 2px; transition: 0.3s;
    }
    .hamburger:hover span { background: #667eea; }

    /* Overlay behind sidebar on mobile */
    .sidebar-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 99;
    }
    .sidebar-overlay.visible { display: block; }

    @media (max-width: 900px) {
        .sidebar { width: 70px; }
        .sidebar-brand span, .nav-item span, .nav-label, .user-meta { display: none; }
        .sidebar-brand { justify-content: center; padding: 20px 10px; }
        .nav-item { justify-content: center; padding: 12px; }
        .sidebar-user { justify-content: center; padding: 14px 10px; }
        .main-content { margin-left: 70px; padding: 24px 20px; }
    }

    @media (max-width: 600px) {
        .sidebar {
            width: 240px;
            transform: translateX(-100%);
            transition: transform 0.28s ease;
        }
        .sidebar.open { transform: translateX(0); }
        .sidebar.open .sidebar-brand span,
        .sidebar.open .nav-item span,
        .sidebar.open .nav-label,
        .sidebar.open .user-meta { display: block; }
        .sidebar.open .sidebar-brand { justify-content: flex-start; padding: 28px 24px 20px; }
        .sidebar.open .nav-item { justify-content: flex-start; padding: 11px 14px; }
        .sidebar.open .sidebar-user { justify-content: flex-start; padding: 18px 20px; }

        .main-content { margin-left: 0; padding: 16px 14px; padding-top: 70px; }

        .topbar {
            position: fixed; top: 0; left: 0; right: 0;
            background: #f0f2ff; z-index: 98;
            padding: 12px 16px; margin-bottom: 0;
            border-bottom: 1px solid #e2e6f0;
        }
        .topbar h2 { font-size: 17px; }
        .topbar .date { font-size: 11px; }
        .hamburger { display: flex; }
        .logout-btn span { display: none; }
        .logout-btn { padding: 8px 12px; }

        .search-box input { width: 120px; }
        .users-table thead th, .users-table td { padding: 12px 12px; }
    }
</style>
</head>
<body>

<div class="sidebar-overlay" id="sidebar-overlay"></div>

<!-- Sidebar -->
@include('partials.sidebar')

<!-- Main Content -->
<div class="main-content">

    <!-- Top Bar -->
    <div class="topbar">
        <div style="display:flex; align-items:center; gap:12px;">
            <button class="hamburger" id="hamburger-btn" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
            <div>
                <h2>Users</h2>
                <div class="date">{{ now()->format('l, d M Y') }}</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">&#128275; <span>Logout</span></button>
        </form>
    </div>

    @if(session('success'))
    <div class="card" style="padding: 14px 20px; margin-bottom: 20px; background: rgba(72,187,120,0.1); border-color: rgba(72,187,120,0.2); color: #276749; font-size: 13px; font-weight: 600;">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="card" style="padding: 14px 20px; margin-bottom: 20px; background: rgba(245,101,101,0.08); border-color: rgba(245,101,101,0.2); color: #c53030; font-size: 13px; font-weight: 600;">
        {{ $errors->first() }}
    </div>
    @endif

    <div class="card" style="padding: 24px;">
        <div class="users-header">
            <div>
                <h3>&#128101; All Users</h3>
                <div class="users-count">{{ $users->count() }} registered user(s)</div>
            </div>
            <div class="search-box">
                <span>&#128269;</span>
                <input type="text" id="user-search" placeholder="Search by name or email...">
            </div>
        </div>

        <div class="users-table-wrap">
            <table class="users-table" id="users-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>2FA</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr>
                        <td style="color:#bbb; font-size:12px;">{{ $loop->iteration }}</td>
                        <td>
                            <div class="user-cell">
                                <div class="avatar">
                                    @if($u->profile_photo)
                                        <img src="{{ asset('storage/profile_photos/' . $u->profile_photo) }}" alt="{{ $u->name }}">
                                    @else
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="uinfo">
                                    <div class="uname">
                                        {{ $u->name }}
                                        @if($u->id === Auth::id())
                                            <span style="font-size:10px; color:#667eea; font-weight:600;">(You)</span>
                                        @endif
                                    </div>
                                    <div class="uemail">{{ $u->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="pill {{ $u->role }}">{{ ucfirst($u->role) }}</span></td>
                        <td>
                            @if($u->is_active)
                                <span class="pill active">Active</span>
                            @else
                                <span class="pill" style="background:#fff5f5; color:#c53030;">Inactive</span>
                            @endif
                        </td>
                        <td>
                            @if($u->two_fa_is_active)
                                <span class="pill active">&#10003; On</span>
                            @else
                                <span class="pill" style="background:#fff5f5; color:#c53030;">&#10005; Off</span>
                            @endif
                        </td>
                        <td style="color:#888; font-size:12px; white-space:nowrap;">{{ $u->created_at->format('d M Y') }}</td>
                        <td>
                            <div style="display:flex; gap:6px; align-items:center;">
                                <a href="{{ route('users.show', $u->id) }}" class="pill" style="background: rgba(102,126,234,0.1); color:#553c9a; text-decoration:none;">View</a>
                                @if($u->id !== Auth::id())
                                <form action="{{ route('users.toggle-status', $u->id) }}" method="POST" onsubmit="return confirm('{{ $u->is_active ? 'Deactivate' : 'Activate' }} this user?');">
                                    @csrf
                                    @if($u->is_active)
                                        <button type="submit" class="pill" style="background:#fff5f5; color:#c53030; border:none; cursor:pointer; font-family:'Inter', sans-serif;">Deactivate</button>
                                    @else
                                        <button type="submit" class="pill active" style="border:none; cursor:pointer; font-family:'Inter', sans-serif;">Activate</button>
                                    @endif
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7"><div class="empty-state">No users found.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    // User search
    document.getElementById('user-search')?.addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#users-table tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    });

    // Hamburger / sidebar toggle
    const sidebar      = document.getElementById('sidebar');
    const overlay      = document.getElementById('sidebar-overlay');
    const hamburgerBtn = document.getElementById('hamburger-btn');

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('visible');
    }

    hamburgerBtn?.addEventListener('click', () => {
        const isOpen = sidebar.classList.toggle('open');
        overlay.classList.toggle('visible', isOpen);
    });

    overlay.addEventListener('click', closeSidebar);
</script>

</body>
</html>
