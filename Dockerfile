# ==============================================================
# Multi-stage Dockerfile — crypto-exchange Laravel 12
# PHP 8.2-FPM + Nginx + Supervisor
# Target: Railway / Render Web Service (port 8080)
# NOTE: Frontend assets (public/build) are pre-built locally
#       and committed to git — no Node build step needed here.
# ==============================================================

# --------------------------------------------------------------
# Stage 1: Composer — install PHP dependencies (production only)
# --------------------------------------------------------------
FROM composer:2.8 AS composer-builder

WORKDIR /app

# Copy composer files first for layer caching
COPY composer.json composer.lock ./

# Install production dependencies only
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --ignore-platform-reqs

# Copy full source then dump optimised autoloader
COPY . .

RUN composer dump-autoload \
    --no-dev \
    --optimize \
    --classmap-authoritative


# --------------------------------------------------------------
# Stage 2: Final runtime image
# PHP 8.2-FPM + Nginx + Supervisor
# --------------------------------------------------------------
FROM php:8.2-fpm-alpine AS runtime

# ---------- System packages ----------
RUN apk add --no-cache \
    # Nginx web server
    nginx \
    # Process supervisor
    supervisor \
    # envsubst (gettext) for Nginx port substitution
    gettext \
    # su-exec: lightweight privilege drop (used in entrypoint)
    su-exec \
    # netcat-openbsd: nc command for DB wait in entrypoint
    netcat-openbsd \
    # MySQL / MariaDB client libs for pdo_mysql
    mysql-client \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    # Needed to compile GD
    g++ make autoconf

# ---------- PHP extensions ----------
# Configure GD with jpeg + freetype + webp support
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp

RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    bcmath \
    gd \
    zip \
    intl \
    mbstring \
    pcntl \
    opcache \
    exif

# ---------- PHP configuration ----------
COPY docker/php/php.ini     /usr/local/etc/php/conf.d/99-app.ini
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

# Disable the default www pool that ships with the image
RUN rm -f /usr/local/etc/php-fpm.d/www.conf.default \
    && rm -f /usr/local/etc/php-fpm.d/docker.conf \
    && rm -f /usr/local/etc/php-fpm.d/zz-docker.conf

# ---------- Nginx configuration ----------
# Alpine's nginx package uses /etc/nginx/http.d/ (not conf.d/)
# Remove the default site and create the http.d directory
RUN rm -f /etc/nginx/http.d/default.conf \
    && mkdir -p /etc/nginx/http.d

# Store our config as a template; entrypoint runs envsubst to produce
# the final conf with the correct PORT value at runtime
COPY docker/nginx/default.conf /etc/nginx/templates/default.conf.template

# Write a clean nginx.conf that includes http.d/*.conf
RUN echo "worker_processes auto;" > /etc/nginx/nginx.conf && \
    echo "error_log /var/log/nginx/error.log warn;" >> /etc/nginx/nginx.conf && \
    echo "pid /var/run/nginx.pid;" >> /etc/nginx/nginx.conf && \
    echo "events { worker_connections 1024; }" >> /etc/nginx/nginx.conf && \
    echo "http {" >> /etc/nginx/nginx.conf && \
    echo "    include /etc/nginx/mime.types;" >> /etc/nginx/nginx.conf && \
    echo "    default_type application/octet-stream;" >> /etc/nginx/nginx.conf && \
    echo "    sendfile on;" >> /etc/nginx/nginx.conf && \
    echo "    keepalive_timeout 65;" >> /etc/nginx/nginx.conf && \
    echo "    client_max_body_size 50M;" >> /etc/nginx/nginx.conf && \
    echo "    include /etc/nginx/http.d/*.conf;" >> /etc/nginx/nginx.conf && \
    echo "}" >> /etc/nginx/nginx.conf

# ---------- Supervisor configuration ----------
RUN mkdir -p /etc/supervisor/conf.d
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ---------- Log directories ----------
RUN mkdir -p \
    /var/log/supervisor \
    /var/log/nginx \
    /var/log/php \
    && touch /var/log/php/error.log \
    && touch /var/log/php/fpm-slow.log \
    && chown -R www-data:www-data /var/log/php

# ---------- Application ----------
WORKDIR /var/www/html

# Copy the full application source
COPY --chown=www-data:www-data . .

# Overwrite vendor/ with the production-only vendor from composer stage
COPY --from=composer-builder --chown=www-data:www-data /app/vendor ./vendor

# ---------- Storage & bootstrap directories ----------
# Ensure writable directories exist with correct ownership
RUN mkdir -p \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data \
        storage \
        bootstrap/cache \
    && chmod -R 755 storage bootstrap/cache

# ---------- Entrypoint ----------
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# ---------- Runtime defaults ----------
# Render injects PORT at runtime; default 8080
ENV PORT=8080 \
    APP_ENV=production \
    LOG_CHANNEL=stderr \
    QUEUE_CONNECTION=database \
    CACHE_STORE=database \
    SESSION_DRIVER=database

# Expose the port Render expects
EXPOSE 8080

# ---------- Health check ----------
# /up is the Laravel default health endpoint (registered in bootstrap/app.php)
HEALTHCHECK --interval=30s --timeout=10s --start-period=90s --retries=5 \
    CMD wget --no-verbose --tries=1 --spider "http://127.0.0.1:${PORT:-8080}/up" || exit 1

ENTRYPOINT ["/entrypoint.sh"]
