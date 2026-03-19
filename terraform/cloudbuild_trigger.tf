# Cloud Build trigger — fires on pushes to master.
#
# Prerequisites:
#   1. Connect your GitHub repo to Cloud Build in the GCP console first:
#      Cloud Build → Repositories → Connect Repository → select GitHub
#   2. Then run `terraform apply` to create this trigger resource.
#
# The trigger uses the cloudbuild.yaml in the repo root.
# With Cloud Run now managed by Terraform, the deploy step in cloudbuild.yaml
# still works as-is: it runs `gcloud run deploy` which updates the image while
# Terraform's `ignore_changes` prevents it from reverting those updates.

resource "google_cloudbuild_trigger" "deploy_on_push" {
  name        = "jussilog-backend-deploy"
  description = "Build and deploy jussilog-backend on push to master"
  location    = var.region

  github {
    owner = "jussipalanen"
    name  = "jussilog-backend"
    push {
      branch = "^master$"
    }
  }

  filename = "cloudbuild.yaml"

  substitutions = {
    _REGION       = var.region
    _PROJECT_ID   = var.project_id
    _IMAGE        = "${var.region}-docker.pkg.dev/${var.project_id}/${var.ar_repository_id}/jussilog-backend:latest"
    _APP_URL      = var.app_url
    _FRONTEND_URL = var.frontend_url
    _DB_DATABASE  = var.db_database
    _DB_USERNAME  = var.db_username
    _FILESYSTEM_DISK = "gcs"
    _GCS_BUCKET   = var.gcs_bucket
    _MAIL_ENABLED = var.mail_enabled
    _MAIL_HOST    = var.mail_host
  }

  service_account = "projects/${var.project_id}/serviceAccounts/${data.google_project.project.number}@cloudbuild.gserviceaccount.com"
}
