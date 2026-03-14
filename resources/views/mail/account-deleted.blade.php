<!DOCTYPE html>
<html lang="{{ $lang ?? 'en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $t['badge'] }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body style="margin:0; padding:30px 16px; background:linear-gradient(135deg, #080714 0%, #130d2e 100%); min-height:100vh;">
    <div style="max-width:580px; margin:0 auto; background:#100e25; border-radius:20px; overflow:hidden; border:1px solid #2a2754; box-shadow:0 24px 64px rgba(0,0,0,0.6);">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg, #0f0c2e 0%, #1e1047 50%, #3b1264 100%); padding:48px 40px 40px; text-align:center;">
            <div style="display:inline-block; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); border-radius:50px; padding:6px 18px; margin-bottom:20px;">
                <span style="color:#f9a8d4; font-size:11px; font-weight:600; letter-spacing:2px; text-transform:uppercase;">{{ $t['badge'] }}</span>
            </div>
            <div style="font-size:52px; margin-bottom:14px;">👋</div>
            <h1 style="color:#ffffff; font-size:28px; font-weight:700; margin:0 0 10px;">{{ $t['goodbye'] }}{{ $name }}!</h1>
            <p style="color:#b8aff5; font-size:15px; margin:0; line-height:1.6;">{{ $t['subtitle'] }}</p>
        </div>

        <div style="padding:36px 40px;">

            {{-- Deleted account info --}}
            <div style="margin-bottom:24px;">
                <p style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 12px;">{{ $t['deleted_account'] }}</p>
            <div style="background:#1a1735; border:1px solid #2d2956; border-radius:14px; display:flex; align-items:center; gap:14px; padding:18px 20px; margin-bottom:24px;">
                <div style="width:38px; height:38px; background:linear-gradient(135deg, #4c1d95, #7c3aed); border-radius:10px; font-size:16px; text-align:center; line-height:38px; flex-shrink:0;">✉️</div>
                <div>
                    <p style="color:#5a5690; font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin:0 0 3px;">{{ $t['account_email'] }}</p>
                    <p style="color:#ede9fe; font-size:15px; font-weight:600; margin:0;">{{ $email }}</p>
                </div>
            </div>
            </div>

            {{-- What happened --}}
            <div style="margin-bottom:24px;">
                <p style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 12px;">{{ $t['what_it_means'] }}</p>
            <div style="background:#1a1735; border:1px solid #2d2956; border-radius:14px; padding:18px 20px; margin-bottom:24px;">
                <div style="display:flex; gap:12px; margin-bottom:14px;">
                    <span style="font-size:16px; flex-shrink:0;">🗑️</span>
                    <p style="color:#9490cc; font-size:14px; margin:0; line-height:1.6;">{{ $t['data_removed'] }}</p>
                </div>
                <div style="display:flex; gap:12px;">
                    <span style="font-size:16px; flex-shrink:0;">🔒</span>
                    <p style="color:#9490cc; font-size:14px; margin:0; line-height:1.6;">{{ $t['no_login'] }}</p>
                </div>
            </div>
            </div>

            {{-- Warning notice --}}
            <div style="background:#1c0a0a; border:1px solid #7f1d1d; border-radius:12px; padding:16px 20px; margin-bottom:28px;">
                <p style="color:#fca5a5; font-size:13px; margin:0; line-height:1.6;">⚠️ &nbsp;{!! $t['warning'] !!}</p>
            </div>

            {{-- Closing --}}
            <div style="background:#130d2e; border:1px solid rgba(196,181,253,0.18); border-radius:14px; padding:22px 24px; text-align:center;">
                <p style="color:#c4b5fd; font-size:14px; font-weight:500; margin:0 0 5px;">{{ $t['thank_you'] }}</p>
                <p style="color:#7c6fad; font-size:13px; margin:0;">{{ $t['see_you'] }}</p>
            </div>
        </div>

        {{-- Footer --}}
        <div style="background:#080614; border-top:1px solid #1e1b3a; padding:24px 40px; text-align:center;">
            <p style="color:#c4b5fd; font-size:13px; margin:0 0 4px; font-weight:600;">{{ config('app.name') }}</p>
            <p style="color:#3d3a66; font-size:12px; margin:0;">&copy; {{ date('Y') }} {{ $t['all_rights'] }}</p>
        </div>
    </div>
</body>
</html>
