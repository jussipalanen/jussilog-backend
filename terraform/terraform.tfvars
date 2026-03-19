# Non-sensitive defaults — safe to commit.
# Sensitive values (passwords, API keys) are stored in Secret Manager and
# never appear here. See secret_manager.tf for the secret resource definitions.

project_id = "client-jussimatic"
region     = "europe-north1"

app_url      = "https://backend-jussilog.jussialanen.com"
frontend_url = "https://www.jussialanen.com"

db_instance_name = "jussilog-db"
db_database      = "jussilog"
db_username      = "jussilog"
db_tier          = "db-g1-small"

gcs_bucket = "jussilog-backend-uploads"

cloud_run_service_name  = "jussilog-backend-production"
cloud_run_min_instances = 1
cloud_run_max_instances = 3
cloud_run_memory        = "512Mi"
cloud_run_cpu           = "1"
cloud_run_concurrency   = 16
cloud_run_timeout       = 60

mail_host    = "smtp-relay.brevo.com"
mail_enabled = "true"

ar_repository_id = "jussilog-backend"
