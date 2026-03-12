# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Released]

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
