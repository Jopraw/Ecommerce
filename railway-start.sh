#!/bin/bash
# AstroStep - Railway start script
# Volume (opsional) dipasang di /app/storage/app/public agar foto upload admin permanen.

set -e

# 1. Siapkan folder foto & salin foto bawaan (tidak menimpa file yang sudah ada)
mkdir -p storage/app/public/products
cp -rn resources/seed-images/products/. storage/app/public/products/ 2>/dev/null || true

# 2. Symlink public/storage -> storage/app/public
php artisan storage:link 2>/dev/null || true

# 3. Database: buat tabel & isi data awal (aman dijalankan berulang)
php artisan config:clear
php artisan migrate --force
php artisan db:seed --force

# 4. Jalankan server
php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
