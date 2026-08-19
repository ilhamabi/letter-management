#!/bin/sh
set -e

cd /var/www/html

# Buat .env kalau belum ada (Coolify biasanya sudah inject env vars langsung,
# tapi ini jaga-jaga kalau butuh file .env fisik)
if [ ! -f .env ] && [ -f .env.example ]; then
    cp .env.example .env
fi

# ---- Chrome executable path: beda tergantung arsitektur ----
# ARM64: pakai system chromium (dari apt, di-install di Dockerfile)
# x64/amd64: biarkan kosong, Puppeteer otomatis pakai chrome-headless-shell
#            yang sudah di-download sendiri saat build
ARCH="$(uname -m)"
if [ "$ARCH" = "aarch64" ] || [ "$ARCH" = "arm64" ]; then
    export PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium
    echo "[entrypoint] Detected ARM64 ($ARCH) — using system chromium at $PUPPETEER_EXECUTABLE_PATH"
    # ---- Verifikasi Chromium dapat dijalankan ----
    if [ -x /usr/bin/chromium ]; then
        echo "[entrypoint] Chromium OK: $(/usr/bin/chromium --version 2>&1 | head -1)"
    else
        echo "[entrypoint] ERROR: /usr/bin/chromium tidak ditemukan atau tidak dapat dieksekusi!"
    fi
else
    echo "[entrypoint] Detected $ARCH — using Puppeteer-downloaded chrome-headless-shell"
fi

# ---- Verifikasi Node.js tersedia (dibutuhkan Browsershot) ----
if command -v node >/dev/null 2>&1; then
    echo "[entrypoint] Node.js OK: $(node --version)"
else
    echo "[entrypoint] ERROR: node tidak ditemukan di PATH!"
fi
if command -v npm >/dev/null 2>&1; then
    echo "[entrypoint] npm OK: $(npm --version)"
fi

php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan storage:link || true

exec "$@"
