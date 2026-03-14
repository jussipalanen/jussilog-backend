<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        * { box-sizing: border-box; }
        body { font-family: 'Inter', Arial, sans-serif; margin: 0; padding: 30px 16px; background: linear-gradient(135deg, #080714 0%, #130d2e 100%); min-height: 100vh; }
    </style>
</head>
<body>
    <div style="max-width:580px; margin:0 auto; background:#100e25; border-radius:20px; overflow:hidden; border:1px solid #2a2754; box-shadow:0 24px 64px rgba(0,0,0,0.6);">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg, #0f0c2e 0%, #1e1047 50%, #3b1264 100%); padding:48px 40px 40px; text-align:center;">
            <div style="display:inline-block; background:rgba(196,181,253,0.12); border:1px solid rgba(196,181,253,0.25); border-radius:50px; padding:6px 18px; margin-bottom:20px;">
                <span style="color:#c4b5fd; font-size:11px; font-weight:600; letter-spacing:2px; text-transform:uppercase;">Google Sign-In</span>
            </div>
            <div style="font-size:52px; margin-bottom:14px; line-height:1;">🎉</div>
            <h1 style="color:#ffffff; font-size:28px; font-weight:700; margin:0 0 10px; line-height:1.3;">Welcome, {{ $name }}!</h1>
            <p style="color:#b8aff5; font-size:15px; margin:0; line-height:1.6;">You've signed in with Google.<br>Your {{ config('app.name') }} account is ready.</p>
        </div>

        <div style="padding:36px 40px;">

            <p style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 12px;">Your Account</p>
            <div style="background:#1a1735; border:1px solid #2d2956; border-radius:14px; overflow:hidden; margin-bottom:24px;">
                <div style="display:flex; align-items:center; gap:14px; padding:16px 20px; border-bottom:1px solid #2d2956;">
                    <div style="width:38px; height:38px; background:linear-gradient(135deg, #4c1d95, #7c3aed); border-radius:10px; font-size:16px; text-align:center; line-height:38px; flex-shrink:0;">✉️</div>
                    <div>
                        <p style="color:#5a5690; font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin:0 0 3px;">Email</p>
                        <p style="color:#ede9fe; font-size:15px; font-weight:600; margin:0;">{{ $email }}</p>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:14px; padding:16px 20px;">
                    <div style="width:38px; height:38px; background:linear-gradient(135deg, #4c1d95, #7c3aed); border-radius:10px; font-size:16px; text-align:center; line-height:38px; flex-shrink:0;">🔗</div>
                    <div>
                        <p style="color:#5a5690; font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin:0 0 3px;">Sign-In Method</p>
                        <p style="color:#ede9fe; font-size:15px; font-weight:600; margin:0;">Google</p>
                    </div>
                </div>
            </div>

            <div style="background:#1a1735; border:1px solid #2d2956; border-radius:12px; padding:16px 20px; margin-bottom:28px;">
                <p style="color:#9490cc; font-size:14px; margin:0; line-height:1.6;">ℹ️ &nbsp;You can sign in at any time using your Google account. No password is needed.</p>
            </div>

            <div style="background:#130d2e; border:1px solid rgba(196,181,253,0.18); border-radius:14px; padding:22px 24px; text-align:center;">
                <p style="color:#c4b5fd; font-size:14px; font-weight:500; margin:0 0 5px;">Need help or have questions?</p>
                <p style="color:#7c6fad; font-size:13px; margin:0;">Reply to this email and our team will be happy to assist you.</p>
            </div>
        </div>

        {{-- Footer --}}
        <div style="background:#080614; border-top:1px solid #1e1b3a; padding:24px 40px; text-align:center;">
            <p style="color:#c4b5fd; font-size:13px; margin:0 0 4px; font-weight:600;">{{ config('app.name') }}</p>
            <p style="color:#3d3a66; font-size:12px; margin:0;">&copy; {{ date('Y') }} All rights reserved.</p>
        </div>
    </div>
</body>
</html>
