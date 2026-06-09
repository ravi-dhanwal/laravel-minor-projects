<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: #f0f4f8; font-family: 'Segoe UI', Arial, sans-serif; padding: 24px 12px; }
        .wrapper { max-width: 580px; width: 100%; margin: 0 auto; }

        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px 12px 0 0; padding: 32px 24px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 24px; font-weight: 700; letter-spacing: 0.5px; }
        .header p { color: rgba(255,255,255,0.8); font-size: 13px; margin-top: 4px; }

        .body { background: #ffffff; padding: 32px 24px; border-left: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; }
        .body h2 { color: #2d3748; font-size: 18px; margin-bottom: 12px; }
        .body p { color: #4a5568; font-size: 15px; line-height: 1.7; margin-bottom: 16px; }

        .otp-box { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; padding: 20px 16px; text-align: center; margin: 24px 0; }
        .otp-box span { color: #ffffff; font-size: 36px; font-weight: 800; letter-spacing: 8px; word-break: break-all; }

        .info-box { background: #f7fafc; border-left: 4px solid #667eea; border-radius: 0 8px 8px 0; padding: 14px 16px; margin: 20px 0; }
        .info-box p { color: #4a5568; font-size: 14px; margin: 0; }

        .user-card { background: #f7fafc; border-radius: 10px; padding: 16px; margin: 20px 0; border: 1px solid #e2e8f0; }
        .user-card .row { display: table; width: 100%; padding: 10px 0; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
        .user-card .row:last-child { border-bottom: none; }
        .user-card .label { display: table-cell; width: 40%; color: #718096; font-weight: 600; vertical-align: middle; padding-right: 8px; }
        .user-card .value { display: table-cell; color: #2d3748; vertical-align: middle; word-break: break-word; }

        .badge { display: inline-block; background: #c6f6d5; color: #276749; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }

        .warning { background: #fff5f5; border-left: 4px solid #fc8181; border-radius: 0 8px 8px 0; padding: 14px 16px; margin: 20px 0; }
        .warning p { color: #c53030; font-size: 13px; margin: 0; }

        .footer { background: #f7fafc; border: 1px solid #e2e8f0; border-top: none; border-radius: 0 0 12px 12px; padding: 20px 24px; text-align: center; }
        .footer p { color: #a0aec0; font-size: 12px; line-height: 1.6; }
        .footer a { color: #667eea; text-decoration: none; }

        @media only screen and (max-width: 480px) {
            body { padding: 12px 8px; }
            .header { padding: 24px 16px; border-radius: 10px 10px 0 0; }
            .header h1 { font-size: 20px; }
            .body { padding: 24px 16px; }
            .body h2 { font-size: 17px; }
            .body p { font-size: 14px; }
            .otp-box { padding: 18px 12px; }
            .otp-box span { font-size: 28px; letter-spacing: 6px; }
            .user-card { padding: 12px; }
            .user-card .row { display: block; padding: 8px 0; }
            .user-card .label { display: block; width: 100%; margin-bottom: 2px; font-size: 12px; }
            .user-card .value { display: block; width: 100%; font-size: 13px; }
            .footer { padding: 16px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
            <p>{{ $headerSubtitle ?? 'Notification' }}</p>
        </div>
        <div class="body">
            @yield('content')
        </div>
        <div class="footer">
            <p>
                This email was sent automatically, please do not reply.<br>
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
