<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account</title>
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
        font-size: 32px;
        margin-bottom: 24px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
    }
    .left-panel h1 { color: #fff; font-size: 28px; font-weight: 700; margin-bottom: 12px; text-align: center; }
    .left-panel p { color: rgba(255,255,255,0.75); font-size: 15px; text-align: center; line-height: 1.6; max-width: 280px; }

    .left-panel .features { margin-top: 40px; display: flex; flex-direction: column; gap: 14px; z-index: 1; }

    .feature-item { display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.85); font-size: 14px; }
    .feature-item .icon {
        width: 34px; height: 34px;
        background: rgba(255,255,255,0.15);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; flex-shrink: 0;
    }

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

    .form-group { margin-bottom: 18px; position: relative; }
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
    <h1>MyApp</h1>
    <p>Join thousands of users and manage everything in one place.</p>

    <div class="features">
        <div class="feature-item">
            <div class="icon">&#128274;</div>
            <span>Secure &amp; encrypted accounts</span>
        </div>
        <div class="feature-item">
            <div class="icon">&#9881;</div>
            <span>Role-based access control</span>
        </div>
        <div class="feature-item">
            <div class="icon">&#128200;</div>
            <span>Real-time dashboard insights</span>
        </div>
    </div>
</div>

<div class="right-panel">
    <div class="form-box">

        <div class="top-link">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>

        <h2>Create Account</h2>
        <p class="subtitle">Fill in the details below to get started.</p>

        <form action="{{ route('register-user') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <div class="input-wrap">
                    <span class="input-icon">&#128100;</span>
                    <input type="text" name="name" id="name" placeholder="John Doe"
                        value="{{ old('name') }}" autocomplete="name"
                        class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                </div>
                @error('name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

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
                    <input type="password" name="password" id="password" placeholder="Min. 6 characters"
                        minlength="6" class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                </div>
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <div class="input-wrap">
                    <span class="input-icon">&#128272;</span>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Repeat password"
                        minlength="6" class="{{ $errors->has('confirm_password') ? 'is-invalid' : '' }}">
                </div>
                @error('confirm_password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-submit">Create Account &rarr;</button>

            <div class="footer-text">
                Already registered? <a href="{{ route('login') }}">Login here</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
