#!/bin/sh
# scripts/download-ai-agent-key.sh
#
# Downloads the AI agent service account key for local development.
# Skips if the key file already exists.
#
# Usage:
#   scripts/download-ai-agent-key.sh

set -e

# ── Configuration ────────────────────────────────────────────────────────────
PROJECT="client-jussimatic"
SERVICE_ACCOUNT="ai-agent@client-jussimatic.iam.gserviceaccount.com"
KEY_FILE="secrets/client-jussimatic-052984d5498b.json"
# ─────────────────────────────────────────────────────────────────────────────

if ! command -v gcloud >/dev/null 2>&1; then
  echo "ERROR: gcloud CLI not found. Install it from https://cloud.google.com/sdk/docs/install"
  exit 1
fi

if [ -f "$KEY_FILE" ]; then
  echo "Key file already exists: $KEY_FILE — skipping download."
  exit 0
fi

mkdir -p secrets

echo "Downloading service account key..."
echo "  Project         : $PROJECT"
echo "  Service account : $SERVICE_ACCOUNT"
echo "  Output          : $KEY_FILE"
echo ""

gcloud iam service-accounts keys create "$KEY_FILE" \
  --iam-account="$SERVICE_ACCOUNT" \
  --project="$PROJECT"

echo ""
echo "Done. Add this to your .env:"
echo "  VERTEX_AI_KEY_FILE=$(pwd)/$KEY_FILE"
