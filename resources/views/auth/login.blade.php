<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; }

    .left-panel {
        width: 42%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 50px 40px;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }

    .left-panel .deco-circle { position: absolute; border-radius: 50%; background: rgba(255,255,255,0.08); }
    .left-panel .deco-circle.c1 { width: 300px; height: 300px; top: -80px; right: -80px; }
    .left-panel .deco-circle.c2 { width: 200px; height: 200px; bottom: -60px; left: -60px; }
    .left-panel .deco-circle.c3 { width: 120px; height: 120px; bottom: 120px; right: 30px; background: rgba(255,255,255,0.05); }

    .left-panel .brand-icon {
        width: 70px; height: 70px;
        background: rgba(255,255,255,0.2);
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        font-size: 32px; margin-bottom: 24px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
    }
    .left-panel h1 { color: #fff; font-size: 28px; font-weight: 700; margin-bottom: 12px; text-align: center; }
    .left-panel p { color: rgba(255,255,255,0.75); font-size: 15px; text-align: center; line-height: 1.6; max-width: 280px; }

    .quote-box {
        margin-top: 40px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 14px;
        padding: 20px 22px;
        max-width: 300px;
        z-index: 1;
        backdrop-filter: blur(6px);
    }
    .quote-box .quote-text { color: rgba(255,255,255,0.9); font-size: 14px; line-height: 1.6; font-style: italic; margin-bottom: 12px; }
    .quote-box .quote-author { color: rgba(255,255,255,0.6); font-size: 12px; font-weight: 500; }

    .right-panel {
        flex: 1;
        background: #f8f9ff;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 50px;
        overflow-y: auto;
        min-height: 100vh;
    }

    .form-box { width: 100%; max-width: 400px; }

    .form-box .top-link { text-align: right; font-size: 13px; color: #888; margin-bottom: 32px; }
    .form-box .top-link a { color: #667eea; font-weight: 600; text-decoration: none; }

    .form-box h2 { font-size: 26px; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
    .form-box .subtitle { font-size: 14px; color: #888; margin-bottom: 30px; }

    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 13px; font-weight: 500; color: #444; margin-bottom: 7px; }

    .input-wrap { position: relative; }
    .input-wrap .input-icon {
        position: absolute; left: 13px; top: 50%;
        transform: translateY(-50%);
        font-size: 16px; color: #aaa; pointer-events: none;
    }

    .form-group input {
        width: 100%; padding: 11px 14px 11px 40px;
        border: 1.5px solid #e2e6f0; border-radius: 10px;
        background: #fff; font-size: 14px;
        font-family: 'Inter', sans-serif; color: #333;
        outline: none; transition: 0.25s;
    }
    .form-group input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.12); }
    .form-group input.is-invalid { border-color: #e53e3e; }

    .error-msg { color: #e53e3e; font-size: 12px; margin-top: 5px; display: block; }

    .alert-error {
        background: #fff5f5; border: 1px solid #fed7d7; color: #c53030;
        padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 18px;
    }

    .btn-submit {
        width: 100%; padding: 13px; border: none; border-radius: 10px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff; font-size: 15px; font-weight: 600;
        font-family: 'Inter', sans-serif; cursor: pointer;
        margin-top: 8px; transition: 0.3s;
        box-shadow: 0 4px 15px rgba(102,126,234,0.4);
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102,126,234,0.5); }

    .footer-text { text-align: center; margin-top: 20px; font-size: 13px; color: #888; }
    .footer-text a { color: #667eea; font-weight: 600; text-decoration: none; }

    @media (max-width: 768px) {
        body { flex-direction: column; }
        .left-panel { display: none; }
        .right-panel { padding: 36px 24px; min-height: 100vh; align-items: flex-start; padding-top: 48px; }
    }

    @media (max-width: 400px) {
        .right-panel { padding: 32px 16px; }
        .form-box h2 { font-size: 22px; }
    }
</style>
</head>
<body>

<div class="left-panel">
    <div class="deco-circle c1"></div>
    <div class="deco-circle c2"></div>
    <div class="deco-circle c3"></div>

    <div class="brand-icon">&#9670;</div>
    <h1>Welcome Back</h1>
    <p>Sign in to access your personalized dashboard and tools.</p>

    <div class="quote-box">
        <p class="quote-text">"The secret of getting ahead is getting started."</p>
        <p class="quote-author">&#8212; Mark Twain</p>
    </div>
</div>

<div class="right-panel">
    <div class="form-box">

        <div class="top-link">
            New here? <a href="{{ route('registration-page') }}">Create account</a>
        </div>

        <h2>Sign In</h2>
        <p class="subtitle">Enter your credentials to continue.</p>

        @if(session('success'))
            <div class="alert-error" style="background:#f0fff4; border-color:#c6f6d5; color:#276749;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login-user') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <span class="input-icon">&#9993;</span>
                    <input type="email" name="email" id="email" placeholder="you@example.com"
                        value="{{ old('email') }}" autocomplete="email"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                </div>
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">&#128272;</span>
                    <input type="password" name="password" id="password" placeholder="Your password"
                        minlength="6" class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                </div>
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-submit">Sign In &rarr;</button>

            <div class="footer-text">
                Don't have an account? <a href="{{ route('registration-page') }}">Register</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
