# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Released]

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
