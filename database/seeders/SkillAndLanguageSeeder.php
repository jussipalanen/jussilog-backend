<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Database\Seeder;

class SkillAndLanguageSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSkillCategories();
        $this->seedLanguages();
    }

    // ── Skill Categories & Skills ─────────────────────────────────────────────

    private function seedSkillCategories(): void
    {
        if (SkillCategory::exists()) {
            $this->command->info('SkillAndLanguageSeeder: skill_categories already seeded, skipping.');

            return;
        }

        $categories = [
            // slug                          display name                          sort  skills[]
            ['programming_languages',        'Programming Languages',               0,   ['PHP', 'JavaScript', 'TypeScript', 'Python', 'Java', 'C', 'C++', 'C#', 'Go', 'Rust', 'Kotlin', 'Swift', 'Ruby', 'Scala', 'Dart', 'Elixir', 'Haskell', 'Perl', 'Lua', 'Julia']],
            ['scripting_languages',          'Scripting Languages',                 1,   ['Bash', 'PowerShell', 'Python', 'Ruby', 'Perl', 'Groovy', 'Tcl', 'Zsh']],
            ['markup_languages',             'Markup Languages',                    2,   ['HTML', 'XML', 'YAML', 'Markdown', 'LaTeX', 'Pug', 'Haml', 'Jinja2']],
            ['query_languages',              'Query Languages',                     3,   ['SQL', 'GraphQL', 'HQL', 'JPQL', 'XQuery', 'Cypher', 'SPARQL']],
            ['frontend_technologies',        'Frontend Technologies',               4,   ['Vue.js', 'React', 'Angular', 'Svelte', 'Next.js', 'Nuxt.js', 'Astro', 'SolidJS', 'Alpine.js', 'jQuery', 'Vite', 'Webpack', 'Tailwind CSS', 'Bootstrap', 'Sass', 'CSS', 'Web Components']],
            ['backend_technologies',         'Backend Technologies',                5,   ['Laravel', 'Symfony', 'Django', 'FastAPI', 'Flask', 'Express.js', 'NestJS', 'Spring Boot', 'ASP.NET Core', 'Ruby on Rails', 'Phoenix', 'Hono', 'Actix']],
            ['full_stack_development',       'Full-Stack Development',              6,   ['Next.js', 'Nuxt.js', 'SvelteKit', 'Remix', 'Inertia.js', 'Livewire', 'Meteor']],
            ['frameworks',                   'Frameworks',                          7,   ['Laravel', 'Symfony', 'Vue.js', 'React', 'Angular', 'Django', 'Spring Boot', 'ASP.NET Core', 'NestJS', 'Express.js', 'Tailwind CSS', 'Bootstrap']],
            ['libraries',                    'Libraries',                           8,   ['Lodash', 'Axios', 'Moment.js', 'Day.js', 'Zod', 'Pinia', 'Zustand', 'Redux', 'React Query', 'SWR', 'Chart.js', 'D3.js', 'Three.js', 'GSAP', 'Framer Motion']],
            ['ui_ux_design',                 'UI/UX Design',                        9,   ['Figma', 'Adobe XD', 'Sketch', 'InVision', 'Zeplin', 'Storybook', 'Framer', 'Balsamiq', 'Wireframing', 'Prototyping', 'User Research', 'Accessibility (WCAG)']],
            ['responsive_design',            'Responsive Design',                  10,   ['CSS Grid', 'Flexbox', 'Tailwind CSS', 'Bootstrap', 'Media Queries', 'Mobile-First Design']],
            ['mobile_development',           'Mobile Development',                 11,   ['React Native', 'Flutter', 'Swift', 'SwiftUI', 'Kotlin', 'Jetpack Compose', 'Ionic', 'Expo', 'Capacitor']],
            ['desktop_development',          'Desktop Development',                12,   ['Electron', 'Tauri', 'Qt', 'WPF', 'WinForms', 'JavaFX', 'GTK', '.NET MAUI']],
            ['game_development',             'Game Development',                   13,   ['Unity', 'Unreal Engine', 'Godot', 'Pygame', 'Phaser', 'MonoGame', 'Bevy', 'Three.js']],
            ['embedded_systems',             'Embedded Systems',                   14,   ['C', 'C++', 'Rust', 'Arduino', 'Raspberry Pi', 'FreeRTOS', 'Zephyr', 'MQTT', 'RTOS']],
            ['databases',                    'Databases',                          15,   ['MySQL', 'PostgreSQL', 'SQLite', 'Microsoft SQL Server', 'MongoDB', 'Redis', 'Elasticsearch', 'CassandraDB', 'DynamoDB', 'Firestore', 'ClickHouse', 'MariaDB', 'CockroachDB', 'Supabase']],
            ['database_design',              'Database Design',                    16,   ['Entity-Relationship Modelling', 'Normalization', 'Schema Design', 'Data Modelling', 'Indexing Strategy']],
            ['database_administration',      'Database Administration',            17,   ['Backups & Recovery', 'Replication', 'Sharding', 'Query Optimization', 'Migrations', 'Performance Tuning']],
            ['orm_data_access',              'ORM & Data Access',                  18,   ['Eloquent ORM', 'Doctrine ORM', 'Hibernate', 'Prisma', 'TypeORM', 'SQLAlchemy', 'ActiveRecord', 'Drizzle']],
            ['api_development',              'API Development',                    19,   ['REST API', 'GraphQL', 'gRPC', 'JSON:API', 'OpenAPI / Swagger', 'Postman', 'API Gateway', 'Webhooks']],
            ['web_services',                 'Web Services',                       20,   ['SOAP', 'REST', 'XML-RPC', 'WSDL', 'Webhooks', 'SSE', 'WebSockets']],
            ['graphql',                      'GraphQL',                            21,   ['Apollo Server', 'Apollo Client', 'Hasura', 'GraphQL Yoga', 'Strawberry', 'Lighthouse (Laravel)']],
            ['microservices',                'Microservices',                      22,   ['Service Mesh', 'API Gateway', 'gRPC', 'RabbitMQ', 'Apache Kafka', 'NATS', 'Consul']],
            ['event_driven_architecture',    'Event-Driven Architecture',          23,   ['Apache Kafka', 'RabbitMQ', 'AWS SQS', 'Google Pub/Sub', 'NATS', 'EventBridge', 'Laravel Queues']],
            ['devops',                       'DevOps',                             24,   ['Docker', 'Kubernetes', 'Helm', 'Terraform', 'Ansible', 'GitHub Actions', 'GitLab CI', 'Jenkins', 'ArgoCD', 'Prometheus', 'Grafana']],
            ['cloud_platforms',              'Cloud Platforms',                    25,   ['Google Cloud Platform (GCP)', 'Amazon Web Services (AWS)', 'Microsoft Azure', 'DigitalOcean', 'Hetzner', 'Cloudflare', 'Vercel', 'Render', 'Fly.io']],
            ['serverless',                   'Serverless',                         26,   ['AWS Lambda', 'Google Cloud Functions', 'Azure Functions', 'Cloudflare Workers', 'Vercel Edge Functions', 'Deno Deploy']],
            ['containerization',             'Containerization',                   27,   ['Docker', 'Docker Compose', 'Kubernetes', 'Podman', 'containerd', 'Helm', 'K3s']],
            ['ci_cd',                        'CI/CD',                              28,   ['GitHub Actions', 'GitLab CI', 'CircleCI', 'Jenkins', 'Bitbucket Pipelines', 'ArgoCD', 'Flux CD', 'Travis CI']],
            ['infrastructure_as_code',       'Infrastructure as Code',             29,   ['Terraform', 'Pulumi', 'AWS CloudFormation', 'Ansible', 'Chef', 'Puppet', 'Bicep']],
            ['configuration_management',     'Configuration Management',           30,   ['Ansible', 'Chef', 'Puppet', 'SaltStack', '.env Management', 'Consul', 'Vault']],
            ['version_control',              'Version Control',                    31,   ['Git', 'GitHub', 'GitLab', 'Bitbucket', 'SVN', 'Mercurial']],
            ['testing_qa',                   'Testing & QA',                       32,   ['PHPUnit', 'Pest', 'Jest', 'Vitest', 'Playwright', 'Cypress', 'Selenium', 'Pytest', 'JUnit', 'RSpec', 'Mocha', 'Testing Library']],
            ['test_automation',              'Test Automation',                    33,   ['Playwright', 'Cypress', 'Selenium', 'Puppeteer', 'Appium', 'Robot Framework', 'k6', 'Locust']],
            ['security',                     'Security',                           34,   ['OWASP Top 10', 'Penetration Testing', 'SAST / DAST', 'TLS / SSL', 'Firewall Configuration', 'Secrets Management', 'Zero Trust', 'SOC 2']],
            ['authentication_authorization', 'Authentication & Authorization',     35,   ['OAuth 2.0', 'OpenID Connect', 'JWT', 'SAML', 'Laravel Sanctum', 'Laravel Passport', 'Keycloak', 'Auth0', 'Firebase Auth', 'Supabase Auth', 'RBAC', 'ABAC']],
            ['networking',                   'Networking',                         36,   ['TCP/IP', 'DNS', 'HTTP/HTTPS', 'WebSockets', 'gRPC', 'VPN', 'Load Balancing', 'CDN', 'Nginx', 'HAProxy']],
            ['performance_optimization',     'Performance Optimization',           37,   ['Caching', 'Redis', 'CDN', 'Lazy Loading', 'Database Indexing', 'Query Optimization', 'Profiling', 'Web Vitals', 'Lighthouse']],
            ['architecture_design_patterns', 'Architecture & Design Patterns',     38,   ['MVC', 'MVVM', 'Repository Pattern', 'CQRS', 'Event Sourcing', 'Domain-Driven Design (DDD)', 'Hexagonal Architecture', 'SOLID Principles', 'Factory', 'Observer', 'Singleton']],
            ['system_design',                'System Design',                      39,   ['High Availability', 'Load Balancing', 'Horizontal Scaling', 'Caching Strategies', 'Message Queues', 'CAP Theorem', 'Rate Limiting']],
            ['distributed_systems',          'Distributed Systems',                40,   ['Apache Kafka', 'Apache Zookeeper', 'Consul', 'etcd', 'Raft Consensus', 'CRDTs', 'Two-Phase Commit']],
            ['data_engineering',             'Data Engineering',                   41,   ['Apache Spark', 'Apache Airflow', 'dbt', 'ETL Pipelines', 'Apache Kafka', 'Flink', 'BigQuery', 'Redshift', 'Snowflake']],
            ['big_data',                     'Big Data',                           42,   ['Apache Hadoop', 'Apache Spark', 'Hive', 'HBase', 'Presto', 'Google BigQuery', 'Amazon Redshift', 'Snowflake']],
            ['machine_learning_ai',          'Machine Learning & AI',              43,   ['TensorFlow', 'PyTorch', 'scikit-learn', 'Keras', 'Hugging Face', 'LangChain', 'OpenAI API', 'Pandas', 'NumPy', 'Jupyter', 'MLflow']],
            ['monitoring_logging',           'Monitoring & Logging',               44,   ['Prometheus', 'Grafana', 'Datadog', 'New Relic', 'Sentry', 'ELK Stack', 'Loki', 'OpenTelemetry', 'PagerDuty', 'Uptime Kuma']],
            ['development_tools',            'Development Tools',                  45,   ['Visual Studio Code', 'PhpStorm', 'JetBrains IDEs', 'Postman', 'Insomnia', 'TablePlus', 'DBeaver', 'Xdebug', 'Laravel Telescope', 'Makefile', 'direnv']],
            ['operating_systems',            'Operating Systems',                  46,   ['Linux (Ubuntu)', 'Linux (Debian)', 'Linux (Alpine)', 'macOS', 'Windows', 'Windows Server', 'CoreOS', 'NixOS']],
            ['project_management',           'Project Management',                 47,   ['Jira', 'Linear', 'Trello', 'Notion', 'Asana', 'GitHub Projects', 'Confluence', 'Basecamp']],
            ['agile_methodologies',          'Agile Methodologies',                48,   ['Scrum', 'Kanban', 'SAFe', 'Extreme Programming (XP)', 'Lean', 'Shape Up', 'OKRs']],
            ['soft_skills',                  'Soft Skills',                        49,   ['Communication', 'Teamwork', 'Problem Solving', 'Time Management', 'Mentoring', 'Technical Writing', 'Code Review', 'Leadership']],
            ['other',                        'Other',                              50,   []],
        ];

        foreach ($categories as [$slug, $name, $sortOrder, $skills]) {
            $category = SkillCategory::create([
                'slug'       => $slug,
                'name'       => $name,
                'sort_order' => $sortOrder,
            ]);

            foreach ($skills as $skillName) {
                Skill::create([
                    'skill_category_id' => $category->id,
                    'name'              => $skillName,
                ]);
            }
        }

        $this->command->info('SkillAndLanguageSeeder: skill_categories and skills seeded.');
    }

    // ── Languages ─────────────────────────────────────────────────────────────

    private function seedLanguages(): void
    {
        if (Language::exists()) {
            $this->command->info('SkillAndLanguageSeeder: languages already seeded, skipping.');

            return;
        }

        $languages = [
            // ISO 639-1 code => display name
            ['af', 'Afrikaans'],
            ['sq', 'Albanian'],
            ['am', 'Amharic'],
            ['ar', 'Arabic'],
            ['hy', 'Armenian'],
            ['az', 'Azerbaijani'],
            ['eu', 'Basque'],
            ['be', 'Belarusian'],
            ['bn', 'Bengali'],
            ['bs', 'Bosnian'],
            ['bg', 'Bulgarian'],
            ['ca', 'Catalan'],
            ['zh', 'Chinese (Mandarin)'],
            ['hr', 'Croatian'],
            ['cs', 'Czech'],
            ['da', 'Danish'],
            ['nl', 'Dutch'],
            ['en', 'English'],
            ['et', 'Estonian'],
            ['fi', 'Finnish'],
            ['fr', 'French'],
            ['gl', 'Galician'],
            ['ka', 'Georgian'],
            ['de', 'German'],
            ['el', 'Greek'],
            ['gu', 'Gujarati'],
            ['he', 'Hebrew'],
            ['hi', 'Hindi'],
            ['hu', 'Hungarian'],
            ['is', 'Icelandic'],
            ['id', 'Indonesian'],
            ['ga', 'Irish'],
            ['it', 'Italian'],
            ['ja', 'Japanese'],
            ['kn', 'Kannada'],
            ['kk', 'Kazakh'],
            ['km', 'Khmer'],
            ['ko', 'Korean'],
            ['ky', 'Kyrgyz'],
            ['lo', 'Lao'],
            ['lv', 'Latvian'],
            ['lt', 'Lithuanian'],
            ['lb', 'Luxembourgish'],
            ['mk', 'Macedonian'],
            ['ms', 'Malay'],
            ['ml', 'Malayalam'],
            ['mt', 'Maltese'],
            ['mr', 'Marathi'],
            ['mn', 'Mongolian'],
            ['ne', 'Nepali'],
            ['nb', 'Norwegian (Bokmål)'],
            ['or', 'Odia'],
            ['ps', 'Pashto'],
            ['fa', 'Persian'],
            ['pl', 'Polish'],
            ['pt', 'Portuguese'],
            ['pa', 'Punjabi'],
            ['ro', 'Romanian'],
            ['ru', 'Russian'],
            ['sr', 'Serbian'],
            ['si', 'Sinhala'],
            ['sk', 'Slovak'],
            ['sl', 'Slovenian'],
            ['so', 'Somali'],
            ['es', 'Spanish'],
            ['sw', 'Swahili'],
            ['sv', 'Swedish'],
            ['tl', 'Tagalog'],
            ['tg', 'Tajik'],
            ['ta', 'Tamil'],
            ['tt', 'Tatar'],
            ['te', 'Telugu'],
            ['th', 'Thai'],
            ['tr', 'Turkish'],
            ['tk', 'Turkmen'],
            ['uk', 'Ukrainian'],
            ['ur', 'Urdu'],
            ['uz', 'Uzbek'],
            ['vi', 'Vietnamese'],
            ['cy', 'Welsh'],
            ['xh', 'Xhosa'],
            ['yi', 'Yiddish'],
            ['yo', 'Yoruba'],
            ['zu', 'Zulu'],
        ];

        foreach ($languages as [$code, $name]) {
            Language::create(['code' => $code, 'name' => $name]);
        }

        $this->command->info('SkillAndLanguageSeeder: languages seeded.');
    }
}
