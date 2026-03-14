<?php

namespace Database\Seeders;

use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResumeSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'juzapala+superadmin@gmail.com')->first();

        if (!$user) {
            $this->command->warn('ResumeSeeder: admin user not found, skipping.');
            return;
        }

        // Skip if a resume for this user already exists
        if (Resume::where('user_id', $user->id)->exists()) {
            $this->command->info('ResumeSeeder: resume for user #' . $user->id . ' already exists, skipping.');
            return;
        }

        $resume = Resume::create([
            'user_id'       => $user->id,
            'title'         => 'Full-Stack Developer CV',
            'full_name'     => 'Jussi Palanen',
            'email'         => 'jussi@example.com',
            'phone'         => '+358401234567',
            'location'      => 'Helsinki, Finland',
            'linkedin_url'  => 'https://linkedin.com/in/jussipalanen',
            'github_url'    => 'https://github.com/jussipalanen',
            'portfolio_url' => 'https://jussipalanen.fi',
            'summary'       => 'Passionate full-stack developer with 7+ years of experience building scalable web applications. '
                             . 'Specialised in Laravel, Vue.js, and cloud-native architectures on Google Cloud Platform. '
                             . 'Strong advocate for clean code, test-driven development, and continuous delivery.',
            'language'      => 'en',
        ]);

        // ── Work Experiences ──────────────────────────────────────────────────
        $resume->workExperiences()->createMany([
            [
                'job_title'    => 'Senior Full-Stack Developer',
                'company_name' => 'TechNord Oy',
                'location'     => 'Helsinki, Finland',
                'start_date'   => '2021-03-01',
                'end_date'     => null,
                'is_current'   => true,
                'description'  => "Lead developer for a SaaS platform serving 50 000+ users.\n"
                                . "• Migrated monolith to microservices on GCP Cloud Run.\n"
                                . "• Reduced API response times by 60 % through query optimisation and Redis caching.\n"
                                . "• Mentored a team of four junior developers.",
                'sort_order'   => 0,
            ],
            [
                'job_title'    => 'Full-Stack Developer',
                'company_name' => 'Digicraft Helsinki',
                'location'     => 'Helsinki, Finland',
                'start_date'   => '2018-06-01',
                'end_date'     => '2021-02-28',
                'is_current'   => false,
                'description'  => "Built and maintained e-commerce solutions for Finnish SMEs.\n"
                                . "• Developed custom Laravel + Vue.js storefronts integrated with Stripe and Klarna.\n"
                                . "• Introduced CI/CD pipelines with GitHub Actions, cutting release cycles from weekly to daily.",
                'sort_order'   => 1,
            ],
            [
                'job_title'    => 'Junior Web Developer',
                'company_name' => 'Freelance',
                'location'     => 'Tampere, Finland',
                'start_date'   => '2016-09-01',
                'end_date'     => '2018-05-31',
                'is_current'   => false,
                'description'  => 'Delivered WordPress and Laravel projects for local businesses. '
                                . 'Responsible for front-end development, REST API integration, and client communication.',
                'sort_order'   => 2,
            ],
        ]);

        // ── Education ─────────────────────────────────────────────────────────
        $resume->educations()->createMany([
            [
                'degree'           => 'Bachelor of Engineering',
                'field_of_study'   => 'Information Technology',
                'institution_name' => 'Tampere University of Applied Sciences',
                'location'         => 'Tampere, Finland',
                'graduation_year'  => 2018,
                'gpa'              => 4.2,
                'sort_order'       => 0,
            ],
        ]);

        // ── Skills ────────────────────────────────────────────────────────────
        $resume->skills()->createMany([
            ['category' => 'programming_languages', 'name' => 'PHP',        'proficiency' => 'expert',        'sort_order' => 0],
            ['category' => 'programming_languages', 'name' => 'JavaScript', 'proficiency' => 'expert',        'sort_order' => 1],
            ['category' => 'programming_languages', 'name' => 'TypeScript', 'proficiency' => 'intermediate',  'sort_order' => 2],
            ['category' => 'query_languages',        'name' => 'SQL',        'proficiency' => 'expert',        'sort_order' => 0],

            ['category' => 'frameworks',   'name' => 'Laravel',    'proficiency' => 'expert',        'sort_order' => 0],
            ['category' => 'frameworks',   'name' => 'Vue.js',     'proficiency' => 'expert',        'sort_order' => 1],
            ['category' => 'frameworks',   'name' => 'React',      'proficiency' => 'intermediate',  'sort_order' => 2],
            ['category' => 'frameworks',   'name' => 'Tailwind CSS', 'proficiency' => 'expert',      'sort_order' => 3],

            ['category' => 'development_tools', 'name' => 'Docker',         'proficiency' => 'expert',  'sort_order' => 0],
            ['category' => 'development_tools', 'name' => 'Git',            'proficiency' => 'expert',  'sort_order' => 1],
            ['category' => 'development_tools', 'name' => 'GitHub Actions', 'proficiency' => 'expert',  'sort_order' => 2],
            ['category' => 'development_tools', 'name' => 'Postman',        'proficiency' => 'expert',  'sort_order' => 3],

            ['category' => 'cloud_platforms', 'name' => 'Google Cloud Platform', 'proficiency' => 'expert',       'sort_order' => 0],
            ['category' => 'cloud_platforms', 'name' => 'Cloud Run',             'proficiency' => 'expert',        'sort_order' => 1],
            ['category' => 'cloud_platforms', 'name' => 'Cloud Storage',         'proficiency' => 'expert',        'sort_order' => 2],
            ['category' => 'cloud_platforms', 'name' => 'Cloud SQL',             'proficiency' => 'intermediate',  'sort_order' => 3],

            ['category' => 'databases',    'name' => 'MySQL',      'proficiency' => 'expert',        'sort_order' => 0],
            ['category' => 'databases',    'name' => 'SQLite',     'proficiency' => 'expert',        'sort_order' => 1],
            ['category' => 'databases',    'name' => 'Redis',      'proficiency' => 'intermediate',  'sort_order' => 2],
        ]);

        // ── Projects ──────────────────────────────────────────────────────────
        $resume->projects()->createMany([
            [
                'name'         => 'JussiLog',
                'description'  => 'Open-source personal portfolio and résumé builder. '
                                . 'Laravel 10 REST API backend deployed on Google Cloud Run, Vue.js 3 + Vite frontend, '
                                . 'GCS file storage, and DomPDF export to PDF.',
                'technologies' => ['Laravel', 'Vue.js 3', 'Vite', 'Tailwind CSS', 'Docker', 'GCP Cloud Run', 'MySQL'],
                'live_url'     => 'https://jussilog.fi',
                'github_url'   => 'https://github.com/jussipalanen/jussilog-backend',
                'sort_order'   => 0,
            ],
            [
                'name'         => 'E-commerce Order Management',
                'description'  => 'Internal dashboard for a Finnish retailer to manage orders, inventory, and shipping '
                                . 'with real-time notifications via Laravel Echo and Pusher.',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Redis', 'Pusher', 'Stripe'],
                'live_url'     => null,
                'github_url'   => null,
                'sort_order'   => 1,
            ],
        ]);

        // ── Certifications ────────────────────────────────────────────────────
        $resume->certifications()->createMany([
            [
                'name'                  => 'Google Associate Cloud Engineer',
                'issuing_organization'  => 'Google Cloud',
                'issue_date'            => '2023-04-15',
                'sort_order'            => 0,
            ],
            [
                'name'                  => 'Laravel Certified Developer',
                'issuing_organization'  => 'Laravel LLC',
                'issue_date'            => '2022-11-01',
                'sort_order'            => 1,
            ],
        ]);

        // ── Languages ─────────────────────────────────────────────────────────
        $resume->languages()->createMany([
            ['language' => 'Finnish', 'proficiency' => 'native',        'sort_order' => 0],
            ['language' => 'English', 'proficiency' => 'fluent',        'sort_order' => 1],
            ['language' => 'Swedish', 'proficiency' => 'conversational', 'sort_order' => 2],
        ]);

        // ── Awards ────────────────────────────────────────────────────────────
        $resume->awards()->createMany([
            [
                'title'       => 'Best Developer — Hackathon Helsinki 2022',
                'issuer'      => 'Junction',
                'date'        => '2022-11-12',
                'description' => 'Won first place in the sustainability track with a real-time carbon-footprint tracker built in 48 hours.',
                'sort_order'  => 0,
            ],
        ]);

        // ── Recommendations ───────────────────────────────────────────────────
        $resume->recommendations()->createMany([
            [
                'full_name'      => 'Matti Virtanen',
                'title'          => 'CTO',
                'company'        => 'TechNord Oy',
                'email'          => 'matti.virtanen@technord.fi',
                'recommendation' => 'Jussi is an exceptionally skilled developer with a rare ability to translate complex '
                                  . 'business requirements into elegant, maintainable code. His initiative in modernising '
                                  . 'our platform architecture saved both time and cost significantly.',
                'sort_order'     => 0,
            ],
            [
                'full_name'      => 'Sanna Korhonen',
                'title'          => 'Lead Designer',
                'company'        => 'Digicraft Helsinki',
                'email'          => 'sanna.korhonen@digicraft.fi',
                'recommendation' => 'Working with Jussi was a pleasure. He always bridged the gap between design and '
                                  . 'engineering and delivered pixel-perfect implementations with great attention to detail.',
                'sort_order'     => 1,
            ],
        ]);
    }
}
