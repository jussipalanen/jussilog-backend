@php
$palettes = [
    'green'  => ['sb_bg'=>'#14532d','sb_border'=>'#166534','sb_accent'=>'#86efac','sb_text'=>'#dcfce7','sb_group'=>'#bbf7d0','sb_fill'=>'#22c55e','sb_name'=>'#ffffff','main_accent'=>'#14532d','tag_bg'=>'#f0fdf4','tag_border'=>'#86efac','tag_color'=>'#14532d','rec_bg'=>'#f0fdf4','rec_border'=>'#22c55e'],
    'blue'   => ['sb_bg'=>'#1e3a5f','sb_border'=>'#1d4ed8','sb_accent'=>'#93c5fd','sb_text'=>'#dbeafe','sb_group'=>'#bfdbfe','sb_fill'=>'#3b82f6','sb_name'=>'#ffffff','main_accent'=>'#1e3a5f','tag_bg'=>'#eff6ff','tag_border'=>'#93c5fd','tag_color'=>'#1e3a5f','rec_bg'=>'#eff6ff','rec_border'=>'#3b82f6'],
    'red'    => ['sb_bg'=>'#7f1d1d','sb_border'=>'#991b1b','sb_accent'=>'#fca5a5','sb_text'=>'#fee2e2','sb_group'=>'#fecaca','sb_fill'=>'#ef4444','sb_name'=>'#ffffff','main_accent'=>'#7f1d1d','tag_bg'=>'#fff5f5','tag_border'=>'#fca5a5','tag_color'=>'#7f1d1d','rec_bg'=>'#fff5f5','rec_border'=>'#ef4444'],
    'yellow' => ['sb_bg'=>'#78350f','sb_border'=>'#92400e','sb_accent'=>'#fcd34d','sb_text'=>'#fef3c7','sb_group'=>'#fde68a','sb_fill'=>'#f59e0b','sb_name'=>'#ffffff','main_accent'=>'#78350f','tag_bg'=>'#fffbeb','tag_border'=>'#fcd34d','tag_color'=>'#78350f','rec_bg'=>'#fffbeb','rec_border'=>'#f59e0b'],
    'cyan'   => ['sb_bg'=>'#164e63','sb_border'=>'#155e75','sb_accent'=>'#67e8f9','sb_text'=>'#cffafe','sb_group'=>'#a5f3fc','sb_fill'=>'#06b6d4','sb_name'=>'#ffffff','main_accent'=>'#164e63','tag_bg'=>'#ecfeff','tag_border'=>'#67e8f9','tag_color'=>'#164e63','rec_bg'=>'#ecfeff','rec_border'=>'#06b6d4'],
    'orange' => ['sb_bg'=>'#7c2d12','sb_border'=>'#9a3412','sb_accent'=>'#fdba74','sb_text'=>'#fed7aa','sb_group'=>'#fed7aa','sb_fill'=>'#f97316','sb_name'=>'#ffffff','main_accent'=>'#7c2d12','tag_bg'=>'#fff7ed','tag_border'=>'#fdba74','tag_color'=>'#7c2d12','rec_bg'=>'#fff7ed','rec_border'=>'#f97316'],
    'violet' => ['sb_bg'=>'#4c1d95','sb_border'=>'#5b21b6','sb_accent'=>'#c4b5fd','sb_text'=>'#ede9fe','sb_group'=>'#ddd6fe','sb_fill'=>'#8b5cf6','sb_name'=>'#ffffff','main_accent'=>'#4c1d95','tag_bg'=>'#f5f3ff','tag_border'=>'#c4b5fd','tag_color'=>'#4c1d95','rec_bg'=>'#f5f3ff','rec_border'=>'#8b5cf6'],
    'black'  => ['sb_bg'=>'#111827','sb_border'=>'#374151','sb_accent'=>'#9ca3af','sb_text'=>'#e5e7eb','sb_group'=>'#d1d5db','sb_fill'=>'#6b7280','sb_name'=>'#f9fafb','main_accent'=>'#111827','tag_bg'=>'#f3f4f6','tag_border'=>'#9ca3af','tag_color'=>'#111827','rec_bg'=>'#f3f4f6','rec_border'=>'#6b7280'],
    'white'  => ['sb_bg'=>'#f1f5f9','sb_border'=>'#cbd5e1','sb_accent'=>'#64748b','sb_text'=>'#1e293b','sb_group'=>'#475569','sb_fill'=>'#334155','sb_name'=>'#0f172a','main_accent'=>'#0f172a','tag_bg'=>'#f8fafc','tag_border'=>'#cbd5e1','tag_color'=>'#0f172a','rec_bg'=>'#f8fafc','rec_border'=>'#334155'],
    'grey'   => ['sb_bg'=>'#374151','sb_border'=>'#4b5563','sb_accent'=>'#d1d5db','sb_text'=>'#f3f4f6','sb_group'=>'#e5e7eb','sb_fill'=>'#9ca3af','sb_name'=>'#ffffff','main_accent'=>'#374151','tag_bg'=>'#f9fafb','tag_border'=>'#d1d5db','tag_color'=>'#374151','rec_bg'=>'#f9fafb','rec_border'=>'#9ca3af'],
];
$c = $palettes[$theme ?? 'green'] ?? $palettes['green'];
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
            font-family: Arial, 'Helvetica Neue', sans-serif;
            font-size: 9pt;
            color: #222;
            /* Sidebar color fills the entire left strip on EVERY page */
            background: linear-gradient(to right, {{ $c['sb_bg'] }} 190pt, #ffffff 190pt);
            background-attachment: fixed;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ─────────────────────────────────────────────
           PAGE: two-column table layout
        ───────────────────────────────────────────── */
        .page {
            width: 100%;
        }

        .col-left {
            width: 190pt;
            background: transparent;
            padding: 28pt 14pt 20pt 16pt;
            vertical-align: top;
            -webkit-box-decoration-break: clone;
            box-decoration-break: clone;
        }

        .col-right {
            padding: 28pt 22pt 20pt 22pt;
            vertical-align: top;
            background: #ffffff;
            -webkit-box-decoration-break: clone;
            box-decoration-break: clone;
        }

        /* ─────────────────────────────────────────────
           SIDEBAR – identity
        ───────────────────────────────────────────── */
        .sb-name {
            font-size: 17pt;
            font-weight: bold;
            color: {{ $c['sb_name'] }};
            line-height: 1.2;
            margin-bottom: 4pt;
        }

        .sb-photo {
            width: 100pt;
            height: 100pt;
            border-radius: 50pt;
            border: 2pt solid {{ $c['sb_border'] }};
            margin-bottom: 10pt;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        .sb-role {
            font-size: 7.5pt;
            color: {{ $c['sb_accent'] }};
            text-transform: uppercase;
            letter-spacing: 1.3pt;
            padding-bottom: 14pt;
            border-bottom: 0.5pt solid {{ $c['sb_border'] }};
        }

        /* ─────────────────────────────────────────────
           SIDEBAR – section wrapper
        ───────────────────────────────────────────── */
        .sb-section {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        /* ─────────────────────────────────────────────
           SIDEBAR – section headings
        ───────────────────────────────────────────── */
        .sb-heading {
            font-size: 7pt;
            font-weight: bold;
            color: {{ $c['sb_accent'] }};
            text-transform: uppercase;
            letter-spacing: 1.2pt;
            margin-top: 16pt;
            margin-bottom: 8pt;
            break-after: avoid;
            page-break-after: avoid;
        }

        /* ─────────────────────────────────────────────
           SIDEBAR – contact / link rows
        ───────────────────────────────────────────── */
        .sb-item {
            margin-bottom: 7pt;
            break-inside: avoid;
            page-break-inside: avoid;
        }
        .sb-item-label {
            font-size: 6.5pt;
            color: {{ $c['sb_accent'] }};
            text-transform: uppercase;
            letter-spacing: 0.6pt;
            margin-bottom: 1pt;
        }
        .sb-item-value {
            font-size: 8pt;
            color: {{ $c['sb_text'] }};
            word-break: break-all;
            line-height: 1.4;
        }

        /* ─────────────────────────────────────────────
           SIDEBAR – skill bars
        ───────────────────────────────────────────── */
        .sb-skill-group {
            margin-bottom: 9pt;
            break-inside: avoid;
            page-break-inside: avoid;
        }
        .sb-skill-group-name {
            font-size: 7pt;
            font-weight: bold;
            color: {{ $c['sb_group'] }};
            text-transform: uppercase;
            letter-spacing: 0.5pt;
            margin-bottom: 5pt;
        }
        .sb-skill { margin-bottom: 5pt; }
        .sb-skill-name {
            font-size: 8pt;
            color: {{ $c['sb_text'] }};
            margin-bottom: 2pt;
        }
        .sb-track {
            background: {{ $c['sb_border'] }};
            border-radius: 3pt;
            height: 4pt;
            width: 100%;
        }
        .sb-fill {
            background: {{ $c['sb_fill'] }};
            border-radius: 3pt;
            height: 4pt;
        }

        /* ─────────────────────────────────────────────
           SIDEBAR – language dots
        ───────────────────────────────────────────── */
        .sb-lang {
            margin-bottom: 7pt;
            break-inside: avoid;
            page-break-inside: avoid;
        }
        .sb-lang-name {
            font-size: 8.5pt;
            color: {{ $c['sb_text'] }};
            font-weight: bold;
            margin-bottom: 3pt;
        }
        .sb-dot {
            display: inline-block;
            width: 7pt;
            height: 7pt;
            border-radius: 4pt;
            margin-right: 3pt;
        }
        .sb-dot-on  { background: {{ $c['sb_fill'] }}; }
        .sb-dot-off { background: {{ $c['sb_border'] }}; }

        /* ─────────────────────────────────────────────
           MAIN – sections
        ───────────────────────────────────────────── */
        .section { margin-bottom: 14pt; break-inside: auto; }
        .section:last-child { margin-bottom: 0; }

        .section-title {
            font-size: 8.5pt;
            font-weight: bold;
            color: {{ $c['main_accent'] }};
            text-transform: uppercase;
            letter-spacing: 1.3pt;
            border-bottom: 1.5pt solid {{ $c['main_accent'] }};
            padding-bottom: 3pt;
            margin-bottom: 10pt;
            page-break-after: avoid;
            break-after: avoid;
        }

        /* ─────────────────────────────────────────────
           MAIN – summary
        ───────────────────────────────────────────── */
        .summary {
            font-size: 9pt;
            color: #374151;
            line-height: 1.65;
        }

        /* ─────────────────────────────────────────────
           MAIN – generic items
        ───────────────────────────────────────────── */
        .item {
            margin-bottom: 10pt;
            padding-bottom: 9pt;
            border-bottom: 0.5pt solid #e5ecf5;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .item:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }

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
            color: #111827;
        }
        .item-sub {
            font-size: 8pt;
            color: #5a6a7a;
            margin-top: 1.5pt;
        }

        .date-badge {
            display: inline-block;
            background: {{ $c['main_accent'] }};
            color: #ffffff;
            font-size: 7.5pt;
            padding: 2pt 6pt;
            border-radius: 2pt;
            white-space: nowrap;
        }

        .item-body {
            margin-top: 5pt;
            font-size: 8.5pt;
            color: #374151;
            line-height: 1.6;
            white-space: pre-line;
        }

        /* ─────────────────────────────────────────────
           MAIN – tech tags
        ───────────────────────────────────────────── */
        .tags { margin-top: 5pt; }
        .tag {
            display: inline-block;
            background: {{ $c['tag_bg'] }};
            border: 0.5pt solid {{ $c['tag_border'] }};
            color: {{ $c['tag_color'] }};
            border-radius: 2pt;
            font-size: 7.5pt;
            padding: 1.5pt 5pt;
            margin: 1pt 2pt 1pt 0;
        }

        /* ─────────────────────────────────────────────
           MAIN – project links
        ───────────────────────────────────────────── */
        .proj-links {
            margin-top: 4pt;
            font-size: 8pt;
            color: #2563eb;
        }

        /* ─────────────────────────────────────────────
           MAIN – recommendation cards
        ───────────────────────────────────────────── */
        .rec-card {
            background: {{ $c['rec_bg'] }};
            border-left: 3pt solid {{ $c['rec_border'] }};
            border-radius: 0 3pt 3pt 0;
            padding: 8pt 10pt;
            margin-bottom: 9pt;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .rec-name {
            font-size: 9.5pt;
            font-weight: bold;
            color: {{ $c['tag_color'] }};
        }
        .rec-meta {
            font-size: 8pt;
            color: #6b7280;
            margin-top: 1pt;
            margin-bottom: 5pt;
        }
        .rec-quote {
            font-size: 8.5pt;
            color: #374151;
            font-style: italic;
            line-height: 1.6;
        }

        /* ─────────────────────────────────────────────
           MAIN – certifications
        ───────────────────────────────────────────── */
        .cert-name {
            font-size: 9.5pt;
            font-weight: bold;
            color: #111827;
        }
        .cert-meta {
            font-size: 8pt;
            color: #6b7280;
            margin-top: 1pt;
        }
    </style>
</head>
<body>

@php
    // $photoDataUri may be passed directly (e.g. public export with base64 photo).
    // Fall back to reading from the storage disk for authenticated exports.
    $photoUrl = isset($photoDataUri) && $photoDataUri ? $photoDataUri : null;
    if (!$photoUrl) {
        $photoDisk = Storage::disk(config('filesystems.default'));
        $photoPath = !empty($resume->photo_sizes['medium'])
            ? $resume->photo_sizes['medium']
            : ($resume->photo ?: null);

        // DomPDF cannot fetch external URLs (e.g. GCS), so read the file and
        // embed it as a base64 data URI instead.
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

<table class="page" width="100%" cellpadding="0" cellspacing="0"><tr><td class="col-left">
    @if($photoUrl)
    <img src="{{ $photoUrl }}" class="sb-photo" alt="">
    @endif

    <div class="sb-name">{{ $resume->full_name }}</div>
    @if($resume->title)
    <div class="sb-role">{{ $resume->title }}</div>
    @else
    <div style="padding-bottom:14pt;border-bottom:0.5pt solid {{ $c['sb_border'] }};"></div>
    @endif

    {{-- Contact --}}
    <div class="sb-section">
    <div class="sb-heading">{{ __('resume.contact') }}</div>

    @if($resume->email)
    <div class="sb-item">
        <div class="sb-item-label">{{ __('resume.email') }}</div>
        <div class="sb-item-value">{{ $resume->email }}</div>
    </div>
    @endif

    @if($resume->phone)
    <div class="sb-item">
        <div class="sb-item-label">{{ __('resume.phone') }}</div>
        <div class="sb-item-value">{{ $resume->phone }}</div>
    </div>
    @endif

    @if($resume->location)
    <div class="sb-item">
        <div class="sb-item-label">{{ __('resume.location') }}</div>
        <div class="sb-item-value">{{ $resume->location }}</div>
    </div>
    @endif
    </div>{{-- /sb-section contact --}}

    {{-- Links --}}
    @if($resume->linkedin_url || $resume->github_url || $resume->portfolio_url)
    <div class="sb-section">
    <div class="sb-heading">{{ __('resume.links') }}</div>

    @if($resume->linkedin_url)
    <div class="sb-item">
        <div class="sb-item-label">LinkedIn</div>
        <div class="sb-item-value">{{ $resume->linkedin_url }}</div>
    </div>
    @endif

    @if($resume->github_url)
    <div class="sb-item">
        <div class="sb-item-label">GitHub</div>
        <div class="sb-item-value">{{ $resume->github_url }}</div>
    </div>
    @endif

    @if($resume->portfolio_url)
    <div class="sb-item">
        <div class="sb-item-label">{{ __('resume.portfolio') }}</div>
        <div class="sb-item-value">{{ $resume->portfolio_url }}</div>
    </div>
    @endif
    </div>{{-- /sb-section links --}}
    @endif

    {{-- Skills --}}
    @if($resume->skills?->isNotEmpty())
    <div class="sb-section">
    <div class="sb-heading">{{ __('resume.skills') }}</div>

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
    </div>{{-- /sb-section skills --}}
    @endif

    {{-- Languages --}}
    @if($resume->languages?->isNotEmpty())
    <div class="sb-section">
    <div class="sb-heading">{{ __('resume.languages') }}</div>

    @foreach($resume->languages as $lang)
    @php
        $filled = ['elementary' => 1, 'limited_working' => 2, 'professional_working' => 3, 'full_professional' => 4, 'native_bilingual' => 5][$lang->proficiency] ?? 1;
        $langKey = 'resume.spoken_language_' . $lang->language;
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
    </div>{{-- /sb-section languages --}}
    @endif

</td>{{-- /col-left --}}<td class="col-right">

    {{-- Summary --}}
    @if($resume->summary)
    <div class="section">
        <div class="section-title">{{ __('resume.professional_summary') }}</div>
        <p class="summary">{!! nl2br(e($resume->summary)) !!}</p>
    </div>
    @endif

    {{-- Work Experience --}}
    @if($resume->workExperiences?->isNotEmpty())
    <div class="section">
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
    <div class="section">
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
    <div class="section">
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
                @if($project->live_url)<span>{{ $project->live_url }}</span> @endif
                @if($project->github_url)<span>{{ $project->github_url }}</span>@endif
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    {{-- Certifications --}}
    @if($resume->certifications?->isNotEmpty())
    <div class="section">
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
    <div class="section">
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
    <div class="section">
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

</td>{{-- /col-right --}}
</tr></table>{{-- /page --}}
</body>
</html>