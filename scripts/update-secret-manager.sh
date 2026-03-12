#!/bin/bash

set -e

PROJECT_ID="client-jussimatic"
PREFIX="LARAVEL_BACKEND"
ENV_FILE=".env.production"

# ─── KEYS TO SYNC ─────────────────────────────────────────────────────────────
# Only real secrets belong here — not plain config values like URLs or usernames.
SECRET_KEYS=(
  "APP_KEY"
  "DB_PASSWORD"
  "GCS_ACCESS_KEY_ID"
  "GCS_SECRET_ACCESS_KEY"
  "MAIL_PASSWORD"
  "SCRIBE_AUTH_KEY"
  "GOOGLE_CLIENT_ID"
  "UPDATE_USER_ROLE_SECRET"
  "ROLE_UPDATE_KEY"
)
# ──────────────────────────────────────────────────────────────────────────────

if [[ ! -f "$ENV_FILE" ]]; then
  echo "❌ $ENV_FILE not found"
  exit 1
fi

# Parse a value from .env file for a given key
get_env_value() {
  local key="$1"
  local value

  # Match KEY=VALUE or KEY="VALUE" or KEY='VALUE', ignore comments
  value=$(grep -E "^${key}=" "$ENV_FILE" | head -1 | sed "s/^${key}=//")

  # Strip surrounding quotes if present
  value="${value%\"}"
  value="${value#\"}"
  value="${value%\'}"
  value="${value#\'}"

  echo "$value"
}

echo "📄 Reading from $ENV_FILE"
echo ""

for key in "${SECRET_KEYS[@]}"; do
  secret_name="${PREFIX}_${key}"
  secret_value=$(get_env_value "$key")

  if [[ -z "$secret_value" ]]; then
    echo "⚠️  Skipping  $secret_name  (empty value in $ENV_FILE)"
    continue
  fi

  if gcloud secrets describe "$secret_name" --project="$PROJECT_ID" &>/dev/null; then
    echo "↻  Updating  $secret_name"
    echo -n "$secret_value" | gcloud secrets versions add "$secret_name" \
      --data-file=- \
      --project="$PROJECT_ID"
  else
    echo "✚  Creating  $secret_name"
    echo -n "$secret_value" | gcloud secrets create "$secret_name" \
      --data-file=- \
      --project="$PROJECT_ID" \
      --replication-policy=automatic
  fi
done

echo ""
echo "✅ Done. Grant Cloud Run SA access if not already done:"
echo "   gcloud projects add-iam-policy-binding $PROJECT_ID \\"
echo "     --member='serviceAccount:YOUR_SA@$PROJECT_ID.iam.gserviceaccount.com' \\"
echo "     --role='roles/secretmanager.secretAccessor'"