# Deploying Bisa-lms

Every push to `main` that passes the test suite deploys automatically via
`.github/workflows/deploy.yml`. This file covers the one-time setup that has
to happen before that pipeline has anything to SSH into.

## One-time VPS setup

1. **Clone the repo** wherever `APP_DIR` in `deploy/remote-deploy.sh` expects
   it (default: `~/Bisa-lms`).
2. **Create `.env`** in that directory — copy `.env.example`, then set at
   least: `APP_KEY` (`php artisan key:generate --show`), `APP_URL`,
   `DB_DATABASE`/`DB_USERNAME`/`DB_PASSWORD` (the `db` service in
   `docker-compose.yml` reads these same three to provision the MySQL
   container), `ADMIN_EMAIL`/`ADMIN_PASSWORD`, and `MONITOR_API_TOKEN`
   (`php artisan monitor:token` once the vendor directory exists, or any
   random string — whatever a monitoring console will present back on
   `X-Monitor-Token`). This file is never touched by the deploy script or
   committed to git.
3. **Bring the stack up**: `docker compose build && docker compose up -d`.
   The app container's entrypoint runs migrations, seeds reference data, and
   warms the caches on every start — nothing else to run by hand.
4. **Put a reverse proxy in front of it.** The `web` service only listens on
   `127.0.0.1:8084`; a host-level nginx (or whatever already terminates TLS
   for the other sites on the box) proxies the public hostname to that port
   and holds the certificate. This repo does not manage that vhost, since it
   sits alongside unrelated sites on a shared box.
5. **Add the GitHub Actions secrets** the workflow needs:

   | Secret | Value |
   |---|---|
   | `VPS_HOST` | the server's address |
   | `VPS_USER` | the SSH user the deploy key was added for |
   | `VPS_SSH_KEY` | the deploy key's **private** half, in full, including the `BEGIN`/`END` lines |
   | `VPS_PORT` | SSH port (usually `22`) |

   Use a key generated just for this — `ssh-keygen -t ed25519 -f deploy_key -N ""`
   — with only its public half appended to that user's `authorized_keys`. It
   needs no more access than deploying this one app.

## What every deploy does

`deploy/remote-deploy.sh` — `git fetch` + hard reset to `origin/main`,
rebuild the `app`/`web` images, recreate the changed containers, wait for the
app container's healthcheck, then confirm `/api/health` actually answers
before declaring success. It never touches `.env`, the reverse proxy, or the
certificate — a bad deploy can't take those down with it, and re-running it
is always safe (migrations and seeders are idempotent).

## Monitoring

`GET /api/health` needs no auth and reports whether the app is up at all —
what a deploy step or a load balancer checks. `GET /api/monitor/services` and
`GET /api/monitor/metrics` carry the detail (per-dependency status, business
counts) behind `MONITOR_API_TOKEN`, presented as `Authorization: Bearer
<token>` or `X-Monitor-Token: <token>`. See `config/monitor.php`.
