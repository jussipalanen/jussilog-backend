@php
$palettes = [
    'midnight' => [
        'bg'         => '#0d1117',
        'header_bg'  => '#161b22',
        'sidebar_bg' => '#13181f',
        'accent'     => '#58a6ff',
        'accent2'    => '#1d4ed8',
        'text_main'  => '#e6edf3',
        'text_soft'  => '#8b949e',
        'text_muted' => '#484f58',
        'border'     => '#30363d',
        'card_bg'    => '#1c2128',
        'tag_bg'     => '#1f2937',
        'tag_color'  => '#93c5fd',
        'date_bg'    => '#1d4ed8',
        'date_text'  => '#dbeafe',
        'name_color' => '#f0f6fc',
        'sb_group'   => '#6e7681',
    ],
    'gold' => [
        'bg'         => '#0f0d08',
        'header_bg'  => '#1a1608',
        'sidebar_bg' => '#151208',
        'accent'     => '#d4a843',
        'accent2'    => '#92661a',
        'text_main'  => '#f0ece0',
        'text_soft'  => '#b09e7e',
        'text_muted' => '#6a5e44',
        'border'     => '#3a3020',
        'card_bg'    => '#1e1a0c',
        'tag_bg'     => '#2a2010',
        'tag_color'  => '#e2bb68',
        'date_bg'    => '#92661a',
        'date_text'  => '#fef9e7',
        'name_color' => '#f5edd5',
        'sb_group'   => '#7a6e50',
    ],
    'aurora' => [
        'bg'         => '#091518',
        'header_bg'  => '#0f2228',
        'sidebar_bg' => '#0c1d22',
        'accent'     => '#2dd4bf',
        'accent2'    => '#0d9488',
        'text_main'  => '#e0f2f1',
        'text_soft'  => '#80cbc4',
        'text_muted' => '#4db6ac',
        'border'     => '#1a3a3c',
        'card_bg'    => '#112226',
        'tag_bg'     => '#134e4a',
        'tag_color'  => '#5eead4',
        'date_bg'    => '#0d5e56',
        'date_text'  => '#ccfbf1',
        'name_color' => '#e0f2f1',
        'sb_group'   => '#4db6ac',
    ],
    'ember' => [
        'bg'         => '#100a07',
        'header_bg'  => '#1c1008',
        'sidebar_bg' => '#160e08',
        'accent'     => '#fb923c',
        'accent2'    => '#c2410c',
        'text_main'  => '#fef3e2',
        'text_soft'  => '#d4a57a',
        'text_muted' => '#8a6040',
        'border'     => '#3c1e0c',
        'card_bg'    => '#1e140a',
        'tag_bg'     => '#431407',
        'tag_color'  => '#fdba74',
        'date_bg'    => '#9a3412',
        'date_text'  => '#fff7ed',
        'name_color' => '#fff7ed',
        'sb_group'   => '#a07050',
    ],
    'amethyst' => [
        'bg'         => '#0d0b14',
        'header_bg'  => '#14102a',
        'sidebar_bg' => '#110e22',
        'accent'     => '#a78bfa',
        'accent2'    => '#6d28d9',
        'text_main'  => '#ede9fe',
        'text_soft'  => '#a897d8',
        'text_muted' => '#6b5f9e',
        'border'     => '#2e2558',
        'card_bg'    => '#18153a',
        'tag_bg'     => '#1e1b4b',
        'tag_color'  => '#c4b5fd',
        'date_bg'    => '#4c1d95',
        'date_text'  => '#ede9fe',
        'name_color' => '#f5f3ff',
        'sb_group'   => '#7c6fc0',
    ],
];
$c = $palettes[$theme ?? 'midnight'] ?? $palettes['midnight'];
@endphp
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
            font-family: 'DejaVu Sans', Arial, 'Helvetica Neue', sans-serif;
            font-size: 10pt;
            color: {{ $c['text_main'] }};
            background: {{ $c['bg'] }};
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .page { width: 100%; border-collapse: collapse; }

        /* ─────────────────────────────────────────────
           HEADER
        ───────────────────────────────────────────── */
        .header-cell {
            background: {{ $c['header_bg'] }};
            border-bottom: 2pt solid {{ $c['accent'] }};
            padding: 14pt 18pt;
        }
        .header-inner { width: 100%; border-collapse: collapse; }
        .header-left  { vertical-align: middle; }
        .header-right {
            vertical-align: middle;
            text-align: right;
            width: 38%;
        }

        .identity-wrap { border-collapse: collapse; }
        .identity-photo-td {
            vertical-align: middle;
            padding-right: 12pt;
        }
        .identity-text-td { vertical-align: middle; }

        .photo {
            width: 62pt;
            height: 62pt;
            border-radius: 31pt;
            border: 2pt solid {{ $c['accent'] }};
            display: block;
            object-fit: cover;
            object-position: center;
        }

        .resume-name {
            font-size: 20pt;
            font-weight: bold;
            color: {{ $c['name_color'] }};
            line-height: 1.15;
        }
        .resume-title {
            font-size: 9pt;
            color: {{ $c['accent'] }};
            text-transform: uppercase;
            letter-spacing: 1.4pt;
            margin-top: 4pt;
        }

        .hc-item { margin-bottom: 4pt; }
        .hc-item:last-child { margin-bottom: 0; }
        .hc-label {
            font-size: 8.5pt;
            color: {{ $c['text_muted'] }};
            text-transform: uppercase;
            letter-spacing: 0.5pt;
        }
        .hc-value {
            font-size: 9pt;
            color: {{ $c['text_soft'] }};
            word-break: break-all;
            line-height: 1.35;
        }

        /* ─────────────────────────────────────────────
           BODY COLUMNS
        ───────────────────────────────────────────── */
        .col-main {
            background: {{ $c['bg'] }};
            padding: 14pt 14pt 18pt 18pt;
            vertical-align: top;
            -webkit-box-decoration-break: clone;
            box-decoration-break: clone;
        }
        .col-sidebar {
            width: 200pt;
            background: {{ $c['sidebar_bg'] }};
            padding: 14pt 16pt 18pt 14pt;
            vertical-align: top;
            -webkit-box-decoration-break: clone;
            box-decoration-break: clone;
        }

        /* ─────────────────────────────────────────────
           MAIN – sections
        ───────────────────────────────────────────── */
        .section { margin-bottom: 13pt; break-inside: auto; page-break-inside: auto; }
        .section:last-child { margin-bottom: 0; }

        .section-title {
            font-size: 9pt;
            font-weight: bold;
            color: {{ $c['accent'] }};
            text-transform: uppercase;
            letter-spacing: 1.3pt;
            padding-bottom: 4pt;
            border-bottom: 1pt solid {{ $c['accent'] }};
            margin-bottom: 9pt;
            page-break-after: avoid;
            break-after: avoid;
        }

        /* ─────────────────────────────────────────────
           MAIN – summary
        ───────────────────────────────────────────── */
        .summary {
            font-size: 9.5pt;
            color: {{ $c['text_soft'] }};
            line-height: 1.7;
        }

        /* ─────────────────────────────────────────────
           MAIN – items
        ───────────────────────────────────────────── */
        .item {
            padding: 8pt 10pt;
            margin-bottom: 6pt;
            background: {{ $c['card_bg'] }};
            border-radius: 3pt;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .item:last-child { margin-bottom: 0; }

        .item-head { display: table; width: 100%; }
        .item-head-left  { display: table-cell; vertical-align: top; }
        .item-head-right {
            display: table-cell;
            vertical-align: top;
            text-align: right;
            white-space: nowrap;
            padding-left: 8pt;
            width: 1%;
        }

        .item-title {
            font-size: 10pt;
            font-weight: bold;
            color: {{ $c['text_main'] }};
            line-height: 1.2;
        }
        .item-sub {
            font-size: 9pt;
            color: {{ $c['text_soft'] }};
            margin-top: 2pt;
        }

        .date-badge {
            display: inline-block;
            background: {{ $c['date_bg'] }};
            color: {{ $c['date_text'] }};
            font-size: 8.5pt;
            padding: 2pt 7pt;
            border-radius: 8pt;
            white-space: nowrap;
        }

        .item-body {
            margin-top: 5pt;
            font-size: 9pt;
            color: {{ $c['text_soft'] }};
            line-height: 1.65;
            white-space: pre-line;
        }

        /* ─────────────────────────────────────────────
           MAIN – tags
        ───────────────────────────────────────────── */
        .tags { margin-top: 5pt; }
        .tag {
            display: inline-block;
            background: {{ $c['tag_bg'] }};
            color: {{ $c['tag_color'] }};
            border-radius: 2pt;
            font-size: 8.5pt;
            padding: 1.5pt 5pt;
            margin: 1pt 2pt 1pt 0;
            border: 0.5pt solid {{ $c['accent2'] }};
        }

        .proj-links {
            margin-top: 4pt;
            font-size: 9pt;
            color: {{ $c['text_soft'] }};
        }
        .proj-link-sep {
            color: {{ $c['text_muted'] }};
        }

        /* ─────────────────────────────────────────────
           MAIN – recommendations
        ───────────────────────────────────────────── */
        .rec-card {
            padding: 7pt 10pt;
            margin-bottom: 6pt;
            background: {{ $c['card_bg'] }};
            border-left: 2.5pt solid {{ $c['accent'] }};
            border-radius: 0 3pt 3pt 0;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .rec-card:last-child { margin-bottom: 0; }
        .rec-name  { font-size: 10pt; font-weight: bold; color: {{ $c['text_main'] }}; }
        .rec-meta  { font-size: 9pt; color: {{ $c['text_muted'] }}; margin-top: 1pt; margin-bottom: 4pt; }
        .rec-quote { font-size: 9pt; color: {{ $c['text_soft'] }}; font-style: italic; line-height: 1.6; }

        /* ─────────────────────────────────────────────
           MAIN – certifications / awards
        ───────────────────────────────────────────── */
        .cert-name { font-size: 10pt; font-weight: bold; color: {{ $c['text_main'] }}; }
        .cert-meta { font-size: 9pt; color: {{ $c['text_soft'] }}; margin-top: 1pt; }

        /* ─────────────────────────────────────────────
           SIDEBAR – headings
        ───────────────────────────────────────────── */
        .sb-heading {
            font-size: 9pt;
            font-weight: bold;
            color: {{ $c['accent'] }};
            text-transform: uppercase;
            letter-spacing: 1pt;
            margin-top: 14pt;
            margin-bottom: 8pt;
            padding-bottom: 3pt;
            border-bottom: 0.5pt solid {{ $c['border'] }};
            page-break-after: avoid;
            break-after: avoid;
        }

        /* ─────────────────────────────────────────────
           SIDEBAR – skill bars
        ───────────────────────────────────────────── */
        .sb-skill-group { margin-bottom: 9pt; break-inside: avoid; page-break-inside: avoid; }
        .sb-skill-group-name {
            font-size: 8.5pt;
            font-weight: bold;
            color: {{ $c['sb_group'] }};
            text-transform: uppercase;
            letter-spacing: 0.4pt;
            margin-bottom: 5pt;
        }
        .sb-skill { margin-bottom: 5pt; break-inside: avoid; page-break-inside: avoid; }
        .sb-skill-name { font-size: 9pt; color: {{ $c['text_main'] }}; margin-bottom: 2pt; }
        .sb-track { background: {{ $c['border'] }}; border-radius: 3pt; height: 3pt; width: 100%; }
        .sb-fill  { background: {{ $c['accent'] }}; border-radius: 3pt; height: 3pt; }

        /* ─────────────────────────────────────────────
           SIDEBAR – language dots
        ───────────────────────────────────────────── */
        .sb-lang { margin-bottom: 7pt; break-inside: avoid; page-break-inside: avoid; }
        .sb-lang-name { font-size: 9pt; color: {{ $c['text_main'] }}; font-weight: bold; margin-bottom: 3pt; }
        .sb-dot { display: inline-block; width: 7pt; height: 7pt; border-radius: 4pt; margin-right: 3pt; }
        .sb-dot-on  { background: {{ $c['accent'] }}; }
        .sb-dot-off { background: {{ $c['border'] }}; }
    </style>
</head>
<body>

@php
    $photoUrl = isset($photoDataUri) && $photoDataUri ? $photoDataUri : null;
    if (!$photoUrl) {
        $photoDisk = Storage::disk(config('filesystems.default'));
        $photoPath = !empty($resume->photo_sizes['medium'])
            ? $resume->photo_sizes['medium']
            : ($resume->photo ?: null);
        if ($photoPath) {
            try {
                $imageData = $photoDisk->get($photoPath);
                $mimeType  = $photoDisk->mimeType($photoPath) ?: 'image/jpeg';
                $photoUrl  = 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
            } catch (\Exception $e) {
                $photoUrl = null;
            }
        }
    }
@endphp

<table class="page" width="100%" cellpadding="0" cellspacing="0">

    {{-- ── HEADER ── --}}
    <tr>
        <td class="header-cell" colspan="2">
            <table class="header-inner" cellpadding="0" cellspacing="0">
                <tr>
                    {{-- Photo + name + title --}}
                    <td class="header-left">
                        <table class="identity-wrap" cellpadding="0" cellspacing="0">
                            <tr>
                                @if($photoUrl)
                                <td class="identity-photo-td">
                                    <img src="{{ $photoUrl }}" class="photo" alt="">
                                </td>
                                @endif
                                <td class="identity-text-td">
                                    <div class="resume-name">{{ $resume->full_name }}</div>
                                    @if($resume->title)
                                    <div class="resume-title">{{ $resume->title }}</div>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>

                    {{-- Contact --}}
                    <td class="header-right">
                        @if($resume->email)
                        <div class="hc-item">
                            <div class="hc-label">{{ __('resume.email') }}</div>
                            <div class="hc-value">{{ $resume->email }}</div>
                        </div>
                        @endif
                        @if($resume->phone)
                        <div class="hc-item">
                            <div class="hc-label">{{ __('resume.phone') }}</div>
                            <div class="hc-value">{{ $resume->phone }}</div>
                        </div>
                        @endif
                        @if($resume->location)
                        <div class="hc-item">
                            <div class="hc-label">{{ __('resume.location') }}</div>
                            <div class="hc-value">{{ $resume->location }}</div>
                        </div>
                        @endif
                        @if($resume->linkedin_url)
                        <div class="hc-item">
                            <div class="hc-label">LinkedIn</div>
                            <div class="hc-value">{{ $resume->linkedin_url }}</div>
                        </div>
                        @endif
                        @if($resume->github_url)
                        <div class="hc-item">
                            <div class="hc-label">GitHub</div>
                            <div class="hc-value">{{ $resume->github_url }}</div>
                        </div>
                        @endif
                        @if($resume->portfolio_url)
                        <div class="hc-item">
                            <div class="hc-label">{{ __('resume.portfolio') }}</div>
                            <div class="hc-value">{{ $resume->portfolio_url }}</div>
                        </div>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- ── BODY ── --}}
    <tr>

        {{-- LEFT: main content --}}
        <td class="col-main">
            @php $firstSection = true; @endphp

            {{-- Summary --}}
            @if($resume->summary)
            <div class="section" @if($firstSection) style="margin-top:0" @endif>
            @php $firstSection = false; @endphp
                <div class="section-title">{{ __('resume.professional_summary') }}</div>
                <p class="summary">{!! nl2br(e($resume->summary)) !!}</p>
            </div>
            @endif

            {{-- Work Experience --}}
            @if($resume->workExperiences?->isNotEmpty())
            <div class="section" @if($firstSection) style="margin-top:0" @endif>
            @php $firstSection = false; @endphp
                <div class="section-title">{{ __('resume.work_experience') }}</div>
                @foreach($resume->workExperiences as $job)
                <div class="item">
                    <div class="item-head">
                        <div class="item-head-left">
                            <div class="item-title">{{ $job->job_title }}</div>
                            <div class="item-sub">{!! e($job->company_name) . ($job->location ? ' &middot; ' . e($job->location) : '') !!}</div>
                        </div>
                        <div class="item-head-right">
                            <span class="date-badge">
                                {{ \Carbon\Carbon::parse($job->start_date)->translatedFormat('M Y') }}&nbsp;&ndash;&nbsp;{{ $job->is_current ? __('resume.present') : ($job->end_date ? \Carbon\Carbon::parse($job->end_date)->translatedFormat('M Y') : '') }}
                            </span>
                        </div>
                    </div>
                    @if($job->description)
                    <div class="item-body">{!! nl2br(e($job->description)) !!}</div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            {{-- Education --}}
            @if($resume->educations?->isNotEmpty())
            <div class="section" @if($firstSection) style="margin-top:0" @endif>
            @php $firstSection = false; @endphp
                <div class="section-title">{{ __('resume.education') }}</div>
                @foreach($resume->educations as $edu)
                <div class="item">
                    <div class="item-head">
                        <div class="item-head-left">
                            <div class="item-title">{{ $edu->degree }}{{ $edu->field_of_study ? ' ' . __('resume.field_of_study_in') . ' ' . $edu->field_of_study : '' }}</div>
                            <div class="item-sub">{!! e($edu->institution_name) . ($edu->location ? ' &middot; ' . e($edu->location) : '') !!}</div>
                        </div>
                        @if($edu->graduation_year)
                        <div class="item-head-right">
                            <span class="date-badge">{{ $edu->graduation_year }}</span>
                        </div>
                        @endif
                    </div>
                    @if($edu->gpa)
                    <div class="item-body">{{ __('resume.gpa') }}: {{ number_format($edu->gpa, 2) }}</div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            {{-- Projects --}}
            @if($resume->projects?->isNotEmpty())
            <div class="section" @if($firstSection) style="margin-top:0" @endif>
            @php $firstSection = false; @endphp
                <div class="section-title">{{ __('resume.projects') }}</div>
                @foreach($resume->projects as $project)
                <div class="item">
                    <div class="item-title">{{ $project->name }}</div>
                    @if($project->description)
                    <div class="item-body">{!! nl2br(e($project->description)) !!}</div>
                    @endif
                    @if(!empty($project->technologies))
                    <div class="tags">
                        @foreach($project->technologies as $tech)
                        <span class="tag">{{ $tech }}</span>
                        @endforeach
                    </div>
                    @endif
                    @if($project->live_url || $project->github_url)
                    <div class="proj-links">
                        @if($project->live_url)<span>{{ $project->live_url }}</span>@endif
                        @if($project->live_url && $project->github_url)<span class="proj-link-sep"> &middot; </span>@endif
                        @if($project->github_url)<span>{{ $project->github_url }}</span>@endif
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            {{-- Certifications --}}
            @if($resume->certifications?->isNotEmpty())
            <div class="section" @if($firstSection) style="margin-top:0" @endif>
            @php $firstSection = false; @endphp
                <div class="section-title">{{ __('resume.certifications') }}</div>
                @foreach($resume->certifications as $cert)
                <div class="item">
                    <div class="item-head">
                        <div class="item-head-left">
                            <div class="cert-name">{{ $cert->name }}</div>
                            <div class="cert-meta">{{ $cert->issuing_organization }}</div>
                        </div>
                        @if($cert->issue_date)
                        <div class="item-head-right">
                            <span class="date-badge">{{ \Carbon\Carbon::parse($cert->issue_date)->translatedFormat('M Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Awards --}}
            @if($resume->awards?->isNotEmpty())
            <div class="section" @if($firstSection) style="margin-top:0" @endif>
            @php $firstSection = false; @endphp
                <div class="section-title">{{ __('resume.awards') }}</div>
                @foreach($resume->awards as $award)
                <div class="item">
                    <div class="item-head">
                        <div class="item-head-left">
                            <div class="item-title">{{ $award->title }}</div>
                            @if($award->issuer)<div class="item-sub">{{ $award->issuer }}</div>@endif
                        </div>
                        @if($award->date)
                        <div class="item-head-right">
                            <span class="date-badge">{{ \Carbon\Carbon::parse($award->date)->translatedFormat('M Y') }}</span>
                        </div>
                        @endif
                    </div>
                    @if($award->description)
                    <div class="item-body">{!! nl2br(e($award->description)) !!}</div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            {{-- Recommendations --}}
            @if($resume->recommendations?->isNotEmpty())
            <div class="section" @if($firstSection) style="margin-top:0" @endif>
            @php $firstSection = false; @endphp
                <div class="section-title">{{ __('resume.recommendations') }}</div>
                @foreach($resume->recommendations as $rec)
                <div class="rec-card">
                    <div class="rec-name">{{ $rec->full_name }}</div>
                    <div class="rec-meta">
                        @if($rec->title || $rec->company){{ implode(', ', array_filter([$rec->title, $rec->company])) }}@endif
                        @if($rec->email) &middot; {{ $rec->email }}@endif
                        @if($rec->phone) &middot; {{ $rec->phone }}@endif
                    </div>
                    @if($rec->recommendation)
                    <div class="rec-quote">&ldquo;{!! nl2br(e($rec->recommendation)) !!}&rdquo;</div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

        </td>{{-- /col-main --}}

        {{-- RIGHT: sidebar --}}
        <td class="col-sidebar">
            @php $firstSb = true; @endphp

            {{-- Skills --}}
            @if($resume->skills?->isNotEmpty())
            <div class="sb-heading" style="margin-top:{{ $firstSb ? '0' : '14pt' }}">{{ __('resume.skills') }}</div>
            @php $firstSb = false; @endphp
            @foreach($resume->skills->groupBy('category') as $category => $catSkills)
            <div class="sb-skill-group">
                <div class="sb-skill-group-name">{{ __('resume.skill_category_' . $category) }}</div>
                @foreach($catSkills as $skill)
                @php $w = match($skill->proficiency) { 'expert' => '100%', 'advanced' => '80%', 'intermediate' => '60%', 'basic' => '40%', default => '20%' }; @endphp
                <div class="sb-skill">
                    <div class="sb-skill-name">{{ $skill->name }}</div>
                    @if($showSkillLevels ?? true)
                    <div class="sb-track"><div class="sb-fill" style="width:{{ $w }};"></div></div>
                    @endif
                </div>
                @endforeach
            </div>
            @endforeach
            @endif

            {{-- Languages --}}
            @if($resume->languages?->isNotEmpty())
            <div class="sb-heading" style="margin-top:{{ $firstSb ? '0' : '14pt' }}">{{ __('resume.languages') }}</div>
            @php $firstSb = false; @endphp
            @foreach($resume->languages as $lang)
            @php
                $filled   = ['elementary' => 1, 'limited_working' => 2, 'professional_working' => 3, 'full_professional' => 4, 'native_bilingual' => 5][$lang->proficiency] ?? 1;
                $langKey   = 'resume.spoken_language_' . $lang->language;
                $langLabel = __($langKey) !== $langKey ? __($langKey) : $lang->language;
            @endphp
            <div class="sb-lang">
                <div class="sb-lang-name">{{ $langLabel }}</div>
                @if($showLanguageLevels ?? true)
                @for($d = 1; $d <= 5; $d++)
                <span class="sb-dot {{ $d <= $filled ? 'sb-dot-on' : 'sb-dot-off' }}"></span>
                @endfor
                @endif
            </div>
            @endforeach
            @endif

        </td>{{-- /col-sidebar --}}
    </tr>
</table>
</body>
</html>
