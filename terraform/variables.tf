variable "project_id" {
  description = "GCP project ID"
  type        = string
  default     = "client-jussimatic"
}

variable "region" {
  description = "GCP region for all resources"
  type        = string
  default     = "europe-north1"
}

# --- App ---

variable "app_url" {
  description = "Public URL of the Laravel backend"
  type        = string
  default     = "https://backend-jussilog.jussialanen.com"
}

variable "frontend_url" {
  description = "Public URL of the frontend"
  type        = string
  default     = "https://www.jussialanen.com"
}

# --- Database ---

variable "db_instance_name" {
  description = "Cloud SQL instance name"
  type        = string
  default     = "jussilog-db"
}

variable "db_database" {
  description = "MySQL database name inside Cloud SQL"
  type        = string
  default     = "jussilog"
}

variable "db_username" {
  description = "MySQL application user"
  type        = string
  default     = "jussilog"
}

variable "db_tier" {
  description = "Cloud SQL machine tier (see: gcloud sql tiers list)"
  type        = string
  default     = "db-g1-small"
}

variable "db_password" {
  description = "MySQL password for the jussilog DB user. Never commit this value — pass via -var or a gitignored *.tfvars.secret file."
  type        = string
  sensitive   = true
}

# --- Storage ---

variable "gcs_bucket" {
  description = "GCS bucket for Laravel file uploads"
  type        = string
  default     = "jussilog-backend-uploads"
}

# --- Cloud Run ---

variable "cloud_run_service_name" {
  description = "Cloud Run service name"
  type        = string
  default     = "jussilog-backend-production"
}

variable "cloud_run_min_instances" {
  description = "Minimum number of Cloud Run instances (set to 1 to avoid cold starts)"
  type        = number
  default     = 1
}

variable "cloud_run_max_instances" {
  description = "Maximum number of Cloud Run instances"
  type        = number
  default     = 3
}

variable "cloud_run_memory" {
  description = "Memory limit per Cloud Run instance"
  type        = string
  default     = "512Mi"
}

variable "cloud_run_cpu" {
  description = "CPU limit per Cloud Run instance"
  type        = string
  default     = "1"
}

variable "cloud_run_concurrency" {
  description = "Max concurrent requests per instance"
  type        = number
  default     = 16
}

variable "cloud_run_timeout" {
  description = "Request timeout in seconds"
  type        = number
  default     = 60
}

# --- Mail ---

variable "mail_host" {
  description = "SMTP relay host"
  type        = string
  default     = "smtp-relay.brevo.com"
}

variable "mail_enabled" {
  description = "Whether outbound mail is enabled"
  type        = string
  default     = "true"
}

# --- Artifact Registry ---

variable "ar_repository_id" {
  description = "Artifact Registry repository ID"
  type        = string
  default     = "jussilog-backend"
}
