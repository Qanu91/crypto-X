#!/bin/sh
# ==============================================================
# entrypoint.sh — Container startup script for crypto-exchange
# ==============================================================
set -e

log()  { echo "[entrypoint] $*"; }
ok()   { echo "[entrypoint] ✔ $*"; }
warn() { echo "[entrypoint] ⚠ $*"; }
fail() { echo "[entrypoint] ✘ $*" >&2; exit 1; }

# --------------------------------------------------------------
# 1. Resolve PORT (Render/Railway inject this)
# --------------------------------------------------------------
APP_PORT="${PORT:-8080}"
log "Container will listen on port ${APP_PORT}"
export NGINX_PORT="${APP_PORT}"

# --------------------------------------------------------------
# 2. Write Nginx config with correct port
# --------------------------------------------------------------
log "Writing Nginx config for port ${APP_PORT}..."
envsubst '${NGINX_PORT}' \
    < /etc/nginx/templates/default.conf.template \
    > /etc/nginx/http.d/default.conf
ok "Nginx config written."

# --------------------------------------------------------------
# 3. Fix permissions
# --------------------------------------------------------------
log "Setting directory permissions..."
mkdir -p /var/www/html/storage/app/public \
         /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache
ok "Permissions set."

# --------------------------------------------------------------
# 4. Wait for database
# --------------------------------------------------------------
if [ "${WAIT_FOR_DB:-false}" = "true" ]; then
    DB_HOST="${DB_HOST:-127.0.0.1}"
    DB_PORT="${DB_PORT:-3306}"
    log "Waiting for database at ${DB_HOST}:${DB_PORT}..."
    RETRIES=30
    until nc -z -w3 "${DB_HOST}" "${DB_PORT}" 2>/dev/null; do
        RETRIES=$((RETRIES - 1))
        [ "${RETRIES}" -le 0 ] && fail "Database not reachable after 30 attempts."
        warn "Database not ready — retrying in 2s... (${RETRIES} left)"
        sleep 2
    done
    ok "Database is reachable."
fi

# --------------------------------------------------------------
# 5. Create storage symlink
# --------------------------------------------------------------
if [ ! -L /var/www/html/public/storage ]; then
    log "Creating storage symlink..."
    su-exec www-data php /var/www/html/artisan storage:link --force 2>/dev/null || true
    ok "Storage symlink created."
else
    ok "Storage symlink already exists."
fi

# --------------------------------------------------------------
# 6. Run migrations (set RUN_MIGRATIONS=true to enable)
# --------------------------------------------------------------
if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    log "Running database migrations..."
    su-exec www-data php /var/www/html/artisan migrate --force --no-interaction
    ok "Migrations complete."
fi

# --------------------------------------------------------------
# 7. Cache config, routes, views
# --------------------------------------------------------------
log "Caching Laravel config, routes, and views..."
su-exec www-data php /var/www/html/artisan config:cache
su-exec www-data php /var/www/html/artisan route:cache
su-exec www-data php /var/www/html/artisan view:cache
su-exec www-data php /var/www/html/artisan event:cache
ok "Laravel caches warmed."

# --------------------------------------------------------------
# 8. Start Supervisor (Nginx + PHP-FPM + queue worker)
# --------------------------------------------------------------
log "Starting Supervisord..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
