#!/bin/bash
# ============================================================================
# Replica Entrypoint Script - docker/pg-replica/entrypoint.sh
# Handles base backup from master and starts replica in recovery mode
# ============================================================================

set -e

echo "[$(date '+%Y-%m-%d %H:%M:%S')] Starting replica setup..."

# We use a sentinel file inside the data directory to know if base backup is done
DATA_DIR="/var/lib/postgresql/data"
SENTINEL="$DATA_DIR/replica_initialized"

# Remove any stale postmaster.pid that might prevent startup
rm -f "$DATA_DIR/postmaster.pid" 2>/dev/null || true

if [ -f "$SENTINEL" ]; then
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Replica already initialized. Starting..."
    # standby.signal already exists from pg_basebackup -R; postmaster.pid
    # already cleaned above. Just start.
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Starting PostgreSQL replica..."
    exec docker-entrypoint.sh \
        -c config_file=/etc/postgresql/custom/postgresql.conf \
        -c hba_file=/etc/postgresql/custom/pg_hba.conf
else
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Running pg_basebackup from pg-master..."

    # Clean data directory
    rm -rf "$DATA_DIR"/*

    # Run base backup
    export PGPASSWORD="replpassword"
    pg_basebackup \
        -h pg-master \
        -p 5432 \
        -U repluser \
        -D "$DATA_DIR" \
        -Fp \
        -Xs \
        -P \
        -R

    # pg_basebackup -R flag already creates standby.signal and
    # writes primary_conninfo to postgresql.auto.conf automatically.

    # Touch sentinel so we skip base backup on restarts
    touch "$SENTINEL"

    echo "[$(date '+%Y-%m-%d %H:%M:%S')] pg_basebackup complete. Starting replica..."
    exec docker-entrypoint.sh \
        -c config_file=/etc/postgresql/custom/postgresql.conf \
        -c hba_file=/etc/postgresql/custom/pg_hba.conf
fi
