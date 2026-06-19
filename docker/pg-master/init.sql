-- ============================================================================
-- Init SQL - PostgreSQL Master
-- Creates application user and replication user
-- ============================================================================

-- Create application user
CREATE ROLE bdtuser WITH LOGIN PASSWORD 'bdtpassword';
GRANT ALL PRIVILEGES ON DATABASE bdt_app TO bdtuser;
ALTER ROLE bdtuser CREATEDB;

-- Create replication user used by replicas and Pgpool-II health checks
CREATE ROLE repluser WITH LOGIN REPLICATION PASSWORD 'replpassword';

-- Grant basic read permissions to repluser for health checks
GRANT CONNECT ON DATABASE bdt_app TO repluser;
GRANT USAGE ON SCHEMA public TO repluser;
GRANT SELECT ON ALL TABLES IN SCHEMA public TO repluser;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT SELECT ON TABLES TO repluser;

-- Grant bdtuser full schema permissions
ALTER SCHEMA public OWNER TO bdtuser;
GRANT ALL ON SCHEMA public TO bdtuser;
