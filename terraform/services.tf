# Enable required GCP APIs.
# For an existing project these are likely already on — enabling an already-enabled
# API is a no-op, so this is safe to run in both cases.
# For a fresh project this is mandatory before any other resource can be created.

resource "google_project_service" "apis" {
  for_each = toset([
    "run.googleapis.com",              # Cloud Run
    "sqladmin.googleapis.com",         # Cloud SQL
    "artifactregistry.googleapis.com", # Artifact Registry
    "cloudbuild.googleapis.com",       # Cloud Build
    "secretmanager.googleapis.com",    # Secret Manager
    "storage.googleapis.com",          # GCS
    "iam.googleapis.com",              # IAM
  ])

  project = var.project_id
  service = each.key

  # Don't disable the API if you run `terraform destroy` — other things may depend on it
  disable_on_destroy = false
}
