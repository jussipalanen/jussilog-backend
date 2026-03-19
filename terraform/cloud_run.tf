resource "google_cloud_run_v2_service" "jussilog_backend" {
  name     = var.cloud_run_service_name
  location = var.region

  # Allow unauthenticated requests (public API)
  ingress = "INGRESS_TRAFFIC_ALL"

  template {
    service_account = google_service_account.cloud_run.email

    execution_environment = "EXECUTION_ENVIRONMENT_GEN2"

    max_instance_request_concurrency = var.cloud_run_concurrency

    timeout = "${var.cloud_run_timeout}s"

    scaling {
      min_instance_count = var.cloud_run_min_instances
      max_instance_count = var.cloud_run_max_instances
    }

    # Mount the Cloud SQL Unix socket
    volumes {
      name = "cloudsql"
      cloud_sql_instance {
        instances = [google_sql_database_instance.jussilog_db.connection_name]
      }
    }

    containers {
      # Cloud Build updates this image on every deploy — Terraform ignores it
      # after the first apply (see lifecycle block below).
      image = "${var.region}-docker.pkg.dev/${var.project_id}/${var.ar_repository_id}/jussilog-backend:latest"

      resources {
        limits = {
          cpu    = var.cloud_run_cpu
          memory = var.cloud_run_memory
        }
        # Keep CPU allocated only during request processing
        cpu_idle = true
        # Boost CPU during container startup to reduce cold-start latency
        startup_cpu_boost = true
      }

      ports {
        container_port = 8080
      }

      volume_mounts {
        name       = "cloudsql"
        mount_path = "/cloudsql"
      }

      # -----------------------------------------------------------------------
      # Non-secret environment variables
      # -----------------------------------------------------------------------
      env { name = "APP_NAME";    value = "JussiLog" }
      env { name = "APP_ENV";     value = "production" }
      env { name = "APP_DEBUG";   value = "false" }
      env { name = "APP_URL";     value = var.app_url }
      env { name = "FRONTEND_URL"; value = var.frontend_url }

      env { name = "SCRIBE_BASE_URL";          value = var.app_url }
      env { name = "SCRIBE_TRY_IT_OUT_BASE_URL"; value = var.app_url }

      env { name = "DB_CONNECTION"; value = "mysql" }
      env { name = "DB_HOST";       value = "localhost" }
      env { name = "DB_SOCKET";     value = "/cloudsql/${google_sql_database_instance.jussilog_db.connection_name}" }
      env { name = "DB_PORT";       value = "3306" }
      env { name = "DB_DATABASE";   value = var.db_database }
      env { name = "DB_USERNAME";   value = var.db_username }

      env { name = "CACHE_DRIVER";     value = "file" }
      env { name = "SESSION_DRIVER";   value = "file" }
      env { name = "QUEUE_CONNECTION"; value = "sync" }
      env { name = "LOG_CHANNEL";      value = "stderr" }
      env { name = "LOG_LEVEL";        value = "error" }

      env { name = "FILESYSTEM_DISK";           value = "gcs" }
      env { name = "GCS_DEFAULT_REGION";        value = "us" }
      env { name = "GCS_BUCKET";                value = var.gcs_bucket }
      env { name = "GCS_URL";                   value = "" }
      env { name = "GCS_ENDPOINT";              value = "https://storage.googleapis.com" }
      env { name = "GCS_USE_PATH_STYLE_ENDPOINT"; value = "false" }

      env { name = "MAIL_ENABLED";    value = var.mail_enabled }
      env { name = "MAIL_MAILER";     value = "smtp" }
      env { name = "MAIL_HOST";       value = var.mail_host }
      env { name = "MAIL_PORT";       value = "587" }
      env { name = "MAIL_ENCRYPTION"; value = "tls" }
      env { name = "MAIL_FROM_NAME";  value = "JussiLog" }

      # -----------------------------------------------------------------------
      # Secret environment variables — pulled from Secret Manager at runtime.
      # This is more secure than injecting secrets as plain env vars via
      # Cloud Build (the previous approach baked secrets into the revision).
      # -----------------------------------------------------------------------
      env {
        name = "APP_KEY"
        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.laravel_backend["LARAVEL_BACKEND_APP_KEY"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name = "DB_PASSWORD"
        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.laravel_backend["LARAVEL_BACKEND_DB_PASSWORD"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name = "GCS_ACCESS_KEY_ID"
        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.laravel_backend["LARAVEL_BACKEND_GCS_ACCESS_KEY_ID"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name = "GCS_SECRET_ACCESS_KEY"
        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.laravel_backend["LARAVEL_BACKEND_GCS_SECRET_ACCESS_KEY"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name = "MAIL_PASSWORD"
        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.laravel_backend["LARAVEL_BACKEND_MAIL_PASSWORD"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name = "MAIL_USERNAME"
        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.laravel_backend["LARAVEL_BACKEND_MAIL_USERNAME"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name = "MAIL_FROM_ADDRESS"
        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.laravel_backend["LARAVEL_BACKEND_MAIL_FROM_ADDRESS"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name = "GOOGLE_CLIENT_ID"
        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.laravel_backend["LARAVEL_BACKEND_GOOGLE_CLIENT_ID"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name = "UPDATE_USER_ROLE_SECRET"
        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.laravel_backend["LARAVEL_BACKEND_UPDATE_USER_ROLE_SECRET"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name = "ROLE_UPDATE_KEY"
        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.laravel_backend["LARAVEL_BACKEND_ROLE_UPDATE_KEY"].secret_id
            version = "latest"
          }
        }
      }
    }
  }

  # Cloud Build updates the container image on every deploy.
  # Ignore image changes here so `terraform plan` stays clean between builds.
  lifecycle {
    ignore_changes = [
      template[0].containers[0].image,
    ]
  }

  depends_on = [
    google_project_iam_member.cloud_run_secret_accessor,
    google_project_iam_member.cloud_run_sql_client,
  ]
}

# Make the service publicly accessible (no auth header required)
resource "google_cloud_run_v2_service_iam_member" "public_invoker" {
  project  = var.project_id
  location = var.region
  name     = google_cloud_run_v2_service.jussilog_backend.name
  role     = "roles/run.invoker"
  member   = "allUsers"
}
