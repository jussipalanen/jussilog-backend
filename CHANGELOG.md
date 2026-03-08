# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [Released]

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
