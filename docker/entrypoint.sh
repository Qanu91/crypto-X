#!/bin/sh
# ==============================================================
# entrypoint.sh — Container startup script for crypto-exchange
# Runs as root, drops to www-data for artisan commands
# ==============================================================
set -e

# Colour helpers (safe for non-TTY)
log()  { echo "[entrypoint] $*"; }
ok()   { echo "[entrypoint] ✔ $*"; }
warn() { echo "[entrypoint] ⚠ $*"; }
fail() { echo "[entrypoint] ✘ $*" >&2; exit 1; }

# --------------------------------------------------------------
# 1. Resolve the PORT Render injects (default 8080)
# --------------------------------------------------------------
APP_PORT="${PORT:-8080}"
log "Container will listen on port ${APP_PORT}"

# Export so envsubst can replace ${NGINX_PORT} in the Nginx template
export NGINX_PORT="${APP_PORT}"

# --------------------------------------------------------------
# 2. Substitute ${NGINX_PORT} into the Nginx config template
#    The template is at /etc/nginx/templates/default.conf.template
#    Output goes to /etc/nginx/conf.d/default.conf
# --------------------------------------------------------------
log "Writing Nginx config for port ${APP_PORT}..."
envsubst '${NGINX_PORT}' \
    < /etc/nginx/templates/default.conf.template \
    > /etc/nginx/http.d/default.conf
ok "Nginx config written."

# --------------------------------------------------------------
# 3. Ensure required .env file exists
# --------------------------------------------------------------
if [ ! -f /var/www/html/.env ]; then
    if [ -f /var/www/html/.env.example ]; then
        warn ".env not found — copying from .env.example"
        cp /var/www/html/.env.example /var/www/html/.env
    else
        fail ".env file is missing and no .env.example found. Aborting."
    fi
fi
ok ".env file present."

# --------------------------------------------------------------
# 4. Fix ownership and permissions
#    storage/ and bootstrap/cache/ must be writable by www-data
# --------------------------------------------------------------
log "Setting directory permissions..."

# Make sure the directories exist (in case a volume wipes them)
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

# Set ownership for www-data
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

# Directories: 755, files: 644
find /var/www/html/storage     -type d -exec chmod 755 {} \;
find /var/www/html/storage     -type f -exec chmod 644 {} \;
find /var/www/html/bootstrap/cache -type d -exec chmod 755 {} \;
find /var/www/html/bootstrap/cache -type f -exec chmod 644 {} \;

ok "Permissions set."

# --------------------------------------------------------------
# 5. Auto-set APP_URL from Railway/Render provided domain if not set
# --------------------------------------------------------------
if [ -z "${APP_URL}" ] || [ "${APP_URL}" = "http://localhost" ] || [ "${APP_URL}" = "https://your-app.onrender.com" ]; then
    # Railway injects RAILWAY_PUBLIC_DOMAIN automatically
    if [ -n "${RAILWAY_PUBLIC_DOMAIN}" ]; then
        export APP_URL="https://${RAILWAY_PUBLIC_DOMAIN}"
        log "APP_URL auto-set to ${APP_URL} from RAILWAY_PUBLIC_DOMAIN"
    # Render injects RENDER_EXTERNAL_URL automatically
    elif [ -n "${RENDER_EXTERNAL_URL}" ]; then
        export APP_URL="${RENDER_EXTERNAL_URL}"
        log "APP_URL auto-set to ${APP_URL} from RENDER_EXTERNAL_URL"
    fi
fi

# --------------------------------------------------------------
# 6. Wait for the database to be reachable
#    Controlled by WAIT_FOR_DB env var (set to "true" to enable)
# --------------------------------------------------------------
if [ "${WAIT_FOR_DB:-false}" = "true" ]; then
    DB_HOST="${DB_HOST:-127.0.0.1}"
    DB_PORT="${DB_PORT:-3306}"
    log "Waiting for database at ${DB_HOST}:${DB_PORT}..."
    RETRIES=30
    until nc -z -w3 "${DB_HOST}" "${DB_PORT}" 2>/dev/null; do
        RETRIES=$((RETRIES - 1))
        if [ "${RETRIES}" -le 0 ]; then
            fail "Database at ${DB_HOST}:${DB_PORT} not reachable after 30 attempts. Aborting."
        fi
        warn "Database not ready — retrying in 2s... (${RETRIES} attempts left)"
        sleep 2
    done
    ok "Database is reachable."
fi

# --------------------------------------------------------------
# 7. Generate APP_KEY if missing
# --------------------------------------------------------------
APP_KEY_VALUE=$(grep -E "^APP_KEY=" /var/www/html/.env | cut -d= -f2)
if [ -z "${APP_KEY_VALUE}" ] || [ "${APP_KEY_VALUE}" = '""' ]; then
    log "APP_KEY is empty — generating one..."
    su-exec www-data php /var/www/html/artisan key:generate --force
    ok "APP_KEY generated."
else
    ok "APP_KEY already set."
fi

# --------------------------------------------------------------
# 7. Create the storage symlink (public/storage → storage/app/public)
# --------------------------------------------------------------
if [ ! -L /var/www/html/public/storage ]; then
    log "Creating storage symlink..."
    su-exec www-data php /var/www/html/artisan storage:link --force 2>/dev/null || true
    ok "Storage symlink created."
else
    ok "Storage symlink already exists."
fi

# --------------------------------------------------------------
# 8. Run database migrations (optional — enable via env var)
#    Set RUN_MIGRATIONS=true in Render environment variables
# --------------------------------------------------------------
if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    log "Running database migrations..."
    su-exec www-data php /var/www/html/artisan migrate --force --no-interaction
    ok "Migrations complete."
fi

# --------------------------------------------------------------
# 9. Cache configuration, routes, and views for production
# --------------------------------------------------------------
log "Caching Laravel config, routes, and views..."
su-exec www-data php /var/www/html/artisan config:cache
su-exec www-data php /var/www/html/artisan route:cache
su-exec www-data php /var/www/html/artisan view:cache
su-exec www-data php /var/www/html/artisan event:cache
ok "Laravel caches warmed."

# --------------------------------------------------------------
# 10. Hand off to Supervisor (manages Nginx + PHP-FPM + worker)
# --------------------------------------------------------------
log "Starting Supervisord..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
