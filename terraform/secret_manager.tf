# Secret Manager — creates the secret *containers* only.
# Secret *values* are managed outside Terraform (via update-secret-manager.sh
# or the GCP console) to avoid sensitive data appearing in Terraform state.
#
# To populate a secret after `terraform apply`:
#   echo -n "value" | gcloud secrets versions add LARAVEL_BACKEND_APP_KEY \
#     --data-file=- --project=client-jussimatic

locals {
  laravel_secrets = [
    "LARAVEL_BACKEND_APP_KEY",
    "LARAVEL_BACKEND_DB_PASSWORD",
    "LARAVEL_BACKEND_GCS_ACCESS_KEY_ID",
    "LARAVEL_BACKEND_GCS_SECRET_ACCESS_KEY",
    "LARAVEL_BACKEND_MAIL_PASSWORD",
    "LARAVEL_BACKEND_MAIL_USERNAME",
    "LARAVEL_BACKEND_MAIL_FROM_ADDRESS",
    "LARAVEL_BACKEND_GOOGLE_CLIENT_ID",
    "LARAVEL_BACKEND_UPDATE_USER_ROLE_SECRET",
    "LARAVEL_BACKEND_ROLE_UPDATE_KEY",
  ]
}

resource "google_secret_manager_secret" "laravel_backend" {
  for_each  = toset(local.laravel_secrets)
  secret_id = each.key

  replication {
    auto {}
  }
}
