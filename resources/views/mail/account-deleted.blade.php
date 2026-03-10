<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Deleted</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body style="background: linear-gradient(135deg, #fdf2f8 0%, #faf5ff 100%); margin:0; padding:0;">
    <div style="max-width:580px; margin:40px auto; background:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 8px 40px rgba(0,0,0,0.10);">

        {{-- Header --}}
        <div style="background: linear-gradient(135deg, #1e1b4b 0%, #4a1d96 60%, #7c1d6f 100%); padding:48px 40px 40px; text-align:center;">
            <div style="display:inline-block; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); border-radius:50px; padding:6px 18px; margin-bottom:20px;">
                <span style="color:#f9a8d4; font-size:11px; font-weight:600; letter-spacing:2px; text-transform:uppercase;">Account Removed</span>
            </div>
            <div style="font-size:52px; margin-bottom:14px;">👋</div>
            <h1 style="color:#ffffff; font-size:28px; font-weight:700; margin:0 0 10px;">Goodbye, {{ $name }}!</h1>
            <p style="color:#f0abfc; font-size:15px; margin:0;">Your {{ config('app.name') }} account has been permanently deleted.</p>
        </div>

        <div style="padding:36px 40px;">

            {{-- Deleted account info --}}
            <div style="margin-bottom:24px;">
                <h2 style="font-size:11px; font-weight:700; color:#9ca3af; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 14px;">Deleted Account</h2>
                <div style="background:#fafafa; border:1px solid #f3f4f6; border-radius:12px; display:flex; align-items:center; gap:14px; padding:18px 20px;">
                    <div style="width:36px; height:36px; background: linear-gradient(135deg, #7c1d6f, #a21caf); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0;">✉️</div>
                    <div>
                        <p style="color:#9ca3af; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin:0 0 3px;">Account Email</p>
                        <p style="color:#111827; font-size:15px; font-weight:600; margin:0;">{{ $email }}</p>
                    </div>
                </div>
            </div>

            {{-- What happened --}}
            <div style="margin-bottom:24px;">
                <h2 style="font-size:11px; font-weight:700; color:#9ca3af; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 14px;">What This Means</h2>
                <div style="background:#fafafa; border:1px solid #f3f4f6; border-radius:12px; padding:18px 20px;">
                    <div style="display:flex; gap:10px; margin-bottom:12px;">
                        <span style="color:#a21caf; font-size:16px; flex-shrink:0;">🗑️</span>
                        <p style="color:#4b5563; font-size:14px; margin:0; line-height:1.6;">All your personal data has been permanently removed from our systems.</p>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <span style="color:#a21caf; font-size:16px; flex-shrink:0;">🔒</span>
                        <p style="color:#4b5563; font-size:14px; margin:0; line-height:1.6;">You will no longer be able to log in with this account.</p>
                    </div>
                </div>
            </div>

            {{-- Warning notice --}}
            <div style="background:#fff1f2; border:1px solid #fecdd3; border-radius:12px; padding:16px 20px; margin-bottom:28px;">
                <p style="color:#9f1239; font-size:13px; margin:0; line-height:1.6;">⚠️ &nbsp;<strong>Didn't request this?</strong> If you believe this deletion was a mistake, please contact our support team immediately.</p>
            </div>

            {{-- Closing --}}
            <div style="background:#fdf4ff; border:1px solid #f0abfc; border-radius:12px; padding:20px 24px; text-align:center;">
                <p style="color:#86198f; font-size:14px; font-weight:500; margin:0 0 4px;">Thank you for being part of {{ config('app.name') }}.</p>
                <p style="color:#a21caf; font-size:13px; margin:0;">We hope to see you again someday. Take care! 💜</p>
            </div>
        </div>

        {{-- Footer --}}
        <div style="background:#1e1b4b; padding:24px 40px; text-align:center;">
            <p style="color:#a5b4fc; font-size:13px; margin:0 0 4px; font-weight:600;">{{ config('app.name') }}</p>
            <p style="color:#6366f1; font-size:12px; margin:0;">&copy; {{ date('Y') }} All rights reserved.</p>
        </div>
    </div>
</body>
</html>
