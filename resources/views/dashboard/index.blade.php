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
    }

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

    /* SECTIONS — hide/show */
    .section { display: none; }
    .section.active { display: block; }

    /* Stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #fff; border-radius: 16px; padding: 22px 24px;
        box-shadow: 0 2px 12px rgba(102,126,234,0.08);
        display: flex; align-items: center; gap: 16px;
        border: 1px solid rgba(102,126,234,0.07);
        transition: 0.2s;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(102,126,234,0.15); }

    .stat-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
    .stat-icon.purple { background: linear-gradient(135deg, rgba(102,126,234,0.15), rgba(118,75,162,0.1)); }
    .stat-icon.green  { background: rgba(72,187,120,0.12); }
    .stat-icon.blue   { background: rgba(66,153,225,0.12); }
    .stat-icon.orange { background: rgba(237,137,54,0.12); }

    .stat-info h3 { font-size: 18px; font-weight: 700; color: #1a1a2e; }
    .stat-info p  { font-size: 12px; color: #999; margin-top: 3px; font-weight: 500; }

    .bottom-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

    .card {
        background: #fff; border-radius: 16px; padding: 24px;
        box-shadow: 0 2px 12px rgba(102,126,234,0.08);
        border: 1px solid rgba(102,126,234,0.07);
    }

    .card-title {
        font-size: 14px; font-weight: 700; color: #1a1a2e;
        margin-bottom: 18px; padding-bottom: 12px;
        border-bottom: 2px solid #f0f2ff;
        display: flex; align-items: center; gap: 8px;
    }

    .info-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f7f8ff; font-size: 13px; }
    .info-row:last-child { border-bottom: none; }
    .info-row .label { color: #aaa; font-weight: 500; }
    .info-row .value { color: #333; font-weight: 600; text-transform: capitalize; }

    .badge-role { background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: capitalize; }
    .badge-active { background: rgba(72,187,120,0.12); color: #276749; padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }

    .activity-item { display: flex; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f7f8ff; font-size: 13px; align-items: flex-start; }
    .activity-item:last-child { border-bottom: none; }
    .activity-dot { width: 8px; height: 8px; border-radius: 50%; margin-top: 4px; flex-shrink: 0; }
    .activity-dot.purple { background: #667eea; }
    .activity-dot.green  { background: #48bb78; }
    .act-text { color: #555; line-height: 1.4; }
    .act-time { color: #bbb; font-size: 11px; margin-top: 2px; }

    /* SECURITY SECTION */
    .security-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }

    .sec-card {
        background: #fff; border-radius: 16px; padding: 24px;
        box-shadow: 0 2px 12px rgba(102,126,234,0.08);
        border: 1px solid rgba(102,126,234,0.07);
    }

    .sec-card .sec-header { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; }
    .sec-card .sec-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
    .sec-icon.red    { background: rgba(245,101,101,0.1); }
    .sec-icon.green  { background: rgba(72,187,120,0.1); }
    .sec-icon.purple { background: rgba(102,126,234,0.1); }
    .sec-icon.orange { background: rgba(237,137,54,0.1); }

    .sec-card h3 { font-size: 15px; font-weight: 700; color: #1a1a2e; }
    .sec-card .sec-sub { font-size: 12px; color: #999; margin-top: 2px; }

    .sec-row { display: flex; justify-content: space-between; align-items: center; padding: 11px 0; border-bottom: 1px solid #f7f8ff; font-size: 13px; }
    .sec-row:last-child { border-bottom: none; }
    .sec-row .slabel { color: #777; font-weight: 500; }

    .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .status-pill.enabled  { background: rgba(72,187,120,0.12); color: #276749; }
    .status-pill.disabled { background: rgba(245,101,101,0.1); color: #c53030; }
    .status-pill.strong   { background: rgba(102,126,234,0.12); color: #553c9a; }
    .status-pill.medium   { background: rgba(237,137,54,0.12); color: #c05621; }

    .change-password-form { margin-top: 4px; }
    .cp-group { margin-bottom: 14px; }
    .cp-group label { display: block; font-size: 12px; font-weight: 500; color: #555; margin-bottom: 6px; }
    .cp-group input {
        width: 100%; padding: 9px 12px;
        border: 1.5px solid #e2e6f0; border-radius: 8px;
        font-size: 13px; font-family: 'Inter', sans-serif; color: #333;
        outline: none; transition: 0.2s;
    }
    .cp-group input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }

    .btn-save {
        padding: 9px 22px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff; border: none; border-radius: 8px;
        font-size: 13px; font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer; transition: 0.3s;
        box-shadow: 0 3px 10px rgba(102,126,234,0.35);
    }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(102,126,234,0.45); }

    .alert-note {
        background: rgba(102,126,234,0.07);
        border: 1px solid rgba(102,126,234,0.2);
        border-radius: 10px;
        padding: 14px 16px;
        font-size: 13px;
        color: #553c9a;
        display: flex; gap: 10px; align-items: flex-start;
        margin-top: 20px;
    }

    /* 2FA TOGGLE */
    .tfa-card {
        background: #fff; border-radius: 16px; padding: 24px;
        box-shadow: 0 2px 12px rgba(102,126,234,0.08);
        border: 1px solid rgba(102,126,234,0.07);
        margin-bottom: 24px;
    }

    .tfa-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 20px; padding-bottom: 16px;
        border-bottom: 2px solid #f0f2ff;
    }

    .tfa-title-wrap { display: flex; align-items: center; gap: 12px; }

    .tfa-icon {
        width: 46px; height: 46px; border-radius: 12px;
        background: rgba(102,126,234,0.1);
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
    }

    .tfa-title { font-size: 15px; font-weight: 700; color: #1a1a2e; }
    .tfa-desc  { font-size: 12px; color: #999; margin-top: 2px; }

    /* Toggle Switch */
    .toggle-wrap { display: flex; align-items: center; gap: 10px; }
    .toggle-label { font-size: 13px; font-weight: 600; }
    .toggle-label.on  { color: #276749; }
    .toggle-label.off { color: #c53030; }

    .toggle {
        position: relative;
        width: 50px; height: 26px;
        cursor: pointer;
    }

    .toggle input { opacity: 0; width: 0; height: 0; }

    .toggle-slider {
        position: absolute; inset: 0;
        background: #ddd;
        border-radius: 26px;
        transition: 0.3s;
    }

    .toggle-slider::before {
        content: '';
        position: absolute;
        width: 20px; height: 20px;
        left: 3px; top: 3px;
        background: #fff;
        border-radius: 50%;
        transition: 0.3s;
        box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }

    .toggle input:checked + .toggle-slider { background: linear-gradient(135deg, #667eea, #764ba2); }
    .toggle input:checked + .toggle-slider::before { transform: translateX(24px); }

    .tfa-step {
        background: #f8f9ff;
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        border: 1.5px solid #e8ecff;
        transition: 0.2s;
    }

    .tfa-step.active-step { border-color: #667eea; background: rgba(102,126,234,0.05); }

    .step-num {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: #e2e6f0;
        color: #888;
        font-size: 13px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 8px;
    }

    .tfa-step.active-step .step-num { background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; }

    .step-text { font-size: 12px; color: #666; line-height: 1.4; }

    .tfa-otp-section {
        background: #f8f9ff;
        border: 1.5px dashed #c7d0f8;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        display: none;
    }

    .tfa-otp-section.visible { display: block; }

    .tfa-otp-section p { font-size: 13px; color: #555; margin-bottom: 14px; }

    .otp-inputs { display: flex; gap: 8px; justify-content: center; margin-bottom: 16px; }

    .otp-inputs input {
        width: 42px; height: 48px;
        text-align: center;
        font-size: 20px; font-weight: 700;
        border: 1.5px solid #e2e6f0;
        border-radius: 10px;
        outline: none;
        font-family: 'Inter', sans-serif;
        color: #333;
        transition: 0.2s;
    }

    .otp-inputs input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.12); }

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
    .users-table thead th:first-child { border-radius: 0; }

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
    }
    .user-cell .uinfo .uname { font-weight: 600; color: #1a1a2e; font-size: 13px; }
    .user-cell .uinfo .uemail { font-size: 11px; color: #999; }

    .pill { display: inline-block; padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .pill.admin  { background: linear-gradient(135deg,#667eea,#764ba2); color: #fff; }
    .pill.user   { background: rgba(66,153,225,0.12); color: #2b6cb0; }
    .pill.active { background: rgba(72,187,120,0.12); color: #276749; }

    .empty-state { text-align: center; padding: 48px 20px; color: #bbb; font-size: 14px; }

    @media (max-width: 600px) {
        .search-box input { width: 120px; }
        .users-table thead th, .users-table td { padding: 12px 12px; }
    }

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
        .bottom-grid, .security-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 600px) {
        /* Sidebar hidden off-screen, slides in on toggle */
        .sidebar {
            width: 240px;
            transform: translateX(-100%);
            transition: transform 0.28s ease;
        }
        .sidebar.open { transform: translateX(0); }
        /* Restore hidden items when sidebar opens on mobile */
        .sidebar.open .sidebar-brand span,
        .sidebar.open .nav-item span,
        .sidebar.open .nav-label,
        .sidebar.open .user-meta { display: block; }
        .sidebar.open .sidebar-brand { justify-content: flex-start; padding: 28px 24px 20px; }
        .sidebar.open .nav-item { justify-content: flex-start; padding: 11px 14px; }
        .sidebar.open .sidebar-user { justify-content: flex-start; padding: 18px 20px; }

        .main-content { margin-left: 0; padding: 16px 14px; padding-top: 70px; }
        .stats-grid { grid-template-columns: 1fr 1fr; }

        /* Fixed top bar on mobile */
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
    }

    @media (max-width: 380px) {
        .stats-grid { grid-template-columns: 1fr; }
        .otp-inputs { gap: 5px; }
        .otp-inputs input { width: 38px; height: 44px; font-size: 16px; }
    }
</style>
</head>
<body>

<div class="sidebar-overlay" id="sidebar-overlay"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="deco d1"></div>
    <div class="deco d2"></div>

    <div class="sidebar-brand">
        <div class="icon">&#9670;</div>
        <span>MyApp</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Main</div>
        <button class="nav-item active" data-section="dashboard">
            <span class="nav-icon">&#9671;</span>
            <span>Dashboard</span>
        </button>
        @if(Auth::user()->role === 'admin')
        <button class="nav-item" data-section="users">
            <span class="nav-icon">&#128101;</span>
            <span>Users</span>
        </button>
        @endif
        <button class="nav-item" data-section="profile">
            <span class="nav-icon">&#128100;</span>
            <span>Profile</span>
        </button>
        <button class="nav-item" data-section="settings">
            <span class="nav-icon">&#9881;</span>
            <span>Settings</span>
        </button>

        <div class="nav-label" style="margin-top:20px;">Account</div>
        <button class="nav-item" data-section="security">
            <span class="nav-icon">&#128274;</span>
            <span>Security</span>
        </button>
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
        <div style="display:flex; align-items:center; gap:12px;">
            <button class="hamburger" id="hamburger-btn" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
            <div>
                <h2 id="page-title">Dashboard</h2>
                <div class="date">{{ now()->format('l, d M Y') }}</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">&#128275; <span>Logout</span></button>
        </form>
    </div>

    <!-- ===== DASHBOARD SECTION ===== -->
    <div class="section active" id="section-dashboard">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon purple">&#128101;</div>
                <div class="stat-info"><h3>{{ ucfirst(Auth::user()->role) }}</h3><p>Account Role</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">&#9989;</div>
                <div class="stat-info"><h3>Active</h3><p>Account Status</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">&#128197;</div>
                <div class="stat-info"><h3>{{ Auth::user()->created_at->format('d M Y') }}</h3><p>Member Since</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">&#128274;</div>
                <div class="stat-info"><h3>Secure</h3><p>Session</p></div>
            </div>
        </div>

        <div class="bottom-grid">
            <div class="card">
                <div class="card-title">&#128100; Account Details</div>
                <div class="info-row"><span class="label">Full Name</span><span class="value">{{ Auth::user()->name }}</span></div>
                <div class="info-row"><span class="label">Email</span><span class="value" style="text-transform:none;">{{ Auth::user()->email }}</span></div>
                <div class="info-row"><span class="label">Role</span><span class="badge-role">{{ Auth::user()->role }}</span></div>
                <div class="info-row"><span class="label">Status</span><span class="badge-active">&#9679; Active</span></div>
                <div class="info-row"><span class="label">Joined</span><span class="value">{{ Auth::user()->created_at->format('d M Y') }}</span></div>
            </div>
            <div class="card">
                <div class="card-title">&#128336; Recent Activity</div>
                <div class="activity-item">
                    <div class="activity-dot green"></div>
                    <div><div class="act-text">Logged in successfully</div><div class="act-time">Just now</div></div>
                </div>
                <div class="activity-item">
                    <div class="activity-dot purple"></div>
                    <div><div class="act-text">Account created</div><div class="act-time">{{ Auth::user()->created_at->format('d M Y, h:i A') }}</div></div>
                </div>
                <div class="activity-item">
                    <div class="activity-dot purple"></div>
                    <div><div class="act-text">Role assigned: <strong>{{ Auth::user()->role }}</strong></div><div class="act-time">{{ Auth::user()->created_at->format('d M Y') }}</div></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== PROFILE SECTION (placeholder) ===== -->
    <div class="section" id="section-profile">
        <div class="card" style="max-width:500px;">
            <div class="card-title">&#128100; Profile</div>
            <div class="info-row"><span class="label">Name</span><span class="value">{{ Auth::user()->name }}</span></div>
            <div class="info-row"><span class="label">Email</span><span class="value" style="text-transform:none;">{{ Auth::user()->email }}</span></div>
            <div class="info-row"><span class="label">Role</span><span class="badge-role">{{ Auth::user()->role }}</span></div>
        </div>
    </div>

    <!-- ===== USERS SECTION (admin only) ===== -->
    @if(Auth::user()->role === 'admin')
    <div class="section" id="section-users">
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                        <tr>
                            <td style="color:#bbb; font-size:12px;">{{ $loop->iteration }}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="avatar">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
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
                            <td><span class="pill active">Active</span></td>
                            <td>
                                @if($u->two_fa_is_active)
                                    <span class="pill active">&#10003; On</span>
                                @else
                                    <span class="pill" style="background:#fff5f5; color:#c53030;">&#10005; Off</span>
                                @endif
                            </td>
                            <td style="color:#888; font-size:12px; white-space:nowrap;">{{ $u->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6"><div class="empty-state">No users found.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @endif

    <!-- ===== SETTINGS SECTION (placeholder) ===== -->
    <div class="section" id="section-settings">
        <div class="card" style="max-width:500px;">
            <div class="card-title">&#9881; Settings</div>
            <p style="color:#999; font-size:14px;">Settings panel coming soon.</p>
        </div>
    </div>

    <!-- ===== SECURITY SECTION ===== -->
    <div class="section" id="section-security">

        <!-- 2FA TOGGLE CARD -->
        <div class="tfa-card">
            <div class="tfa-header">
                <div class="tfa-title-wrap">
                    <div class="tfa-icon">&#128241;</div>
                    <div>
                        <div class="tfa-title">Two-Factor Authentication (2FA)</div>
                        <div class="tfa-desc">Add an extra layer of security to your account</div>
                    </div>
                </div>
                <div class="toggle-wrap">
                    <span class="toggle-label {{ Auth::user()->two_fa_is_active ? 'on' : 'off' }}" id="tfa-status-label">
                        {{ Auth::user()->two_fa_is_active ? 'Enabled' : 'Disabled' }}
                    </span>
                    <label class="toggle">
                        <input type="checkbox" id="tfa-toggle" {{ Auth::user()->two_fa_is_active ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>

            <!-- Inline steps hint -->
            <p style="font-size:12px; color:#888; margin-bottom:16px;">
                Steps: <strong>1.</strong> Enable toggle &amp; get OTP on email &nbsp;&rarr;&nbsp;
                <strong>2.</strong> Enter the 6-digit verification code &nbsp;&rarr;&nbsp;
                <strong>3.</strong> 2FA active on next login
            </p>

            <!-- OTP Section (shown after toggle ON) -->
            <div class="tfa-otp-section" id="tfa-otp-box">
                <p>&#9993; A 6-digit OTP has been sent to <strong>{{ Auth::user()->email }}</strong>. Enter it below to confirm.</p>
                <div class="otp-inputs">
                    <input type="text" maxlength="1" class="otp-digit">
                    <input type="text" maxlength="1" class="otp-digit">
                    <input type="text" maxlength="1" class="otp-digit">
                    <input type="text" maxlength="1" class="otp-digit">
                    <input type="text" maxlength="1" class="otp-digit">
                    <input type="text" maxlength="1" class="otp-digit">
                </div>
                <button class="btn-save" id="tfa-verify-btn">Verify &amp; Enable 2FA</button>
            </div>
        </div>

        <div class="security-grid">

            <!-- Account Security Status -->
            <div class="sec-card">
                <div class="sec-header">
                    <div class="sec-icon green">&#128737;</div>
                    <div>
                        <h3>Security Status</h3>
                        <div class="sec-sub">Overview of your account protection</div>
                    </div>
                </div>
                <!-- <div class="sec-row">
                    <span class="slabel">&#128274; Password</span>
                    <span class="status-pill strong">Strong</span>
                </div> -->
                <div class="sec-row">
                    <span class="slabel">&#128241; Two-Factor Auth</span>
                    <span class="status-pill {{ Auth::user()->two_fa_is_active ? 'enabled' : 'disabled' }}">{{ Auth::user()->two_fa_is_active ? 'Enabled' : 'Disabled' }}</span>
                </div>
                <div class="sec-row">
                    <span class="slabel">&#127758; Active Sessions</span>
                    <span class="status-pill enabled">1 Active</span>
                </div>
                <div class="sec-row">
                    <span class="slabel">&#128336; Last Login</span>
                    <span class="value" style="font-size:12px; color:#666;">{{ Auth::user()->updated_at }}</span>
                </div>
            </div>

            <!-- Change Password -->
            <div class="sec-card">
                <div class="sec-header">
                    <div class="sec-icon purple">&#128272;</div>
                    <div>
                        <h3>Change Password</h3>
                        <div class="sec-sub">Update your login password</div>
                    </div>
                </div>
                <form class="change-password-form">
                    <div class="cp-group">
                        <label>Current Password</label>
                        <input type="password" placeholder="Enter current password">
                    </div>
                    <div class="cp-group">
                        <label>New Password</label>
                        <input type="password" placeholder="Min. 6 characters">
                    </div>
                    <div class="cp-group">
                        <label>Confirm New Password</label>
                        <input type="password" placeholder="Repeat new password">
                    </div>
                    <button type="submit" class="btn-save">Update Password</button>
                </form>
            </div>

        </div>

        <!-- Login History -->
        <div class="sec-card">
            <div class="sec-header">
                <div class="sec-icon orange">&#128196;</div>
                <div>
                    <h3>Login History</h3>
                    <div class="sec-sub">Recent account activity</div>
                </div>
            </div>
            <div class="sec-row">
                <span class="slabel">&#127758; Current session</span>
                <span style="font-size:12px; color:#555;">Browser &bull; Just now</span>
                <span class="status-pill enabled">Active</span>
            </div>
            <div class="sec-row">
                <span class="slabel">&#128197; Registered on</span>
                <span style="font-size:12px; color:#555;">{{ Auth::user()->created_at->format('d M Y, h:i A') }}</span>
                <span class="status-pill enabled">OK</span>
            </div>
        </div>

        @if(Auth::user()->two_fa_is_active == 0)
        <div class="alert-note">
            <span>&#128161;</span>
            <span>Two-factor authentication is currently disabled. Enable it from your account settings to add an extra layer of security.</span>
        </div>
        @endif

    </div>

</div>

<script>
    const navItems  = document.querySelectorAll('.nav-item[data-section]');
    const sections  = document.querySelectorAll('.section');
    const pageTitle = document.getElementById('page-title');

    const titles = {
        dashboard : 'Dashboard',
        users     : 'Users',
        profile   : 'Profile',
        settings  : 'Settings',
        security  : 'Security',
    };

    // User search
    document.getElementById('user-search')?.addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#users-table tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    });

    // 2FA Toggle Logic
    const tfaToggle  = document.getElementById('tfa-toggle');
    const tfaOtpBox  = document.getElementById('tfa-otp-box');
    const tfaLabel   = document.getElementById('tfa-status-label');
    const otpDigits  = document.querySelectorAll('.otp-digit');

    const csrfToken = '{{ csrf_token() }}';

    if (tfaToggle) {
        tfaToggle.addEventListener('change', () => {
            if (tfaToggle.checked) {
                tfaLabel.textContent = 'Sending...';
                tfaLabel.className = 'toggle-label';
                tfaLabel.style.color = '#c05621';

                fetch('{{ route("2fa.send") }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }
                })
                .then(r => r.json())
                .then(data => {
                    tfaLabel.textContent = 'Pending OTP...';
                    tfaOtpBox.classList.add('visible');
                    otpDigits[0].focus();
                })
                .catch(() => {
                    tfaLabel.textContent = 'Failed. Try again.';
                    tfaToggle.checked = false;
                });

            } else {
                fetch('{{ route("2fa.disable") }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }
                })
                .then(r => r.json())
                .then(() => {
                    tfaOtpBox.classList.remove('visible');
                    tfaLabel.textContent = 'Disabled';
                    tfaLabel.className = 'toggle-label off';
                    tfaLabel.style.color = '';
                    otpDigits.forEach(d => d.value = '');
                });
            }
        });

        // OTP auto-focus next input
        otpDigits.forEach((input, i) => {
            input.addEventListener('input', () => {
                input.value = input.value.replace(/\D/g, '');
                if (input.value && i < otpDigits.length - 1) {
                    otpDigits[i + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && i > 0) {
                    otpDigits[i - 1].focus();
                }
            });
        });

        document.getElementById('tfa-verify-btn').addEventListener('click', () => {
            const otp = Array.from(otpDigits).map(d => d.value).join('');
            if (otp.length < 6) {
                alert('Please enter all 6 digits.');
                return;
            }

            fetch('{{ route("2fa.verify") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' },
                body: JSON.stringify({ otp })
            })
            .then(r => r.json().then(data => ({ status: r.status, data })))
            .then(({ status, data }) => {
                if (status === 422) {
                    alert(data.error);
                    otpDigits.forEach(d => d.value = '');
                    otpDigits[0].focus();
                } else {
                    tfaOtpBox.classList.remove('visible');
                    tfaLabel.textContent = 'Enabled';
                    tfaLabel.className = 'toggle-label on';
                    tfaLabel.style.color = '';
                    otpDigits.forEach(d => d.value = '');
                }
            })
            .catch(() => alert('Something went wrong. Please try again.'));
        });
    }

    // Hamburger / sidebar toggle
    const sidebar        = document.getElementById('sidebar');
    const overlay        = document.getElementById('sidebar-overlay');
    const hamburgerBtn   = document.getElementById('hamburger-btn');

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('visible');
    }

    hamburgerBtn?.addEventListener('click', () => {
        const isOpen = sidebar.classList.toggle('open');
        overlay.classList.toggle('visible', isOpen);
    });

    overlay.addEventListener('click', closeSidebar);

    navItems.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.section;

            // active nav
            navItems.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // show section
            sections.forEach(s => s.classList.remove('active'));
            document.getElementById('section-' + target).classList.add('active');

            // update title
            pageTitle.textContent = titles[target] || target;

            // close sidebar on mobile after nav click
            if (window.innerWidth <= 600) closeSidebar();
        });
    });
</script>

</body>
</html>
