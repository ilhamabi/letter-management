########################################
# Stage 1: Build frontend assets (Vite)
########################################
FROM node:20-bookworm-slim AS node-builder

WORKDIR /app

# Stage ini cuma butuh Node untuk build assets (vite), tidak butuh Chrome
# Puppeteer sama sekali. Skip auto-download Chrome supaya npm ci tidak
# gagal/lambat karena mendownload browser yang tidak dipakai di sini.
ENV PUPPETEER_SKIP_DOWNLOAD=true

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

########################################
# Stage 2: Install PHP dependencies
########################################
FROM composer:2 AS composer-builder

WORKDIR /app

COPY composer.json composer.lock ./

# ignore-platform-reqs here is fine: this stage only resolves/downloads
# packages, it does not execute PHP code that needs gd/etc.
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-interaction \
    --optimize-autoloader \
    --ignore-platform-reqs

########################################
# Stage 3: Final runtime image
########################################
FROM php:8.3-fpm-bookworm AS runtime

# ---- System dependencies ----
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    supervisor \
    curl \
    gnupg \
    ca-certificates \
    unzip \
    git \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    # ---- Chrome headless runtime deps (for Browsershot/Puppeteer) ----
    libnss3 \
    libatk1.0-0 \
    libatk-bridge2.0-0 \
    libcups2 \
    libdrm2 \
    libxkbcommon0 \
    libxcomposite1 \
    libxdamage1 \
    libxfixes3 \
    libxrandr2 \
    libgbm1 \
    libasound2 \
    libpango-1.0-0 \
    libpangocairo-1.0-0 \
    fonts-liberation \
    && rm -rf /var/lib/apt/lists/*

# ---- PHP extensions ----
RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo_mysql \
        zip \
        intl \
        bcmath \
        opcache

# ---- Node.js 20 (needed at RUNTIME by Browsershot/Puppeteer) ----
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# ---- App code ----
COPY . .

# ---- Vendor from composer stage ----
COPY --from=composer-builder /app/vendor ./vendor

# ---- Built frontend assets from node stage ----
COPY --from=node-builder /app/public/build ./public/build

# ---- Node runtime deps (only "dependencies", not devDependencies) ----
# Skip Puppeteer's own auto-download here too — we explicitly install
# chrome-headless-shell in the next step instead.
ENV PUPPETEER_SKIP_DOWNLOAD=true
# Force a fixed, known cache dir so both the install step (run as root)
# and the app at runtime (run as www-data) look in the same place.
ENV PUPPETEER_CACHE_DIR=/var/www/.cache/puppeteer
COPY package.json package-lock.json ./
RUN npm ci --omit=dev

# ---- Install headless Chrome used by Puppeteer/Browsershot ----
RUN npx puppeteer browsers install chrome-headless-shell

# ---- Laravel post-install steps ----
RUN php artisan package:discover --ansi || true

# ---- Permissions ----
RUN chown -R www-data:www-data /var/www/html /var/www/.cache \
    && chmod -R 775 storage bootstrap/cache

# ---- Config files ----
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
