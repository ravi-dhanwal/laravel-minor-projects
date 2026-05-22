<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
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
        padding: 0;
        position: fixed;
        top: 0; left: 0; bottom: 0;
        z-index: 100;
        overflow: hidden;
    }

    .sidebar .deco {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
    }
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

    .sidebar-brand span {
        color: #fff;
        font-size: 18px;
        font-weight: 700;
    }

    .sidebar-nav {
        padding: 24px 16px;
        flex: 1;
        z-index: 1;
    }

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
        font-size: 16px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .user-meta { flex: 1; overflow: hidden; }
    .user-meta .uname { color: #fff; font-size: 13px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .user-meta .urole { color: rgba(255,255,255,0.55); font-size: 11px; text-transform: capitalize; }

    /* MAIN CONTENT */
    .main-content {
        margin-left: 240px;
        flex: 1;
        padding: 32px 36px;
        min-height: 100vh;
    }

    /* TOP BAR */
    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }

    .topbar h2 { font-size: 22px; font-weight: 700; color: #1a1a2e; }
    .topbar .date { font-size: 13px; color: #999; margin-top: 2px; }

    .logout-form form { display: inline; }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1.5px solid #e2e6f0;
        color: #555;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: 0.2s;
    }

    .logout-btn:hover { border-color: #667eea; color: #667eea; }

    /* STATS GRID */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 22px 24px;
        box-shadow: 0 2px 12px rgba(102,126,234,0.08);
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid rgba(102,126,234,0.07);
        transition: 0.2s;
    }

    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(102,126,234,0.15); }

    .stat-icon {
        width: 50px; height: 50px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-icon.purple { background: linear-gradient(135deg, rgba(102,126,234,0.15), rgba(118,75,162,0.1)); }
    .stat-icon.green  { background: rgba(72,187,120,0.12); }
    .stat-icon.blue   { background: rgba(66,153,225,0.12); }
    .stat-icon.orange { background: rgba(237,137,54,0.12); }

    .stat-info h3 { font-size: 18px; font-weight: 700; color: #1a1a2e; }
    .stat-info p  { font-size: 12px; color: #999; margin-top: 3px; font-weight: 500; }

    /* BOTTOM GRID */
    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(102,126,234,0.08);
        border: 1px solid rgba(102,126,234,0.07);
    }

    .card-title {
        font-size: 14px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f2ff;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f7f8ff;
        font-size: 13px;
    }

    .info-row:last-child { border-bottom: none; }
    .info-row .label { color: #aaa; font-weight: 500; }
    .info-row .value { color: #333; font-weight: 600; text-transform: capitalize; }

    .badge-role {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .badge-active {
        background: rgba(72,187,120,0.12);
        color: #276749;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .activity-item {
        display: flex;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f7f8ff;
        font-size: 13px;
        align-items: flex-start;
    }

    .activity-item:last-child { border-bottom: none; }

    .activity-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        margin-top: 4px;
        flex-shrink: 0;
    }

    .activity-dot.purple { background: #667eea; }
    .activity-dot.green  { background: #48bb78; }

    .activity-item .act-text { color: #555; line-height: 1.4; }
    .activity-item .act-time { color: #bbb; font-size: 11px; margin-top: 2px; }

    @media (max-width: 900px) {
        .sidebar { width: 70px; }
        .sidebar-brand span, .nav-item span, .nav-label, .user-meta { display: none; }
        .sidebar-brand { justify-content: center; padding: 20px 10px; }
        .nav-item { justify-content: center; padding: 12px; }
        .sidebar-user { justify-content: center; padding: 14px 10px; }
        .main-content { margin-left: 70px; padding: 24px 20px; }
        .bottom-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 600px) {
        .main-content { padding: 20px 15px; }
        .stats-grid { grid-template-columns: 1fr 1fr; }
    }
</style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="deco d1"></div>
    <div class="deco d2"></div>

    <div class="sidebar-brand">
        <div class="icon">&#9670;</div>
        <span>MyApp</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Main</div>
        <a class="nav-item active" href="#">
            <span class="nav-icon">&#9671;</span>
            <span>Dashboard</span>
        </a>
        <a class="nav-item" href="#">
            <span class="nav-icon">&#128100;</span>
            <span>Profile</span>
        </a>
        <a class="nav-item" href="#">
            <span class="nav-icon">&#9881;</span>
            <span>Settings</span>
        </a>

        <div class="nav-label" style="margin-top:20px;">Account</div>
        <a class="nav-item" href="#">
            <span class="nav-icon">&#128274;</span>
            <span>Security</span>
        </a>
    </nav>

    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div class="user-meta">
            <div class="uname">{{ Auth::user()->name }}</div>
            <div class="urole">{{ Auth::user()->role }}</div>
        </div>
    </div>
</aside>

<!-- Main Content -->
<div class="main-content">

    <!-- Top Bar -->
    <div class="topbar">
        <div>
            <h2>Dashboard</h2>
            <div class="date">{{ now()->format('l, d M Y') }}</div>
        </div>
        <div class="logout-form">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">&#128275; Logout</button>
            </form>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon purple">&#128101;</div>
            <div class="stat-info">
                <h3>{{ ucfirst(Auth::user()->role) }}</h3>
                <p>Account Role</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">&#9989;</div>
            <div class="stat-info">
                <h3>Active</h3>
                <p>Account Status</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">&#128197;</div>
            <div class="stat-info">
                <h3>{{ Auth::user()->created_at->format('d M Y') }}</h3>
                <p>Member Since</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">&#128274;</div>
            <div class="stat-info">
                <h3>Secure</h3>
                <p>Session</p>
            </div>
        </div>
    </div>

    <!-- Bottom Grid -->
    <div class="bottom-grid">

        <!-- Account Details -->
        <div class="card">
            <div class="card-title">&#128100; Account Details</div>

            <div class="info-row">
                <span class="label">Full Name</span>
                <span class="value">{{ Auth::user()->name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Email</span>
                <span class="value" style="text-transform:none;">{{ Auth::user()->email }}</span>
            </div>
            <div class="info-row">
                <span class="label">Role</span>
                <span class="badge-role">{{ Auth::user()->role }}</span>
            </div>
            <div class="info-row">
                <span class="label">Status</span>
                <span class="badge-active">&#9679; Active</span>
            </div>
            <div class="info-row">
                <span class="label">Joined</span>
                <span class="value">{{ Auth::user()->created_at->format('d M Y') }}</span>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card">
            <div class="card-title">&#128336; Recent Activity</div>

            <div class="activity-item">
                <div class="activity-dot green"></div>
                <div>
                    <div class="act-text">Logged in successfully</div>
                    <div class="act-time">Just now</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-dot purple"></div>
                <div>
                    <div class="act-text">Account created</div>
                    <div class="act-time">{{ Auth::user()->created_at->format('d M Y, h:i A') }}</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-dot purple"></div>
                <div>
                    <div class="act-text">Role assigned: <strong>{{ Auth::user()->role }}</strong></div>
                    <div class="act-time">{{ Auth::user()->created_at->format('d M Y') }}</div>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
