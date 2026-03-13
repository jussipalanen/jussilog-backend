<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $resume->full_name }}</title>
    <style>
        @@page { margin: 0; size: A4 portrait; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { margin: 0; padding: 0; }

        body {
            font-family: Arial, 'Helvetica Neue', sans-serif;
            background: #0f172a;
            color: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .wrapper {
            text-align: center;
            padding: 60pt 40pt;
        }

        .badge {
            display: inline-block;
            background: #1e293b;
            border: 1pt solid #334155;
            border-radius: 20pt;
            font-size: 8pt;
            letter-spacing: 2pt;
            text-transform: uppercase;
            color: #94a3b8;
            padding: 4pt 14pt;
            margin-bottom: 28pt;
        }

        .icon {
            font-size: 48pt;
            margin-bottom: 20pt;
            line-height: 1;
        }

        h1 {
            font-size: 28pt;
            font-weight: 800;
            letter-spacing: -0.5pt;
            color: #f8fafc;
            margin-bottom: 10pt;
        }

        h1 span {
            color: #6366f1;
        }

        .subtitle {
            font-size: 11pt;
            color: #94a3b8;
            line-height: 1.6;
            max-width: 320pt;
            margin: 0 auto 36pt;
        }

        .template-name {
            display: inline-block;
            background: #1e293b;
            border: 1pt solid #6366f1;
            border-radius: 6pt;
            color: #a5b4fc;
            font-size: 10pt;
            font-weight: bold;
            padding: 6pt 18pt;
            text-transform: capitalize;
            letter-spacing: 0.5pt;
            margin-bottom: 36pt;
        }

        .divider {
            width: 40pt;
            height: 2pt;
            background: #6366f1;
            margin: 0 auto 32pt;
            border-radius: 1pt;
        }

        .resume-name {
            font-size: 13pt;
            font-weight: bold;
            color: #e2e8f0;
            margin-bottom: 4pt;
        }

        .resume-meta {
            font-size: 9pt;
            color: #64748b;
        }

        .footer {
            margin-top: 48pt;
            font-size: 7.5pt;
            color: #475569;
            letter-spacing: 0.5pt;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="badge">Template Preview</div>

        <div class="icon">🚧</div>

        <h1>Coming <span>Soon</span></h1>

        <p class="subtitle">
            This template is currently under development and will be available in a future release.
        </p>

        <div class="template-name">{{ $template }}</div>

        <div class="divider"></div>

        <div class="resume-name">{{ $resume->full_name }}</div>
        @if($resume->title)
        <div class="resume-meta">{{ $resume->title }}</div>
        @endif

        <div class="footer">Use <strong>?template=default</strong> to export with the available template.</div>
    </div>
</body>
</html>
