terraform {
  required_version = ">= 1.5"

  required_providers {
    google = {
      source  = "hashicorp/google"
      version = "~> 5.0"
    }
  }
}

provider "google" {
  project = var.project_id
  region  = var.region
}

# Used to resolve the numeric project number (needed for some IAM bindings)
data "google_project" "project" {
  project_id = var.project_id
}
