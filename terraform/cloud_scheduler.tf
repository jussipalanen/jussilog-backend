# Cloud Scheduler warmup job
#
# Pings /_ah/warmup every 5 minutes so the Cloud Run instance stays responsive
# even with min_instances=0. This avoids the always-on cost of min_instances=1
# while still preventing cold-start delays during normal usage hours.
#
# The warmup endpoint is public (allUsers has run.invoker), so no OIDC token is
# needed — a plain HTTP GET is sufficient.

resource "google_cloud_scheduler_job" "warmup" {
  name             = "jussilog-backend-warmup"
  description      = "Keep jussilog-backend warm"
  region           = var.region
  schedule         = "*/5 * * * *"
  time_zone        = "UTC"
  attempt_deadline = "30s"

  http_target {
    uri         = "${var.app_url}/_ah/warmup"
    http_method = "GET"
  }

  retry_config {
    retry_count = 0
  }

  depends_on = [
    google_project_service.apis,
  ]
}
