# Remote state in GCS — recommended for team use and CI/CD.
#
# To bootstrap:
#   1. Create the state bucket manually (once):
#      gcloud storage buckets create gs://<YOUR_PROJECT_ID>-terraform-state \
#        --project=<YOUR_PROJECT_ID> --location=europe-north1 \
#        --uniform-bucket-level-access
#   2. Fill in the bucket name below, uncomment, then run:
#      terraform init -migrate-state

# terraform {
#   backend "gcs" {
#     bucket = "<YOUR_PROJECT_ID>-terraform-state"
#     prefix = "jussilog-backend"
#   }
# }
