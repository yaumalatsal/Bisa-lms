# syntax=docker/dockerfile:1

# One base for building and running: this app's composer.lock has already
# tripped a PHP-version platform check once (it needs >= 8.4.1). Running
# `composer install` under a separate composer:* image's own bundled PHP
# risks hitting that same mismatch again; running it under this exact image's
# php instead — by copying in just the composer.phar binary — cannot.
FROM php:8.4-fpm-alpine AS app

RUN apk add --no-cache \
        libpng libjpeg-turbo libwebp freetype \
        libzip icu-libs oniguruma bash \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS libpng-dev libjpeg-turbo-dev libwebp-dev freetype-dev \
        libzip-dev icu-dev oniguruma-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql mbstring exif pcntl bcmath gd zip intl opcache \
    && apk del .build-deps

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Modest OPcache: this host does not have RAM to spare on a large cache, and a
# few dozen MB is plenty for an app this size. validate_timestamps=0 means a
# deploy MUST recreate this container (a rebuilt image) for code to take
# effect, rather than relying on a file-mtime check — which is exactly how the
# deploy script here works, not a bind-mounted checkout.
RUN { \
        echo 'opcache.enable=1'; \
        echo 'opcache.memory_consumption=64'; \
        echo 'opcache.interned_strings_buffer=8'; \
        echo 'opcache.max_accelerated_files=10000'; \
        echo 'opcache.validate_timestamps=0'; \
    } > /usr/local/etc/php/conf.d/opcache-prod.ini \
    && { \
        echo 'upload_max_filesize=20M'; \
        echo 'post_max_size=20M'; \
        echo 'memory_limit=128M'; \
    } > /usr/local/etc/php/conf.d/limits.ini

# php-fpm sized for a small box: a handful of workers, not the 50 the stock
# pool config would happily spawn under load.
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/zz-www.conf

WORKDIR /var/www

# Dependencies first, on their own layer keyed to the lock file, so an app
# code change never re-triggers a composer install.
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev --no-scripts --no-autoloader --no-interaction --prefer-dist

COPY . .

# Populate the skeleton so the FIRST run of each named volume (storage,
# logo_produk, poster_produk — see docker-compose.yml) inherits it: Docker
# copies an empty named volume's mount point from the image on first use.
RUN composer dump-autoload --optimize --no-scripts \
    && mkdir -p storage/framework/{cache,sessions,testing,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache public/logo_produk public/poster_produk

COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]

# ---- web: nginx, serving the SAME public/ this build produced. Built from
#      this Dockerfile (not the stock nginx:alpine compose would otherwise
#      need a bind mount for) so the static assets under public/ — the theme,
#      compiled CSS/JS, images — are always exactly what this deploy shipped,
#      with no separate copy step to keep in sync. Only the handful of
#      directories that change at runtime (uploads, storage) are real shared
#      volumes; see docker-compose.yml. ----
FROM nginx:1.27-alpine AS web
COPY --from=app /var/www/public /var/www/public
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
