# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Released]

## [1.0.2] - 2026-03-30

### Security
- **npm — picomatch ReDoS vulnerability**: Updated `picomatch` to a patched version via `npm audit fix`. Resolved two high-severity advisories (GHSA-3v7f-55p6-f55p, GHSA-c2c7-rcm5-vvqj) affecting glob matching via method injection and extglob quantifiers.

### Changed
- **GitHub Actions — Node.js 20 deprecation**: Updated `actions/checkout` from `v4` to `v5` across all workflows (`composer-audit.yml`, `phpunit.yml`, `larastan.yml`, `pint.yml`) and `actions/setup-node` from `v4` to `v5` in `composer-audit.yml` to avoid forced Node.js 24 migration on June 2, 2026.
- **Root page redesign**: Replaced the default Laravel welcome page with a dark-themed API landing page showing the app version, description, and links to the interactive API docs, OpenAPI spec, and Postman collection.

### Updated
- **`aws/aws-sdk-php`**: `3.374.1` → `3.374.2` (patch).
- **`spatie/laravel-ignition`**: `2.9.1` → `2.12.0` (minor).
- **`vite`**: `7.3.1` → `8.0.3` (major).
- **`laravel-vite-plugin`**: `2.1.0` → `3.0.0` (major).
- **`axios`**: `1.13.6` → `1.14.0` (minor).

## [1.0.1] - 2026-03-23

### Fixed
- **GCS file uploads**: Switched GCS bucket from uniform to fine-grained access control so per-object ACLs work correctly with the S3-compatible driver. Files are now uploaded with `public-read` ACL, making them publicly accessible via direct URL while keeping the bucket root access denied.

## [1.0.0] - 2026-03-19

### Added
- **Dark resume template**: New `dark` PDF/HTML export template with a full-width header (photo, name, title, contact) and main content left / sidebar right layout.
  - 5 color themes: `midnight`, `gold`, `aurora`, `ember`, `amethyst`.
  - Theme/accent/bg swatch data exposed via `GET /api/resumes/export/options` under `template_themes`.
- **Resume preview endpoints** (authenticated):
  - `GET /api/resumes/{id}/preview/pdf` — inline PDF preview (no download).
  - `GET /api/resumes/{id}/preview/html` — inline HTML preview (no download).
  - `GET /api/resumes/{id}/preview/signed-url` — returns 60-minute signed URLs for token-free iframe embedding.
  - `GET /api/resumes/{id}/preview/pdf/render` — signed PDF render (no auth required, signature validated).
  - `GET /api/resumes/{id}/preview/html/render` — signed HTML render (no auth required, signature validated).
- **Public resume preview endpoints** (no auth, payload-based):
  - `POST /api/resumes/preview/pdf` — inline PDF preview from JSON payload (same format as export endpoints).
  - `POST /api/resumes/preview/html` — inline HTML preview from JSON payload.
- **Resume template translations**: Added EN/FI translations for `template_default`, `template_dark`, and all 5 dark theme names.
- **Terraform infrastructure as code** (`terraform/`): Full GCP setup covering Cloud Run, Cloud SQL (MySQL 8.0), Artifact Registry, GCS uploads bucket, Secret Manager secret containers, IAM service account with least-privilege bindings, and Cloud Build trigger on `master`.
  - Secrets injected into Cloud Run at runtime via `secret_key_ref` (Secret Manager) instead of plain env vars.
  - `lifecycle { ignore_changes = [image] }` on Cloud Run so Cloud Build can update the image without Terraform reverting configuration.
  - `terraform/backend.tf` — GCS remote state template (commented, with bootstrap instructions).
- **Dev script Terraform commands**: `tf-init`, `tf-plan`, `tf-apply`, `tf-import`, `tf-output`. `DB_PASSWORD` is read automatically from `.env.production`; `TF_VAR_db_password` env var supported as override for CI/CD.
  - `tf-import` imports all existing GCP resources into state in one command (tolerant of already-imported or missing resources).

### Changed
- **Classic template renamed**: `pdf.blade.php` → `pdf_classic.blade.php`; controller updated accordingly.
- **Resume export font improvements**: Bumped minimum font size to 8.5pt for labels and 9pt for body text across both classic and dark templates for better readability at 100% zoom.
- **Page-break fixes**: Classic template `.sb-section` changed from `break-inside: avoid` to `auto` so large sidebar sections (e.g. long skill lists) flow naturally across pages; individual items retain their own `break-inside: avoid` rules.
- **Project links**: Rendered inline with a `·` separator between live URL and GitHub URL; removed labels.
- **README**: Restructured with `<details>` accordion sections — always-visible top (tech stack, quick start, full `./dev` command table) and 12 collapsible sections for detailed content.

### Fixed
- **Resume update validation bug**: `sectionValidationRules()` was producing `'sometimes|required'` as a single string key when mixed with `Rule::in()` objects, causing a `validateSometimes|required does not exist` exception. Fixed by using array spread `[...$req, Rule::in(...)]`.

## [0.9.9] - 2026-03-17

### Added
- **Blog posts**: Full CRUD API for blog posts with visibility control, tags, and featured image support.
  - `GET /api/blogs` — list all published blog posts (public).
  - `GET /api/blogs/{idOrSlug}` — get a single published blog post by ID or slug (public).
  - `GET /api/admin/blogs` — list all blog posts regardless of visibility (admin only).
  - `POST /api/blogs` — create a blog post (admin only).
  - `PUT /api/blogs/{id}` — update a blog post (admin only).
  - `DELETE /api/blogs/{id}` — delete a blog post (admin only).
  - `featured_image` upload with automatic multi-size thumbnail generation (`thumb` 400×225, `medium` 800×450, `large` 1200×675).
  - Sending `featured_image` as empty/null on update removes the existing image and thumbnails from storage.
  - Tags stored as a JSON array; sortable by `id`, `title`, `created_at`, and `visibility`.
- **Blog categories**: CRUD API for blog post categories.
  - `GET /api/blog-categories` — list all categories (public).
  - `POST /api/blog-categories` — create a category (admin only).
  - `PUT /api/blog-categories/{id}` — update a category (admin only).
  - `DELETE /api/blog-categories/{id}` — delete a category (admin only).
- **Blog seeder**: Added `BlogSeeder` with sample blog category and post for development.
- **Postman collection generator**: Added `scripts/generate-postman.sh` script to auto-generate a Postman collection from the Scribe API spec.
- **Skill & language proficiency constants**: `ResumeSkill` and `ResumeLanguage` models now expose proficiency level constants for use across controllers.

## [0.9.6] - 2026-03-15

### Added
- **Resume JSON export**: `GET /api/resumes/{id}/export/json` — downloads a full resume backup as a `.json` file. Strips internal fields (`id`, `user_id`, `photo`, `photo_sizes`, `code`, timestamps) from all sections. Authenticated, ownership-enforced.
- **Resume JSON import — create**: `POST /api/resumes/import/json` — uploads a JSON backup file and creates a new resume for the authenticated user. File content is fully validated against existing resume rules.
- **Resume JSON import — update**: `POST /api/resumes/{id}/import/json` — uploads a JSON backup file and overwrites an existing resume by ID. The URL ID takes priority over any `id` field inside the file. Ownership enforced; admins may update any resume.
- **Skill level visibility toggle**: `show_skill_levels` boolean field (default `true`) added to the `resumes` table. Controls whether skill proficiency bars are rendered in PDF and HTML exports.
- **Language level visibility toggle**: `show_language_levels` boolean field (default `true`) added to the `resumes` table. Controls whether language proficiency dots are rendered in PDF and HTML exports.
  - Both fields are accepted on `POST /api/resumes` and `PUT /api/resumes/{id}`.
  - Authenticated exports (`exportPdf`, `exportHtml`) use the stored value as default; a query param (`?show_skill_levels=false`) overrides it at export time.
  - Public exports (`POST /api/resumes/export/pdf`, `POST /api/resumes/export/html`) accept both fields in the JSON body.
  - Migration: `2026_03_15_202705_add_skill_language_level_visibility_to_resumes_table`.

### Fixed
- **Resume paragraph text not rendering line breaks**: Long-form text fields (`summary`, work experience `description`, project `description`, award `description`, recommendation `recommendation`) now render newlines correctly in PDF and HTML exports. Fixed by replacing `{{ $value }}` with `{!! nl2br(e($value)) !!}` in the Blade template.



### Added
- **Order status change emails**: Sending a status update on an order now triggers a transactional email to the customer when the status changes. Supported statuses: `pending`, `processing`, `completed`, `cancelled`, `refunded`.
  - New `OrderStatusUpdated` Mailable with per-status subject lines, badge colours, headings, and body messages.
  - New `order-status-updated` Blade email template — dark-themed, matching the existing email design system, with a status transition pill (Previous → New), per-status colour theming, and an order item summary table.
  - `OrderStatusConfig` service class extracted to hold all per-status visual config (colours, icons, gradients) separately from the template.
- **`send_status_email` request parameter on `PUT /api/orders/{id}`**: Boolean flag to opt out of sending the status change email. Defaults to `true`.
- **`lang` field on orders**: New `lang` column (`en`/`fi`, default `en`) stored on the order at placement time and used to send all subsequent status emails in the customer's chosen language.
  - Migration: `2026_03_15_000001_add_lang_to_orders_table`.
- **Order status email translations**: Added `order_status_updated` translation group to `lang/en/mail.php` and `lang/fi/mail.php` covering subjects, badge labels, headings, status-specific messages, status pill labels, and all shared UI strings.
- **Invoice PDF attachment on all send paths**: The `exportEmail` (manual/admin) endpoint now generates and attaches the invoice PDF — bringing it in line with the existing `sendEmail` (invoice tool) path which already attached the PDF.
- **Barcode on invoice PDF and email**: Code 128 barcode encoding the invoice number is embedded in both the invoice PDF (above the footer) and the HTML invoice email (in the footer card), using `picqer/php-barcode-generator`.
  - `BarcodeService` with `svg()` (black bars, for PDF) and `svgLight()` (indigo `#a5b4fc` bars, for dark-themed email).

### Changed
- **`POST /api/orders` — `lang` param**: Order placement accepts an optional `lang` body parameter (`en` or `fi`). The value is persisted on the order and used for all email communications related to that order.

## [0.9.0] - 2026-03-15

### Added
- **`due_date` on invoices**: New nullable `due_date` date column on the `invoices` table, exposed in all invoice responses.
- **Extended invoice statuses**: `InvoiceStatus` enum expanded with two new cases — `UNPAID` (orange) and `OVERDUE` (red) — in addition to the existing `DRAFT`, `ISSUED`, `PAID`, and `CANCELLED`.
- **GitHub Actions — Larastan**: Added `.github/workflows/larastan.yml` to run PHPStan static analysis on every push and pull request.
- **GitHub Actions — Pint**: Added `.github/workflows/pint.yml` to enforce Laravel Pint code style on every push and pull request.

### Changed
- **Price formatting in Finnish locale**: Invoice PDF, invoice email, and order confirmation email now correctly format prices using Finnish conventions (`,` as decimal separator, non-breaking space as thousands separator) when `lang=fi`.
- **Euro symbol on prices**: All price, subtotal, and total fields in the invoice PDF and invoice email templates now display the `€` currency symbol.
- **Codebase-wide Pint formatting**: Applied Laravel Pint to the entire codebase — consistent spacing, imports, and style across all PHP files.

### Fixed
- **PHPStan errors**: Resolved 11 static analysis errors across `OrderController`, `ResumeController`, `ResumeItemController`, `TaxRateController`, `Product`, and `ResumeLanguage`.
  - `str_pad()` received `int` instead of `string` (OrderController).
  - `Browsershot::disableGpu()` does not exist — replaced with `addChromiumArguments(['--disable-gpu'])` (ResumeController).
  - `match` expression missing `default` arm (ResumeItemController).
  - Redundant `?? $code` fallbacks on non-nullable array offsets (TaxRateController × 2).
  - `Product::$appends` PHPDoc type widened to `array<int, string>`; removed always-false negated boolean guards and unnecessary `?? ''` null coalescing; `resolveImageUrl()` return type corrected to `string`.
  - `ResumeLanguage::getPointsAttribute()` return type corrected to `int`.
- **Finnish price formatting bug**: Single-quoted `'\u{00A0}'` was passed literally to `number_format` — fixed to double-quoted `"\u{00A0}"` so PHP resolves it to the actual non-breaking space character.

## [0.8.1] - 2026-03-14

### Added
- **Resume public sharing**: Added `is_public` boolean and `code` string columns to the `resumes` table, enabling access-controlled public sharing.
  - `GET /api/resumes/{id}/public` — view a resume without authentication (respects `is_public` / `code` access control).
  - `GET /api/resumes/current/main` — returns a simplified view of the primary resume (public).
- **Countries endpoints**:
  - `GET /api/settings/countries` — list of world countries with labels translated to `en` or `fi`.
  - `GET /api/settings/countries/{code}` — single country by ISO 3166-1 alpha-2 code.
- **Tax rates endpoints**:
  - `GET /api/settings/taxrates` — standard VAT/GST rates for all supported country codes.
  - `GET /api/settings/taxrates/{code}` — rate for a single country code.
- **Tax rate on products**: Added `tax_rate` decimal column to the `products` table.
- **Invoice options endpoint**: `GET /api/invoices/options` — returns available statuses and item types with translated labels (public, no auth required).
- **Invoice email endpoints**:
  - `POST /api/invoices/export/email` — public invoice export delivered by email.
  - `POST /api/invoices/{id}/send` — send an existing invoice by email (public).
- **Resume spoken-language translations**: Extended `lang/en/resume.php` and `lang/fi/resume.php` with labels for ~100 spoken languages (ISO 639-1 codes).
- **`points` field on skills and languages**: `ResumeSkill` and `ResumeLanguage` now expose a computed `points` property (1–5) mapped from `proficiency`. Included automatically in all responses (authenticated and public endpoints).
  - Skill levels: `beginner` = 1, `basic` = 2, `intermediate` = 3, `advanced` = 4, `expert` = 5.
  - Language levels: `elementary` = 1, `limited_working` = 2, `professional_working` = 3, `full_professional` = 4, `native_bilingual` = 5.

### Changed
- **`resume_skills.category` ENUM**: Converted from free-text string to a strict MySQL ENUM with 50 granular values (`programming_languages`, `query_languages`, `frameworks`, `cloud_platforms`, `development_tools`, `databases`, … `other`). Added `other` as a catch-all value.
- **`invoices.invoice_number`**: Made nullable — the number is auto-assigned when the invoice is issued rather than required at creation time.
- **Resume proficiency levels**: Updated proficiency ENUM values for both skills (`resume_skills`) and spoken languages (`resume_languages`) to align with the new skill-category schema.

### Fixed
- **`ResumeSeeder`**: Corrected skill `category` seed values to match the new ENUM (old values `Languages`, `Frameworks`, `Tools`, `Cloud`, `Databases` replaced by `programming_languages`, `query_languages`, `frameworks`, `development_tools`, `cloud_platforms`, `databases`).
- **`ResumeSeeder`**: Fixed foreign key constraint failure — the resume is now linked to the admin user looked up by email instead of the hardcoded `user_id = 1`, which may not exist after repeated migrations/seeds.
- **`docker/entrypoint.sh`**: Removed the `APP_KEY` auto-generation block — the key must be set as a persistent environment variable. Made `php artisan optimize` non-fatal: logs a warning and continues startup instead of aborting when the command fails.

## [0.7.0] - 2026-03-13

### Added
- **Resume system**: Full CRUD API for resumes and all resume sections (work experiences, educations, skills, projects, certifications, languages, awards, recommendations).
  - `GET /api/resumes` — list all resumes (authenticated).
  - `GET /api/resumes/current` — get the primary/active resume (authenticated).
  - `GET /api/resumes/{id}` — get a single resume (authenticated).
  - `POST /api/resumes` — create a resume (authenticated).
  - `PUT /api/resumes/{id}` — update a resume; also accepts `POST /api/resumes/{id}` for multipart photo uploads (authenticated).
  - `DELETE /api/resumes/{id}` — delete a resume (authenticated).
  - `GET /api/resumes/{resumeId}/{section}` — list items in a resume section (authenticated).
  - `POST /api/resumes/{resumeId}/{section}` — add an item to a resume section (authenticated).
  - `PUT /api/resumes/{resumeId}/{section}/{itemId}` — update a resume section item (authenticated).
  - `DELETE /api/resumes/{resumeId}/{section}/{itemId}` — delete a resume section item (authenticated).
- **Resume export**: Export resumes as PDF or HTML with template and theme support.
  - `GET /api/resumes/{id}/export/pdf` — authenticated export.
  - `GET /api/resumes/{id}/export/html` — authenticated export.
  - `GET /api/resumes/export/options` — list available templates and themes (public).
  - `POST /api/resumes/export/pdf` — public PDF export.
  - `POST /api/resumes/export/html` — public HTML export.
- **Resume photo**: Photo upload and multi-size storage (`photo_sizes`) for resumes.
- **`is_primary` flag on resumes**: Mark a resume as the primary/default one.
- **Resume template & language fields**: Added `template` and `language` columns to the resumes table.
- **Settings endpoint**: `GET /api/settings/languages` — returns the list of supported languages.
- **Product thumbnails**: Automatic thumbnail generation for product images on upload (`ThumbnailService`, `AdminThumbnailController`).
  - `POST /api/admin/thumbnails/regenerate` — regenerate all thumbnails.
  - `DELETE /api/admin/thumbnails` — purge all thumbnails.
  - `POST /api/admin/thumbnails/products/{id}/regenerate` / `DELETE /api/admin/thumbnails/products/{id}` — per-product thumbnail management.
  - `POST /api/admin/thumbnails/resumes/{id}/regenerate` / `DELETE /api/admin/thumbnails/resumes/{id}` — per-resume thumbnail management.
- **`thumbnails:regenerate` Artisan command**: CLI command to regenerate all product and resume thumbnails.
- **Dependabot**: Added `.github/dependabot.yml` for automated dependency update PRs.
- **Composer audit workflow**: Added `.github/workflows/composer-audit.yml` for automated PHP dependency security auditing on every push.
- **Localization**: Added `lang/en/resume_pdf.php` and `lang/fi/resume_pdf.php` translations for the resume PDF export view.
- **Resume seeder**: Added `ResumeSeeder` for development seed data.

### Changed
- PHP requirement bumped from `^8.1` to `^8.2`.
- `Product` model updated to handle multiple image sizes.

### Fixed
- `ResumeController::exportPdfPublic()`: Fixed incorrect `Content-Type: application/pdf` header being applied on the non-PDF (coming-soon HTML) branch. Now uses `response()->view()` correctly (Copilot Autofix).

## [0.6.2] - 2026-03-12

### Changed
- **Dockerfile**: Removed Node.js/Vite build stage entirely (API-only backend — no frontend assets). Upgraded PHP 8.1 → 8.2.
- **OPcache**: Tuned production config (`validate_timestamps=0`, `memory_consumption=64`, `max_accelerated_files=8000`) to avoid per-request filesystem checks and reduce memory footprint.
- **PHP-FPM** (`docker/www.conf`): Switched from `pm=static` with 8 workers to `pm=dynamic` with a max of 3 workers. Saves ~180 MB RAM vs the previous static pool. Added `pm.max_requests=500` to recycle workers and prevent memory growth.
- **Nginx** (`docker/nginx.conf`): Reduced FastCGI buffers from 256×16k to 4×16k (JSON API responses are a few KB, not megabytes). Reduced `fastcgi_read_timeout` from 600 s to 30 s.
- **Cloud Run** (`cloudbuild.yaml`): Reduced `--concurrency` from 80 to 4, better suited for low-traffic and the 3-worker PHP-FPM pool. Memory kept at 512Mi (gen2 execution environment minimum).
- **Cloud Build** (`cloudbuild.yaml`): Merged the previous two-step deploy+env-update into a single `gcloud run deploy` call to eliminate the second rolling restart per build. Added `machineType: E2_HIGHCPU_8` and `logging: CLOUD_LOGGING_ONLY` to reduce build time and storage cost.
- **Entrypoint** (`docker/entrypoint.sh`): Removed the 30-retry MySQL wait loop for the Cloud SQL Unix socket path (socket is available instantly in Cloud Run). Removed the startup `sleep 1`. Replaced three separate cache commands with `php artisan optimize`.
- **Env vars** (`cloudbuild.yaml`): Synced all missing production variables — `GCS_*`, `SCRIBE_BASE_URL`, `SCRIBE_AUTH_KEY`, `GOOGLE_CLIENT_ID`, `ROLE_UPDATE_KEY`. Fixed `DB_USERNAME` default from `root` to `jussilog`.
- **`.env.production`**: Removed duplicate `ROLE_UPDATE_KEY` entry. Fixed `SCRIBE_BASE_URL` pointing to stale dev domain. Added `SCRIBE_AUTH_KEY`.

### Added
- **Warmup endpoint** (`routes/web.php`): `GET /_ah/warmup` — Cloud Run sends a warmup request to this path when a new instance starts, bootstrapping the Laravel stack and OPcache before live traffic arrives.
- **Cloud Scheduler job** (`cloudbuild.yaml`, Step 3): Automatically creates/updates a `jussilog-backend-warmup` scheduler job that pings `/_ah/warmup` every 5 minutes to keep the running instance and its OPcache hot, eliminating the previous 10–15 s cold-start delays.
- **`--cpu-boost`** on Cloud Run deployment: allocates extra CPU during container startup so migrations and `php artisan optimize` complete faster before the instance receives traffic.

### Fixed
- Visitor tracking middleware (`TrustProxies.php`): allow Cloud Run proxy headers so visitor IP detection works correctly behind the Google load balancer.
- **Nginx** (`docker/nginx.conf`): Fixed startup crash — `fastcgi_busy_buffers_size` (64k) exceeded the allowed maximum of total `fastcgi_buffers` minus one buffer (48k). Reduced to 32k.

## [0.6.0] - 2026-03-10

### Added
- Google OAuth login endpoint (`POST /api/auth/google`) with `GoogleWelcome` mail on first sign-in.
- Visitor tracking endpoints for frontend analytics:
  - `POST /api/visitors/track` — records a visit by IP address (public).
  - `GET /api/visitors/today` — returns unique visitor count for today (authenticated).
  - `GET /api/visitors/total` — returns unique visitor count of all time (authenticated).
- `visitors` database table and `Visitor` model; unique visitors counted per IP address.

### Changed
- All email templates (`order-confirmation`, `registration-welcome`, `account-deleted`, `google-welcome`) fully redesigned with a consistent indigo/violet gradient style, inline CSS for email client compatibility, and icon-enhanced sections.
- App name in all mail templates now uses `config('app.name')` instead of a hardcoded string.
- Order confirmation email subject corrected from `Thanks for a order` to `Thank you for your order!`.
- Billing address displayed before shipping address in order confirmation email.

### Removed
- "Processing your order" status bar from the order confirmation email template.


## [0.4.0] - 2026-03-09

### Fixed
- Cloud SQL MySQL connection for Google Cloud Run deployment now uses Unix socket (`DB_SOCKET`) instead of incorrect TCP host configuration.
- Database health check in entrypoint script now properly detects and handles both Unix socket (Cloud SQL) and TCP (local Docker) connections.
- Production environment configuration updated with correct Cloud SQL socket path.

### Changed
- `cloudbuild.yaml` now sets `DB_SOCKET` for Cloud SQL Unix socket connections instead of using socket path in `DB_HOST`.
- `docker/entrypoint.sh` enhanced with automatic connection method detection (socket vs TCP) and improved error messages.

## [0.3.0] - 2026-03-09

### Added
- Dev CLI script (`dev`) for Docker workflows with init, logs, and artisan/composer/npm helpers.
- Cloud Run job documentation for manual user management, including SQLite and Secret Manager guidance.

### Changed
- Enabled hot-reload bind mounts in docker-compose for app, routes, resources, config, and public.
- Local entrypoint now clears all Laravel caches to avoid stale routes/config during development.
- `user:create` now requires `first_name`, `last_name`, and `username`, and persists them.
- `user:update` no longer prompts for other fields when any update options are provided and requires id/email.

### Fixed
- Prevented cached routes/config from masking code changes in local Docker runs.

## [0.2.0] - 2026-03-08

### Added
- Upload test endpoint: `POST /api/upload-test` storing images on GCS with a full URL response.
- Signed URL generation for product image URLs and upload-test responses (1 hour expiry).
- Local vs GCS upload setup documentation in README.
- Product stock decrement on order placement with row locking (backorder allowed).

### Changed
- Product image storage now uses the default filesystem disk instead of hardcoded `public`.
- `user:list` output includes `username` column.
- Added optional `user_id` payload support for product create/update role checks.

### Fixed
- Added required Flysystem S3 adapter dependencies for GCS uploads.

## [0.1.0] - 2026-03-08

### Added
- Initial project setup.

## Pull Requests

- PR #1: Major update (https://github.com/jussipalanen/jussilog-backend/pull/1)
