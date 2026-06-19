# Dokumentasi Implementasi Read-Write Splitting PostgreSQL dengan Pgpool-II

## Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────────────────┐
│                     Host Machine (Laptop/PC)                         │
│                                                                     │
│  ┌──────────────────────┐          ┌──────────────────────────────┐ │
│  │   Laravel App (8080) │          │   Pgpool-II (5432, 9898)     │ │
│  │   172.25.0.30        │ ───────→ │   172.25.0.20                │ │
│  │   bdt-app            │   DB     │   pgpool                     │ │
│  └──────────────────────┘          └──────┬───────────┬───────────┘ │
│                                          │           │              │
│                                   WRITE  │   SELECT  │  (balanced)   │
│                                          ▼           ▼              │
│  ┌──────────────────────┐  ┌──────────────────────┐  ┌────────────┐ │
│  │ PostgreSQL Master    │  │ PostgreSQL Replica 1 │  │ Replica 2  │ │
│  │ 172.25.0.10:5432     │  │ 172.25.0.11:5432     │  │ .0.12:5432 │ │
│  │ pg-master            │  │ pg-replica1          │  │ pg-replica2│ │
│  └──────────────────────┘  └──────────────────────┘  └────────────┘ │
│         ↑                           ↑                     ↑         │
│         └─────────── Streaming Replication ──────────────┘         │
└─────────────────────────────────────────────────────────────────────┘
```

## Topologi Jaringan

| Komponen | Container | IP Address | Port (host) | Port (container) |
|----------|-----------|------------|-------------|-------------------|
| Laravel App | `bdt-app` | 172.25.0.30 | 8080 | 80 |
| Pgpool-II | `pgpool` | 172.25.0.20 | 5436, 9898 | 5432, 9898 |
| PostgreSQL Master | `pg-master` | 172.25.0.10 | 5433 | 5432 |
| PostgreSQL Replica 1 | `pg-replica1` | 172.25.0.11 | 5434 | 5432 |
| PostgreSQL Replica 2 | `pg-replica2` | 172.25.0.12 | 5435 | 5432 |

## Spesifikasi Lingkungan

| Komponen | Spesifikasi |
|----------|-------------|
| Operating System | Ubuntu 22.04 / Linux (via Docker) |
| Database | PostgreSQL 16 |
| Middleware | Pgpool-II 4.5 (pgpool/pgpool:latest) |
| Deployment | Docker Compose |
| Bahasa Pemrograman | PHP 8.2 |
| Framework | Laravel 10 |
| Web Server | Nginx (Alpine Linux) |

## Struktur File Proyek

```
BDT/
├── docker-compose.yml              # Orchestration semua service
├── docs.md                         # Dokumentasi ini
├── docker/
│   ├── pg-master/
│   │   ├── postgresql.conf         # Konfigurasi PostgreSQL Master
│   │   ├── pg_hba.conf             # Host-Based Authentication
│   │   └── init.sql                # Inisialisasi user & role
│   ├── pg-replica/
│   │   ├── postgresql.conf         # Konfigurasi PostgreSQL Replica
│   │   └── entrypoint.sh           # Script pg_basebackup otomatis
│   └── pgpool/
│       ├── pgpool.conf             # Konfigurasi Pgpool-II
│       ├── pool_hba.conf           # Autentikasi client Pgpool
│       └── pcp.conf                # PCP admin user
└── PWEB-B1/
    ├── Dockerfile                  # Build image Laravel (PHP 8.2 + Nginx)
    ├── .env                        # Konfigurasi environment lokal
    ├── .env.bdt                    # Konfigurasi environment Docker
    ├── docker/
    │   ├── nginx/default.conf      # Konfigurasi Nginx
    │   └── supervisor/supervisord.conf  # Process manager
    ├── config/database.php         # Konfigurasi koneksi database Laravel
    └── ...                         # (file aplikasi lainnya)
```

---

## Panduan Penggunaan

### Prasyarat

- Docker Engine 24+
- Docker Compose v2+
- Port 5436, 5433, 5434, 5435, 8080 tersedia di host

### Menjalankan Semua Service

```bash
# Build dan jalankan semua container
docker compose up -d

# Lihat status semua container
docker compose ps

# Lihat log semua service
docker compose logs -f
```

### Menjalankan Hanya Layer Database (untuk development)

```bash
docker compose up -d pg-master pg-replica1 pg-replica2 pgpool
```

### Menghentikan Semua Service

```bash
docker compose down
```

### Menghapus Semua Data (fresh start)

```bash
docker compose down -v
```

---

## Konfigurasi Utama

### 1. PostgreSQL Master — [`docker/pg-master/postgresql.conf`](docker/pg-master/postgresql.conf)

```ini
# Kunci: Replikasi Streaming
wal_level = replica             # Level WAL minimal untuk replikasi
max_wal_senders = 10            # Maksimum koneksi replikasi bersamaan
wal_keep_size = 512             # Retensi WAL (MB)

# Kunci: Logging untuk pembuktian
log_statement = 'all'           # Mencatat semua query SQL
log_line_prefix = '[%t] [%d] [%u] [%h] %p '  # Format log
```

### 2. PostgreSQL Master — [`docker/pg-master/init.sql`](docker/pg-master/init.sql)

```sql
-- User aplikasi
CREATE ROLE bdtuser WITH LOGIN PASSWORD 'bdtpassword';
GRANT ALL PRIVILEGES ON DATABASE bdt_app TO bdtuser;

-- User replikasi (digunakan replica dan Pgpool health check)
CREATE ROLE repluser WITH LOGIN REPLICATION PASSWORD 'replpassword';
```

### 3. PostgreSQL Replica — [`docker/pg-replica/entrypoint.sh`](docker/pg-replica/entrypoint.sh)

Script ini otomatis melakukan `pg_basebackup` dari master saat pertama kali dijalankan:

```bash
pg_basebackup \
    -h pg-master \
    -p 5432 \
    -U repluser \
    -D "$DATA_DIR" \
    -Fp -Xs -P -R
```

Flag `-R` otomatis membuat file `standby.signal` dan menulis `primary_conninfo` ke `postgresql.auto.conf`.

### 4. Pgpool-II — Konfigurasi via Environment Variables

Konfigurasi Pgpool-II diatur melalui environment variables di [`docker-compose.yml`](docker-compose.yml):

| Variable | Nilai | Fungsi |
|----------|-------|--------|
| `PGPOOL_PARAMS_LOAD_BALANCE_MODE` | `on` | Mengaktifkan distribusi query SELECT ke replica |
| `PGPOOL_PARAMS_MASTER_SLAVE_MODE` | `on` | Mengaktifkan read-write splitting |
| `PGPOOL_PARAMS_MASTER_SLAVE_SUB_MODE` | `stream` | Deteksi replikasi via streaming |
| `PGPOOL_PARAMS_BACKEND_WEIGHT0` | `0` | Master tidak menerima SELECT (WRITE only) |
| `PGPOOL_PARAMS_BACKEND_WEIGHT1` | `1` | Replica 1 menerima SELECT |
| `PGPOOL_PARAMS_BACKEND_WEIGHT2` | `1` | Replica 2 menerima SELECT |
| `PGPOOL_PARAMS_LOG_PER_NODE_STATEMENT` | `on` | Mencatat node mana yang memproses query |

### 5. Koneksi Aplikasi — [`PWEB-B1/.env`](PWEB-B1/.env)

```env
DB_CONNECTION=pgsql
DB_HOST=pgpool           # ← Aplikasi KONEK ke PGPool, BUKAN langsung ke Master
DB_PORT=5432
DB_DATABASE=bdt_app
DB_USERNAME=bdtuser
DB_PASSWORD=bdtpassword
```

---

## Pengujian

### Pengujian Read-Write Splitting

#### a. Query WRITE (INSERT/UPDATE/DELETE) → Master

```bash
# Akses PostgreSQL Master langsung
docker exec -it pg-master psql -U bdtuser -d bdt_app

# Jalankan query write
INSERT INTO admins (username, password, nama) VALUES ('test', 'hash', 'Test User');
UPDATE admins SET nama = 'Updated' WHERE username = 'test';
DELETE FROM admins WHERE username = 'test';
```

**Verifikasi**: Lihat log Master:
```bash
docker compose logs pg-master | grep -E "INSERT|UPDATE|DELETE"
```

#### b. Query READ (SELECT) → Replica

```bash
# Akses via Pgpool-II
docker exec -it pgpool psql -U bdtuser -d bdt_app -h localhost

# Jalankan query read
SELECT * FROM admins;
```

**Verifikasi**: Lihat log Replica:
```bash
docker compose logs pg-replica1 | grep "SELECT"
```

**Verifikasi Pgpool-II log** (menunjukkan node mana yang memproses):
```bash
docker compose logs pgpool | grep "DB node"
```

### Pengujian Fault Tolerance (Replica Down)

```bash
# 1. Cek status semua backend di Pgpool
docker exec -it pgpool pcp_node_info -h localhost -p 9898 -U admin

# 2. Matikan replica 1 secara sengaja
docker compose stop pg-replica1

# 3. Verifikasi Pgpool mendeteksi replica down
docker compose logs pgpool | grep "failover\|detach\|status"

# 4. Verifikasi aplikasi tetap berjalan
curl http://localhost:8080

# 5. Verifikasi query SELECT dialihkan ke replica 2
docker compose logs pgpool | grep "node 1"

# 6. Nyalakan kembali replica 1
docker compose start pg-replica1
```

---

## Monitoring & Troubleshooting

### Cek Status Backend Pgpool-II

```bash
# Show pool_nodes (status semua backend)
docker exec -it pgpool psql -U bdtuser -d bdt_app -h localhost -c "SHOW pool_nodes;"
```

Output yang diharapkan:
```
 node_id |   hostname   | port | status  | lb_weight |  role   | select_cnt | ...
---------+--------------+------+---------+-----------+---------+------------+----
 0       | pg-master    | 5432 | up      | 0         | primary | 0          |
 1       | pg-replica1  | 5432 | up      | 1         | standby | 15         |
 2       | pg-replica2  | 5432 | up      | 1         | standby | 12         |
```

### Cek Status Replikasi

```bash
# Di Master: lihat status WAL sender
docker exec -it pg-master psql -U postgres -c "SELECT * FROM pg_stat_replication;"

# Di Replica: lihat status WAL receiver
docker exec -it pg-replica1 psql -U postgres -c "SELECT * FROM pg_stat_wal_receiver;"
```

### Log Query per Node

```bash
# Log Pgpool-II (menunjukkan distribusi query ke backend mana)
docker compose logs pgpool -f

# Log Master (query write)
docker compose logs pg-master -f

# Log Replica (query read)
docker compose logs pg-replica1 -f
docker compose logs pg-replica2 -f
```

### Masalah Umum & Solusi

| Masalah | Penyebab | Solusi |
|---------|----------|--------|
| Replica gagal start | `pg_basebackup` gagal (master belum siap) | Restart replica: `docker compose restart pg-replica1` |
| Pgpool tidak bisa konek ke backend | Network isolation | Cek `docker compose exec pgpool ping pg-master` |
| "no pg_hba.conf entry" | Autentikasi ditolak | Periksa [`pg_hba.conf`](docker/pg-master/pg_hba.conf) — pastikan network range benar |
| SELECT tetap ke Master | `backend_weight0` bukan 0 | Pastikan `PGPOOL_PARAMS_BACKEND_WEIGHT0=0` |
| Replikasi lag | Beban write tinggi | Cek `wal_keep_size` di master, pastikan cukup besar |

---

## Referensi Konfigurasi Lengkap

- [`docker-compose.yml`](docker-compose.yml) — Orchestration dan environment variables
- [`docker/pg-master/postgresql.conf`](docker/pg-master/postgresql.conf) — Konfigurasi PostgreSQL Master
- [`docker/pg-master/pg_hba.conf`](docker/pg-master/pg_hba.conf) — Autentikasi host
- [`docker/pg-master/init.sql`](docker/pg-master/init.sql) — Inisialisasi user
- [`docker/pg-replica/postgresql.conf`](docker/pg-replica/postgresql.conf) — Konfigurasi Replica
- [`docker/pg-replica/entrypoint.sh`](docker/pg-replica/entrypoint.sh) — Script startup replica
- [`docker/pgpool/pgpool.conf`](docker/pgpool/pgpool.conf) — Konfigurasi referensi Pgpool (untuk laporan)
- [`PWEB-B1/.env`](PWEB-B1/.env) — Environment aplikasi
- [`PWEB-B1/config/database.php`](PWEB-B1/config/database.php) — Koneksi database Laravel
