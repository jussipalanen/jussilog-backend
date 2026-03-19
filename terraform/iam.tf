# Dedicated service account for the Cloud Run service.
# Follows least-privilege: only what the app actually needs.

resource "google_service_account" "cloud_run" {
  account_id   = "jussilog-cloud-run"
  display_name = "JussiLog Cloud Run SA"
  description  = "Runtime identity for the jussilog-backend Cloud Run service"
}

# --- Cloud SQL ---

# Allows Cloud Run to connect via the Cloud SQL proxy sidecar
resource "google_project_iam_member" "cloud_run_sql_client" {
  project = var.project_id
  role    = "roles/cloudsql.client"
  member  = "serviceAccount:${google_service_account.cloud_run.email}"
}

# --- Secret Manager ---

# Read all LARAVEL_BACKEND_* secrets at runtime
resource "google_project_iam_member" "cloud_run_secret_accessor" {
  project = var.project_id
  role    = "roles/secretmanager.secretAccessor"
  member  = "serviceAccount:${google_service_account.cloud_run.email}"
}

# --- GCS uploads bucket ---

resource "google_storage_bucket_iam_member" "cloud_run_storage_admin" {
  bucket = google_storage_bucket.uploads.name
  role   = "roles/storage.objectAdmin"
  member = "serviceAccount:${google_service_account.cloud_run.email}"
}

# --- Artifact Registry (pull images) ---

resource "google_artifact_registry_repository_iam_member" "cloud_run_ar_reader" {
  project    = var.project_id
  location   = var.region
  repository = google_artifact_registry_repository.jussilog_backend.repository_id
  role       = "roles/artifactregistry.reader"
  member     = "serviceAccount:${google_service_account.cloud_run.email}"
}

# --- Cloud Build service account ---
# Cloud Build needs to push images and deploy Cloud Run.

resource "google_project_iam_member" "cloudbuild_run_developer" {
  project = var.project_id
  role    = "roles/run.developer"
  member  = "serviceAccount:${data.google_project.project.number}@cloudbuild.gserviceaccount.com"
}

resource "google_project_iam_member" "cloudbuild_ar_writer" {
  project = var.project_id
  role    = "roles/artifactregistry.writer"
  member  = "serviceAccount:${data.google_project.project.number}@cloudbuild.gserviceaccount.com"
}

resource "google_project_iam_member" "cloudbuild_secret_accessor" {
  project = var.project_id
  role    = "roles/secretmanager.secretAccessor"
  member  = "serviceAccount:${data.google_project.project.number}@cloudbuild.gserviceaccount.com"
}

# Cloud Build must be able to act as the Cloud Run SA when deploying
resource "google_service_account_iam_member" "cloudbuild_act_as_cloud_run_sa" {
  service_account_id = google_service_account.cloud_run.name
  role               = "roles/iam.serviceAccountUser"
  member             = "serviceAccount:${data.google_project.project.number}@cloudbuild.gserviceaccount.com"
}
