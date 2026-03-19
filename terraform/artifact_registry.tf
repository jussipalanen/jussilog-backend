resource "google_artifact_registry_repository" "jussilog_backend" {
  location      = var.region
  repository_id = var.ar_repository_id
  description   = "Docker images for jussilog-backend"
  format        = "DOCKER"
}
