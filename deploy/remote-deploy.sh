#!/usr/bin/env bash
# Runs ON THE VPS, invoked over SSH by .github/workflows/deploy.yml on every
# push to main. Assumes the one-time setup documented in deploy/README.md has
# already happened: the repo is checked out, .env exists with real secrets,
# and the host-level nginx vhost + TLS cert are in place. This script only
# ever updates code and restarts containers — it never touches .env, nginx,
# or certificates, so a bad deploy can't take those down with it.
set -euo pipefail

APP_DIR="${APP_DIR:-$HOME/Bisa-lms}"
HEALTH_URL="${HEALTH_URL:-http://127.0.0.1:8084/api/health}"

cd "$APP_DIR"

echo "==> fetching origin/main"
git fetch origin main
git reset --hard origin/main

# Read by App\Support\ServiceHealth::deployedRevision(), surfaced on
# /api/monitor/metrics so "what's actually running" is never a guess.
git rev-parse HEAD > REVISION

echo "==> building the app and web images"
docker compose build app web

echo "==> recreating containers that changed"
docker compose up -d --remove-orphans

echo "==> waiting for the app container to report healthy"
tries=0
until [ "$(docker inspect -f '{{.State.Health.Status}}' bisa-lms-app 2>/dev/null)" = "healthy" ]; do
    tries=$((tries + 1))
    if [ "$tries" -ge 60 ]; then
        echo "app container did not become healthy within 60s" >&2
        docker compose logs --tail=80 app
        exit 1
    fi
    sleep 1
done

echo "==> verifying $HEALTH_URL"
if ! curl -fsS --max-time 10 "$HEALTH_URL" > /dev/null; then
    echo "health check failed after deploy" >&2
    docker compose logs --tail=80 app web
    exit 1
fi

echo "==> pruning old, now-unused images (keeps disk from filling up over time)"
docker image prune -f > /dev/null

echo "==> deploy OK: $(cat REVISION)"
