output "cloud_run_url" {
  description = "Deployed Cloud Run service URL"
  value       = google_cloud_run_v2_service.jussilog_backend.uri
}

output "cloud_sql_connection_name" {
  description = "Cloud SQL connection name (project:region:instance)"
  value       = google_sql_database_instance.jussilog_db.connection_name
}

output "artifact_registry_repo" {
  description = "Full Artifact Registry path for Docker images"
  value       = "${var.region}-docker.pkg.dev/${var.project_id}/${google_artifact_registry_repository.jussilog_backend.repository_id}"
}

output "gcs_bucket_url" {
  description = "GCS uploads bucket URL"
  value       = "gs://${google_storage_bucket.uploads.name}"
}

output "cloud_run_service_account" {
  description = "Service account email used by the Cloud Run service"
  value       = google_service_account.cloud_run.email
}
