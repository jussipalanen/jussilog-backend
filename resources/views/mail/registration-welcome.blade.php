<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body style="background: linear-gradient(135deg, #f0f4ff 0%, #faf5ff 100%); margin:0; padding:0;">
    <div style="max-width:580px; margin:40px auto; background:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 8px 40px rgba(0,0,0,0.10);">

        {{-- Header --}}
        <div style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 60%, #4c1d95 100%); padding:48px 40px 40px; text-align:center;">
            <div style="display:inline-block; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); border-radius:50px; padding:6px 18px; margin-bottom:20px;">
                <span style="color:#c4b5fd; font-size:11px; font-weight:600; letter-spacing:2px; text-transform:uppercase;">New Account</span>
            </div>
            <div style="font-size:52px; margin-bottom:14px;">👋</div>
            <h1 style="color:#ffffff; font-size:28px; font-weight:700; margin:0 0 10px;">Welcome to {{ config('app.name') }}!</h1>
            <p style="color:#c4b5fd; font-size:15px; margin:0;">We're thrilled to have you on board. Your account is all set and ready to go.</p>
        </div>

        <div style="padding:36px 40px;">

            {{-- Account details card --}}
            <div style="margin-bottom:24px;">
                <h2 style="font-size:11px; font-weight:700; color:#9ca3af; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 14px;">Your Account Details</h2>
                <div style="background:#fafafa; border:1px solid #f3f4f6; border-radius:12px; overflow:hidden;">
                    <div style="display:flex; align-items:center; gap:14px; padding:16px 20px; border-bottom:1px solid #f3f4f6;">
                        <div style="width:36px; height:36px; background: linear-gradient(135deg, #4c1d95, #6d28d9); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0;">✉️</div>
                        <div>
                            <p style="color:#9ca3af; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin:0 0 3px;">Email / Username</p>
                            <p style="color:#111827; font-size:15px; font-weight:600; margin:0;">{{ $email }}</p>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:14px; padding:16px 20px;">
                        <div style="width:36px; height:36px; background: linear-gradient(135deg, #4c1d95, #6d28d9); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0;">🔑</div>
                        <div>
                            <p style="color:#9ca3af; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin:0 0 3px;">Temporary Password</p>
                            <p style="color:#111827; font-size:15px; font-weight:700; font-family:monospace; margin:0; background:#f5f3ff; display:inline-block; padding:2px 10px; border-radius:6px;">{{ $plainPassword }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Security notice --}}
            <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:12px; padding:16px 20px; margin-bottom:28px;">
                <p style="color:#92400e; font-size:13px; margin:0;">⚠️ &nbsp;<strong>For your security</strong>, please change your password after your first login.</p>
            </div>

            {{-- Closing --}}
            <div style="background:#f5f3ff; border-radius:12px; padding:20px 24px; text-align:center;">
                <p style="color:#6d28d9; font-size:14px; font-weight:500; margin:0 0 4px;">Need help getting started?</p>
                <p style="color:#7c3aed; font-size:13px; margin:0;">Reply to this email and our team will be happy to assist you.</p>
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
