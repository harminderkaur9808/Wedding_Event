#!/bin/bash
# Run this on the server after every "git pull" (e.g. after you push code).
# Usage: ./deploy.sh   or   bash deploy.sh

set -e
cd "$(dirname "$0")"

echo "=== Ensuring storage link ==="
rm -f public/storage
ln -sfn ../storage/app/public public/storage
echo "  public/storage -> ../storage/app/public"

echo "=== Laravel cache clear ==="
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear 2>/dev/null || true

echo "=== Done. Storage link and caches are ready. ==="
