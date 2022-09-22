-- Add landing_page column to users table

ALTER TABLE users ADD COLUMN landing_page VARCHAR(64) AFTER remember_token;

-- Add login_attempts column to users table

ALTER TABLE users ADD COLUMN login_attempts TINYINT DEFAULT 0 AFTER remember_token;

-- Add event column to activity_log table

ALTER TABLE activity_log ADD COLUMN event VARCHAR(255) AFTER subject_type;

-- Add batch_uuid column to activity_log table

ALTER TABLE activity_log ADD COLUMN batch_uuid BINARY(16) AFTER properties;

-- Add type column to menu table

ALTER TABLE menu ADD COLUMN type VARCHAR(100) NOT NULL DEFAULT 'ALL' AFTER parent_id;