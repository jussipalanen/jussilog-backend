resource "google_storage_bucket" "uploads" {
  name          = var.gcs_bucket
  location      = "EU"
  storage_class = "STANDARD"

  uniform_bucket_level_access = true

  versioning {
    enabled = false
  }

  lifecycle_rule {
    condition {
      age = 365
    }
    action {
      type          = "SetStorageClass"
      storage_class = "NEARLINE"
    }
  }

  cors {
    origin          = [var.frontend_url, var.app_url]
    method          = ["GET", "HEAD", "PUT", "POST", "DELETE"]
    response_header = ["Content-Type", "Authorization", "x-goog-meta-*"]
    max_age_seconds = 3600
  }
}
