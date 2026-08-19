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

# TARGETARCH is auto-populated by Docker BuildKit (e.g. "amd64" or "arm64")
ARG TARGETARCH

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

# ---- ARM64 only: Chrome-for-Testing/chrome-headless-shell has no native ----
# ---- Linux ARM64 build, so we install Debian's system chromium instead ----
RUN if [ "$TARGETARCH" = "arm64" ]; then \
        apt-get update \
        && apt-get install -y --no-install-recommends chromium \
        && rm -rf /var/lib/apt/lists/*; \
    fi

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

# ---- Chrome/Puppeteer writable dirs (fixes "crashpad_handler: --database
# is required" — Chrome needs a writable config/cache location) ----
ENV XDG_CONFIG_HOME=/tmp/.chromium
ENV XDG_CACHE_HOME=/tmp/.chromium
RUN mkdir -p /tmp/.chromium && chmod 1777 /tmp/.chromium

WORKDIR /var/www/html

# ---- App code ----
COPY . .

# ---- Vendor from composer stage ----
COPY --from=composer-builder /app/vendor ./vendor

# ---- Built frontend assets from node stage ----
COPY --from=node-builder /app/public/build ./public/build

# ---- Node runtime deps (only "dependencies", not devDependencies) ----
ENV PUPPETEER_SKIP_DOWNLOAD=true
COPY package.json package-lock.json ./
RUN npm ci --omit=dev

# ---- Install Chrome for Puppeteer/Browsershot ----
# amd64: download official chrome-headless-shell (native build exists)
# arm64: skip download, we already installed system "chromium" via apt above
RUN if [ "$TARGETARCH" != "arm64" ]; then \
        npx puppeteer browsers install chrome-headless-shell; \
    fi

# ---- Laravel post-install steps ----
RUN php artisan package:discover --ansi || true

# ---- Permissions ----
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# ---- Config files ----
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
