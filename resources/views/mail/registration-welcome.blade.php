@php
$translations = [
    'en' => [
        'badge'          => 'New Account',
        'heading'        => 'Welcome to ' . config('app.name') . '!',
        'subtitle'       => "We're thrilled to have you on board. Your account is all set and ready to go.",
        'account_details'=> 'Your Account Details',
        'email_username' => 'Email / Username',
        'need_help'      => 'Need help getting started?',
        'need_help_body' => 'Reply to this email and our team will be happy to assist you.',
        'all_rights'     => 'All rights reserved.',
    ],
    'fi' => [
        'badge'          => 'Uusi tili',
        'heading'        => 'Tervetuloa ' . config('app.name') . '!',
        'subtitle'       => 'Olemme iloisia, että olet mukana. Tilisi on valmis ja käyttövalmis.',
        'account_details'=> 'Tilisi tiedot',
        'email_username' => 'Sähköposti / Käyttäjätunnus',
        'need_help'      => 'Tarvitsetko apua?',
        'need_help_body' => 'Vastaa tähän sähköpostiin, niin tiimimme auttaa sinua mielellään.',
        'all_rights'     => 'Kaikki oikeudet pidätetään.',
    ],
];
$t = $translations[$lang ?? 'en'] ?? $translations['en'];
@endphp
<!DOCTYPE html>
<html lang="{{ $lang ?? 'en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $t['heading'] }}</title>
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
                <span style="color:#c4b5fd; font-size:11px; font-weight:600; letter-spacing:2px; text-transform:uppercase;">{{ $t['badge'] }}</span>
            </div>
            <div style="font-size:52px; margin-bottom:14px;">👋</div>
            <h1 style="color:#ffffff; font-size:28px; font-weight:700; margin:0 0 10px;">{{ $t['heading'] }}</h1>
            <p style="color:#c4b5fd; font-size:15px; margin:0;">{{ $t['subtitle'] }}</p>
        </div>

        <div style="padding:36px 40px;">

            {{-- Account details card --}}
            <div style="margin-bottom:28px;">
                <h2 style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 12px;">{{ $t['account_details'] }}</h2>
                <div style="background:#1a1735; border:1px solid #2d2956; border-radius:14px; overflow:hidden;">
                    <table style="width:100%; border-collapse:collapse;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width:70px; vertical-align:middle; padding:16px 0 16px 20px;">
                                <div style="width:38px; height:38px; background:linear-gradient(135deg, #4c1d95, #7c3aed); border-radius:10px; text-align:center; padding-top:8px; box-sizing:border-box; font-size:18px;">✉️</div>
                            </td>
                            <td style="vertical-align:middle; padding:16px 20px 16px 12px;">
                                <p style="color:#5a5690; font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin:0 0 3px;">{{ $t['email_username'] }}</p>
                                <p style="color:#ede9fe; font-size:15px; font-weight:600; margin:0;">{{ $email }}</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Closing --}}
            <div style="background:#130d2e; border:1px solid rgba(196,181,253,0.18); border-radius:14px; padding:22px 24px; text-align:center;">
                <p style="color:#c4b5fd; font-size:14px; font-weight:500; margin:0 0 5px;">{{ $t['need_help'] }}</p>
                <p style="color:#7c6fad; font-size:13px; margin:0;">{{ $t['need_help_body'] }}</p>
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
