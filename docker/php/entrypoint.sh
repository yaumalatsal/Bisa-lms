#!/bin/sh
# Runs once every time the app container starts — a fresh deploy, a crash
# restart, or a manual `docker compose restart` alike — so the app is never
# left half-migrated or serving a stale cached route/config table.
set -eu

cd /var/www

# Compose already waits for MySQL's own healthcheck before starting this
# container, but there is a narrow window between "the port is open" and
# "docker-compose noticed and started us". A bare TCP check (busybox's `nc`,
# built into Alpine — nothing extra to install) is enough of a backstop and,
# unlike an artisan command, does not care whether a migrations table exists
# yet, so it behaves the same on the very first deploy as on every one after.
#
# DB_HOST/DB_PORT arrive as real process environment variables (this app's
# `env_file: .env` in docker-compose.yml, not a bind-mounted file) — read them
# directly rather than trying to re-parse a .env file that does not exist
# inside this container.
db_host="${DB_HOST:-db}"
db_port="${DB_PORT:-3306}"

echo "[entrypoint] waiting for ${db_host:-db}:${db_port}..."
tries=0
until nc -z -w1 "${db_host:-db}" "$db_port" 2>/dev/null; do
    tries=$((tries + 1))
    if [ "$tries" -ge 30 ]; then
        echo "[entrypoint] ${db_host:-db}:${db_port} still unreachable after ${tries}s, giving up" >&2
        exit 1
    fi
    sleep 1
done

echo "[entrypoint] clearing stale caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "[entrypoint] running migrations..."
php artisan migrate --force

echo "[entrypoint] seeding reference data (idempotent)..."
php artisan db:seed --force

echo "[entrypoint] linking storage..."
php artisan storage:link > /dev/null 2>&1 || true

# No config:cache: config/navigation.php stores real Closures (the sidebar's
# per-item `when` visibility checks), and config:cache works by var_export-ing
# the merged config array — which cannot represent a Closure and hard-fails
# the whole cache with "Your configuration files are not serializable."
# Route and view caching have no such value in them and are safe.
echo "[entrypoint] caching routes/views..."
php artisan route:cache
php artisan view:cache

echo "[entrypoint] ready."
exec "$@"
