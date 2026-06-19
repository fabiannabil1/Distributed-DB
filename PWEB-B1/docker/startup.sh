#!/bin/bash
# ============================================================================
# Laravel App Startup Script
# Runs migrations and seeders, then starts supervisor (nginx + php-fpm)
# ============================================================================

set -e

echo "[$(date '+%Y-%m-%d %H:%M:%S')] Waiting for database to be ready..."

# Wait for pgpool to accept connections (max 30 seconds)
MAX_RETRIES=30
RETRY=0
until php artisan tinker --execute="DB::connection()->getPdo();" > /dev/null 2>&1; do
    RETRY=$((RETRY + 1))
    if [ $RETRY -ge $MAX_RETRIES ]; then
        echo "[$(date '+%Y-%m-%d %H:%M:%S')] ERROR: Database not ready after ${MAX_RETRIES}s. Starting without migration."
        exec /usr/bin/supervisord -c /etc/supervisord.conf
    fi
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Database not ready yet... retry $RETRY/$MAX_RETRIES"
    sleep 1
done

echo "[$(date '+%Y-%m-%d %H:%M:%S')] Database is ready!"

# Run migrations
echo "[$(date '+%Y-%m-%d %H:%M:%S')] Running migrations..."
php artisan migrate --force --no-interaction

# Run seeders (only if tables are empty)
ADMIN_COUNT=$(php artisan tinker --execute="echo App\Models\Admin::count();" 2>/dev/null || echo "0")
if [ "$ADMIN_COUNT" = "0" ]; then
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Seeding database (first run)..."
    php artisan db:seed --force --no-interaction
else
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Database already seeded (${ADMIN_COUNT} admins found). Skipping."
fi

echo "[$(date '+%Y-%m-%d %H:%M:%S')] Starting supervisor (nginx + php-fpm)..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
