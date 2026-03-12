<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $resume->full_name }}</title>
    <style>
        @@page { margin: 0; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            color: #222;
            background: #fff;
        }

        /* ─────────────────────────────────────────────
           PAGE: two-column table layout
        ───────────────────────────────────────────── */
        .page {
            width: 100%;
        }

        .col-left {
            width: 190pt;
            background: #1a3558;
            padding: 28pt 14pt 40pt 16pt;
            vertical-align: top;
        }

        .col-right {
            padding: 28pt 22pt 40pt 22pt;
            vertical-align: top;
            background: #ffffff;
        }

        /* ─────────────────────────────────────────────
           SIDEBAR – identity
        ───────────────────────────────────────────── */
        .sb-name {
            font-size: 17pt;
            font-weight: bold;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 4pt;
        }

        .sb-photo {
            width: 100pt;
            height: 100pt;
            border-radius: 50pt;
            border: 2pt solid #2e5080;
            margin-bottom: 10pt;
            display: block;
        }

        .sb-role {
            font-size: 7.5pt;
            color: #7eb8f7;
            text-transform: uppercase;
            letter-spacing: 1.3pt;
            padding-bottom: 14pt;
            border-bottom: 0.5pt solid #2e5080;
        }

        /* ─────────────────────────────────────────────
           SIDEBAR – section headings
        ───────────────────────────────────────────── */
        .sb-heading {
            font-size: 7pt;
            font-weight: bold;
            color: #7eb8f7;
            text-transform: uppercase;
            letter-spacing: 1.2pt;
            margin-top: 16pt;
            margin-bottom: 8pt;
        }

        /* ─────────────────────────────────────────────
           SIDEBAR – contact / link rows
        ───────────────────────────────────────────── */
        .sb-item {
            margin-bottom: 7pt;
        }
        .sb-item-label {
            font-size: 6.5pt;
            color: #7eb8f7;
            text-transform: uppercase;
            letter-spacing: 0.6pt;
            margin-bottom: 1pt;
        }
        .sb-item-value {
            font-size: 8pt;
            color: #d4e6ff;
            word-break: break-all;
            line-height: 1.4;
        }

        /* ─────────────────────────────────────────────
           SIDEBAR – skill bars
        ───────────────────────────────────────────── */
        .sb-skill-group { margin-bottom: 9pt; }
        .sb-skill-group-name {
            font-size: 7pt;
            font-weight: bold;
            color: #b3d4ff;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
            margin-bottom: 5pt;
        }
        .sb-skill { margin-bottom: 5pt; }
        .sb-skill-name {
            font-size: 8pt;
            color: #dbeafe;
            margin-bottom: 2pt;
        }
        .sb-track {
            background: #2e5080;
            border-radius: 3pt;
            height: 4pt;
            width: 100%;
        }
        .sb-fill {
            background: #5b9bd5;
            border-radius: 3pt;
            height: 4pt;
        }

        /* ─────────────────────────────────────────────
           SIDEBAR – language dots
        ───────────────────────────────────────────── */
        .sb-lang { margin-bottom: 7pt; }
        .sb-lang-name {
            font-size: 8.5pt;
            color: #dbeafe;
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
        .sb-dot-on  { background: #5b9bd5; }
        .sb-dot-off { background: #2e5080; }

        /* ─────────────────────────────────────────────
           MAIN – sections
        ───────────────────────────────────────────── */
        .section { margin-bottom: 16pt; }

        .section-title {
            font-size: 8.5pt;
            font-weight: bold;
            color: #1a3558;
            text-transform: uppercase;
            letter-spacing: 1.3pt;
            border-bottom: 1.5pt solid #1a3558;
            padding-bottom: 3pt;
            margin-bottom: 10pt;
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
            background: #1a3558;
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
            background: #eef5ff;
            border: 0.5pt solid #b3cff5;
            color: #1a4f85;
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
            background: #f5f9ff;
            border-left: 3pt solid #3b82f6;
            border-radius: 0 3pt 3pt 0;
            padding: 8pt 10pt;
            margin-bottom: 9pt;
        }
        .rec-name {
            font-size: 9.5pt;
            font-weight: bold;
            color: #1a3558;
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
<table class="page" width="100%" cellpadding="0" cellspacing="0"><tr>

{{-- ═══════════════════════════════════════
     SIDEBAR
═══════════════════════════════════════ --}}
<td class="col-left">

    @php
        $photoUrl = null;
        $photoDisk = Storage::disk(config('filesystems.default'));
        $photoPath = !empty($resume->photo_sizes['medium'])
            ? $resume->photo_sizes['medium']
            : ($resume->photo ?: null);

        if ($photoPath) {
            if (method_exists($photoDisk, 'temporaryUrl')) {
                try {
                    $photoUrl = $photoDisk->temporaryUrl($photoPath, now()->addMinutes(10));
                } catch (\Exception $e) {
                    $photoUrl = $photoDisk->url($photoPath);
                }
            } else {
                $photoUrl = $photoDisk->url($photoPath);
            }
        }
    @endphp
    @if($photoUrl)
    <img src="{{ $photoUrl }}" class="sb-photo" alt="">
    @endif

    <div class="sb-name">{{ $resume->full_name }}</div>
    @if($resume->title)
    <div class="sb-role">{{ $resume->title }}</div>
    @else
    <div style="padding-bottom:14pt;border-bottom:0.5pt solid #2e5080;"></div>
    @endif

    {{-- Contact --}}
    <div class="sb-heading">{{ __('resume_pdf.contact') }}</div>

    @if($resume->email)
    <div class="sb-item">
        <div class="sb-item-label">{{ __('resume_pdf.email') }}</div>
        <div class="sb-item-value">{{ $resume->email }}</div>
    </div>
    @endif

    @if($resume->phone)
    <div class="sb-item">
        <div class="sb-item-label">{{ __('resume_pdf.phone') }}</div>
        <div class="sb-item-value">{{ $resume->phone }}</div>
    </div>
    @endif

    @if($resume->location)
    <div class="sb-item">
        <div class="sb-item-label">{{ __('resume_pdf.location') }}</div>
        <div class="sb-item-value">{{ $resume->location }}</div>
    </div>
    @endif

    {{-- Links --}}
    @if($resume->linkedin_url || $resume->github_url || $resume->portfolio_url)
    <div class="sb-heading">{{ __('resume_pdf.links') }}</div>

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
        <div class="sb-item-label">{{ __('resume_pdf.portfolio') }}</div>
        <div class="sb-item-value">{{ $resume->portfolio_url }}</div>
    </div>
    @endif
    @endif

    {{-- Skills --}}
    @if($resume->skills?->isNotEmpty())
    <div class="sb-heading">{{ __('resume_pdf.skills') }}</div>

    @foreach($resume->skills->groupBy('category') as $category => $catSkills)
    <div class="sb-skill-group">
        <div class="sb-skill-group-name">{{ $category }}</div>
        @foreach($catSkills as $skill)
        @php $w = match($skill->proficiency) { 'expert' => '90%', 'intermediate' => '60%', default => '30%' }; @endphp
        <div class="sb-skill">
            <div class="sb-skill-name">{{ $skill->name }}</div>
            <div class="sb-track"><div class="sb-fill" style="width:{{ $w }};"></div></div>
        </div>
        @endforeach
    </div>
    @endforeach
    @endif

    {{-- Languages --}}
    @if($resume->languages?->isNotEmpty())
    <div class="sb-heading">{{ __('resume_pdf.languages') }}</div>

    @foreach($resume->languages as $lang)
    @php
        $filled = ['basic' => 1, 'conversational' => 2, 'fluent' => 3, 'native' => 4][$lang->proficiency] ?? 1;
    @endphp
    <div class="sb-lang">
        <div class="sb-lang-name">{{ $lang->language }}</div>
        @for($d = 1; $d <= 4; $d++)
        <span class="sb-dot {{ $d <= $filled ? 'sb-dot-on' : 'sb-dot-off' }}"></span>
        @endfor
    </div>
    @endforeach
    @endif

</td>{{-- /col-left --}}

{{-- ═══════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════ --}}
<td class="col-right">

    {{-- Summary --}}
    @if($resume->summary)
    <div class="section">
        <div class="section-title">{{ __('resume_pdf.professional_summary') }}</div>
        <p class="summary">{{ $resume->summary }}</p>
    </div>
    @endif

    {{-- Work Experience --}}
    @if($resume->workExperiences?->isNotEmpty())
    <div class="section">
        <div class="section-title">{{ __('resume_pdf.work_experience') }}</div>
        @foreach($resume->workExperiences as $job)
        <div class="item">
            <div class="item-head">
                <div class="item-head-left">
                    <div class="item-title">{{ $job->job_title }}</div>
                    <div class="item-sub">{{ $job->company_name }}{{ $job->location ? ' &middot; ' . $job->location : '' }}</div>
                </div>
                <div class="item-head-right">
                    <span class="date-badge">
                        {{ \Carbon\Carbon::parse($job->start_date)->format('M Y') }}&nbsp;&ndash;&nbsp;{{ $job->is_current ? __('resume_pdf.present') : ($job->end_date ? \Carbon\Carbon::parse($job->end_date)->format('M Y') : '') }}
                    </span>
                </div>
            </div>
            @if($job->description)
            <div class="item-body">{{ $job->description }}</div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    {{-- Education --}}
    @if($resume->educations?->isNotEmpty())
    <div class="section">
        <div class="section-title">{{ __('resume_pdf.education') }}</div>
        @foreach($resume->educations as $edu)
        <div class="item">
            <div class="item-head">
                <div class="item-head-left">
                    <div class="item-title">{{ $edu->degree }}{{ $edu->field_of_study ? ' ' . __('resume_pdf.field_of_study_in') . ' ' . $edu->field_of_study : '' }}</div>
                    <div class="item-sub">{{ $edu->institution_name }}{{ $edu->location ? ' &middot; ' . $edu->location : '' }}</div>
                </div>
                @if($edu->graduation_year)
                <div class="item-head-right">
                    <span class="date-badge">{{ $edu->graduation_year }}</span>
                </div>
                @endif
            </div>
            @if($edu->gpa)
            <div class="item-body">{{ __('resume_pdf.gpa') }}: {{ number_format($edu->gpa, 2) }}</div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    {{-- Projects --}}
    @if($resume->projects?->isNotEmpty())
    <div class="section">
        <div class="section-title">{{ __('resume_pdf.projects') }}</div>
        @foreach($resume->projects as $project)
        <div class="item">
            <div class="item-title">{{ $project->name }}</div>
            @if($project->description)
            <div class="item-body">{{ $project->description }}</div>
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
        <div class="section-title">{{ __('resume_pdf.certifications') }}</div>
        @foreach($resume->certifications as $cert)
        <div class="item">
            <div class="item-head">
                <div class="item-head-left">
                    <div class="cert-name">{{ $cert->name }}</div>
                    <div class="cert-meta">{{ $cert->issuing_organization }}</div>
                </div>
                @if($cert->issue_date)
                <div class="item-head-right">
                    <span class="date-badge">{{ \Carbon\Carbon::parse($cert->issue_date)->format('M Y') }}</span>
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
        <div class="section-title">{{ __('resume_pdf.awards') }}</div>
        @foreach($resume->awards as $award)
        <div class="item">
            <div class="item-head">
                <div class="item-head-left">
                    <div class="item-title">{{ $award->title }}</div>
                    @if($award->issuer)<div class="item-sub">{{ $award->issuer }}</div>@endif
                </div>
                @if($award->date)
                <div class="item-head-right">
                    <span class="date-badge">{{ \Carbon\Carbon::parse($award->date)->format('M Y') }}</span>
                </div>
                @endif
            </div>
            @if($award->description)
            <div class="item-body">{{ $award->description }}</div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    {{-- Recommendations --}}
    @if($resume->recommendations?->isNotEmpty())
    <div class="section">
        <div class="section-title">{{ __('resume_pdf.recommendations') }}</div>
        @foreach($resume->recommendations as $rec)
        <div class="rec-card">
            <div class="rec-name">{{ $rec->full_name }}</div>
            <div class="rec-meta">
                @if($rec->title || $rec->company){{ implode(', ', array_filter([$rec->title, $rec->company])) }}@endif
                @if($rec->email) &middot; {{ $rec->email }}@endif
                @if($rec->phone) &middot; {{ $rec->phone }}@endif
            </div>
            @if($rec->recommendation)
            <div class="rec-quote">&ldquo;{{ $rec->recommendation }}&rdquo;</div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

</td>{{-- /col-right --}}
</tr></table>{{-- /page --}}
</body>
</html>