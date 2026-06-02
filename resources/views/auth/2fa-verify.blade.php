<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>2FA Verification</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; height: 100vh; display: flex; overflow: hidden; }

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
    }
    .left-panel .deco-circle { position: absolute; border-radius: 50%; background: rgba(255,255,255,0.08); }
    .left-panel .deco-circle.c1 { width: 300px; height: 300px; top: -80px; right: -80px; }
    .left-panel .deco-circle.c2 { width: 200px; height: 200px; bottom: -60px; left: -60px; }
    .left-panel .deco-circle.c3 { width: 120px; height: 120px; bottom: 120px; right: 30px; background: rgba(255,255,255,0.05); }

    .brand-icon {
        width: 80px; height: 80px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 36px;
        margin-bottom: 24px;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255,255,255,0.3);
    }
    .left-panel h1 { color: #fff; font-size: 26px; font-weight: 700; margin-bottom: 10px; text-align: center; }
    .left-panel p { color: rgba(255,255,255,0.75); font-size: 14px; text-align: center; line-height: 1.7; max-width: 280px; }

    .info-box {
        margin-top: 36px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 14px;
        padding: 20px 22px;
        max-width: 300px;
        z-index: 1;
        backdrop-filter: blur(6px);
    }
    .info-box p { color: rgba(255,255,255,0.85); font-size: 13px; line-height: 1.7; font-style: normal; margin: 0; }
    .info-box .step { display: flex; gap: 10px; align-items: flex-start; margin-bottom: 10px; }
    .info-box .step:last-child { margin-bottom: 0; }
    .info-box .step-dot {
        width: 22px; height: 22px; min-width: 22px;
        background: rgba(255,255,255,0.25);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; color: #fff;
    }

    .right-panel {
        flex: 1;
        background: #f8f9ff;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 50px;
        overflow-y: auto;
    }

    .form-box { width: 100%; max-width: 400px; }

    .form-box h2 { font-size: 26px; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
    .form-box .subtitle { font-size: 14px; color: #888; margin-bottom: 30px; line-height: 1.6; }
    .form-box .subtitle strong { color: #555; }

    .alert-error {
        background: #fff5f5;
        border: 1px solid #fed7d7;
        color: #c53030;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 13px;
        margin-bottom: 20px;
    }

    .otp-label { font-size: 13px; font-weight: 500; color: #444; margin-bottom: 12px; display: block; }

    .otp-inputs {
        display: flex;
        gap: 10px;
        margin-bottom: 24px;
    }
    .otp-inputs input {
        width: 52px; height: 58px;
        text-align: center;
        font-size: 22px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        border: 1.5px solid #e2e6f0;
        border-radius: 10px;
        background: #fff;
        color: #1a1a2e;
        outline: none;
        transition: 0.2s;
    }
    .otp-inputs input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
    }
    .otp-inputs input.is-invalid { border-color: #e53e3e; }

    .btn-submit {
        width: 100%;
        padding: 13px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(102,126,234,0.4);
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102,126,234,0.5); }

    .footer-text { text-align: center; margin-top: 20px; font-size: 13px; color: #888; }
    .footer-text a { color: #667eea; font-weight: 600; text-decoration: none; }

    @media (max-width: 768px) {
        .left-panel { display: none; }
        .right-panel { padding: 30px 25px; }
        .otp-inputs input { width: 44px; height: 50px; font-size: 18px; }
    }
</style>
</head>
<body>

<div class="left-panel">
    <div class="deco-circle c1"></div>
    <div class="deco-circle c2"></div>
    <div class="deco-circle c3"></div>

    <div class="brand-icon">&#128274;</div>
    <h1>Two-Factor Auth</h1>
    <p>Your account is protected with an extra layer of security.</p>

    <div class="info-box">
        <div class="step">
            <div class="step-dot">1</div>
            <p>Check your registered email inbox for the OTP.</p>
        </div>
        <div class="step">
            <div class="step-dot">2</div>
            <p>Enter the 6-digit code in the form.</p>
        </div>
        <div class="step">
            <div class="step-dot">3</div>
            <p>Code is valid for <strong style="color:#fff;">10 minutes</strong> only.</p>
        </div>
    </div>
</div>

<div class="right-panel">
    <div class="form-box">

        <h2>Verify Your Identity</h2>
        <p class="subtitle">
            We've sent a 6-digit OTP to your registered email.<br>
            Enter it below to continue.
        </p>

        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('2fa.login.verify') }}" method="POST" id="otp-form">
            @csrf

            <span class="otp-label">Enter OTP</span>

            <div class="otp-inputs">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" maxlength="1" class="otp-digit {{ $errors->any() ? 'is-invalid' : '' }}" inputmode="numeric" autocomplete="off">
                @endfor
            </div>

            <input type="hidden" name="otp" id="otp-hidden">

            <button type="submit" class="btn-submit">Verify &amp; Login &rarr;</button>

            <div class="footer-text">
                Wrong account? <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </form>
    </div>
</div>

<script>
    const digits = document.querySelectorAll('.otp-digit');
    const hiddenOtp = document.getElementById('otp-hidden');
    const form = document.getElementById('otp-form');

    digits[0].focus();

    digits.forEach((input, i) => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/\D/g, '');
            if (input.value && i < digits.length - 1) {
                digits[i + 1].focus();
            }
        });
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && i > 0) {
                digits[i - 1].focus();
            }
        });
        // Paste support — paste 6 digits at once
        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            pasted.split('').forEach((ch, j) => {
                if (digits[j]) digits[j].value = ch;
            });
            const last = Math.min(pasted.length, digits.length - 1);
            digits[last].focus();
        });
    });

    form.addEventListener('submit', (e) => {
        const otp = Array.from(digits).map(d => d.value).join('');
        if (otp.length < 6) {
            e.preventDefault();
            digits[otp.length]?.focus();
            return;
        }
        hiddenOtp.value = otp;
    });
</script>

</body>
</html>
