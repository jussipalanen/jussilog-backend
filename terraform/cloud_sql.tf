resource "google_sql_database_instance" "jussilog_db" {
  name             = var.db_instance_name
  database_version = "MYSQL_8_0"
  region           = var.region

  # Protect against accidental deletion via `terraform destroy`
  deletion_protection = true

  settings {
    tier              = var.db_tier
    availability_type = "ZONAL"
    disk_autoresize   = true
    disk_size         = 10
    disk_type         = "PD_SSD"

    backup_configuration {
      enabled            = true
      binary_log_enabled = true # required for point-in-time recovery with MySQL
      start_time         = "03:00"
    }

    maintenance_window {
      day          = 7 # Sunday
      hour         = 4
      update_track = "stable"
    }

    ip_configuration {
      # No public IP — accessed exclusively via Cloud SQL Auth Proxy (private path)
      ipv4_enabled    = false
      private_network = null # set to a VPC self_link if you add a VPC later
    }

    database_flags {
      name  = "slow_query_log"
      value = "on"
    }
  }
}

resource "google_sql_database" "jussilog" {
  name     = var.db_database
  instance = google_sql_database_instance.jussilog_db.name
  charset  = "utf8mb4"
  collation = "utf8mb4_unicode_ci"
}

resource "google_sql_user" "jussilog" {
  name     = var.db_username
  instance = google_sql_database_instance.jussilog_db.name

  # Password is managed in Secret Manager (LARAVEL_BACKEND_DB_PASSWORD).
  # Set it here only on first apply or rotation — use a *.tfvars.secret file
  # that is gitignored, or pass via: terraform apply -var="db_password=..."
  password = var.db_password
}
