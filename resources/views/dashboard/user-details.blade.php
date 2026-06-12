<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Details</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background: #f0f2ff; min-height: 100vh; padding: 32px 36px; }

    .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap: 12px; }
    .topbar h2 { font-size: 22px; font-weight: 700; color: #1a1a2e; }
    .topbar .sub { font-size: 13px; color: #999; margin-top: 2px; }

    .back-btn {
        display: inline-flex; align-items: center; gap: 8px;
        background: #fff;
        border: 1.5px solid #e2e6f0;
        color: #555;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px; font-weight: 500;
        font-family: 'Inter', sans-serif;
        cursor: pointer; transition: 0.2s;
        text-decoration: none;
    }
    .back-btn:hover { border-color: #667eea; color: #667eea; }

    .profile-header {
        background: #fff; border-radius: 16px; padding: 28px;
        box-shadow: 0 2px 12px rgba(102,126,234,0.08);
        border: 1px solid rgba(102,126,234,0.07);
        display: flex; align-items: center; gap: 20px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .avatar-lg {
        width: 64px; height: 64px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 26px; font-weight: 700;
        overflow: hidden;
    }
    .avatar-lg img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }

    .profile-header h3 { font-size: 18px; font-weight: 700; color: #1a1a2e; }
    .profile-header .pemail { font-size: 13px; color: #999; margin-top: 2px; }

    .badge-role { background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: capitalize; }
    .badge-active { background: rgba(72,187,120,0.12); color: #276749; padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }

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

    .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .status-pill.enabled  { background: rgba(72,187,120,0.12); color: #276749; }
    .status-pill.disabled { background: rgba(245,101,101,0.1); color: #c53030; }

    @media (max-width: 700px) {
        body { padding: 20px 16px; }
        .bottom-grid { grid-template-columns: 1fr; }
    }
</style>
</head>
<body>

    <div class="topbar">
        <div>
            <h2>User Details</h2>
            <div class="sub">Viewing profile information</div>
        </div>
        <a href="{{ route('dashboard') }}" class="back-btn">&larr; Back to Dashboard</a>
    </div>

    <div class="profile-header">
        <div class="avatar-lg">
            @if($user->profile_photo)
                <img src="{{ asset('storage/profile_photos/' . $user->profile_photo) }}" alt="{{ $user->name }}">
            @else
                {{ strtoupper(substr($user->name, 0, 1)) }}
            @endif
        </div>
        <div>
            <h3>{{ $user->name }}</h3>
            <div class="pemail">{{ $user->email }}</div>
        </div>
    </div>

    <div class="bottom-grid">
        <div class="card">
            <div class="card-title">&#128100; Account Details</div>
            <div class="info-row"><span class="label">Full Name</span><span class="value">{{ $user->name }}</span></div>
            <div class="info-row"><span class="label">Email</span><span class="value" style="text-transform:none;">{{ $user->email }}</span></div>
            <div class="info-row"><span class="label">Role</span><span class="badge-role">{{ $user->role }}</span></div>
            <div class="info-row">
                <span class="label">Status</span>
                @if($user->is_active)
                    <span class="badge-active">&#9679; Active</span>
                @else
                    <span class="status-pill disabled">&#9679; Inactive</span>
                @endif
            </div>
            <div class="info-row"><span class="label">Joined</span><span class="value">{{ $user->created_at->format('d M Y, h:i A') }}</span></div>
            <div class="info-row"><span class="label">Last Updated</span><span class="value">{{ $user->updated_at->format('d M Y, h:i A') }}</span></div>
        </div>

        <div class="card">
            <div class="card-title">&#128737; Security</div>
            <div class="info-row">
                <span class="label">Two-Factor Auth</span>
                <span class="status-pill {{ $user->two_fa_is_active ? 'enabled' : 'disabled' }}">{{ $user->two_fa_is_active ? 'Enabled' : 'Disabled' }}</span>
            </div>
            <div class="info-row"><span class="label">User ID</span><span class="value" style="text-transform:none;">#{{ $user->id }}</span></div>
        </div>
    </div>

</body>
</html>
