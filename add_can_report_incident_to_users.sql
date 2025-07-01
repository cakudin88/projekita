-- Tambah kolom untuk flag murid yang bisa melapor kejadian
ALTER TABLE users ADD COLUMN can_report_incident TINYINT(1) NOT NULL DEFAULT 0;
