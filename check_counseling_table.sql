-- Script untuk memastikan tabel counseling_requests sudah ada dan benar
-- Jalankan script ini jika masih ada error terkait kolom user_id

-- Cek apakah tabel sudah ada
SELECT COUNT(*) as table_exists 
FROM information_schema.tables 
WHERE table_schema = DATABASE() 
AND table_name = 'counseling_requests';

-- Jika tabel belum ada, jalankan script di bawah ini:

CREATE TABLE IF NOT EXISTS `counseling_requests` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `student_id` int(11) NOT NULL COMMENT 'ID murid yang mengajukan (dari users.id)',
    `type` enum('individu','kelompok','klasikal') NOT NULL DEFAULT 'individu' COMMENT 'Jenis konseling',
    `theme` varchar(255) NOT NULL COMMENT 'Tema/topik konseling',
    `group_name` varchar(255) DEFAULT NULL COMMENT 'Nama kelompok jika jenis kelompok/klasikal',
    `description` text NOT NULL COMMENT 'Deskripsi permintaan konseling',
    `status` enum('pending','approved','rejected','scheduled','completed') NOT NULL DEFAULT 'pending' COMMENT 'Status permintaan',
    `counselor_id` int(11) DEFAULT NULL COMMENT 'ID guru BK yang menangani',
    `counseling_date` datetime DEFAULT NULL COMMENT 'Tanggal dan waktu konseling dijadwalkan',
    `response_message` text DEFAULT NULL COMMENT 'Pesan dari guru BK saat menyetujui',
    `rejected_reason` text DEFAULT NULL COMMENT 'Alasan penolakan dari guru BK',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_student_id` (`student_id`),
    KEY `idx_counselor_id` (`counselor_id`),
    KEY `idx_status` (`status`),
    KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert beberapa data dummy untuk testing dashboard murid
INSERT IGNORE INTO `counseling_requests` 
(`student_id`, `type`, `theme`, `description`, `status`, `created_at`) 
VALUES 
-- Ganti angka 5 dengan ID user yang memiliki role murid
(5, 'individu', 'Kesulitan Belajar', 'Saya mengalami kesulitan dalam mata pelajaran matematika', 'pending', NOW()),
(5, 'individu', 'Masalah Sosial', 'Ingin berkonsultasi tentang hubungan dengan teman', 'completed', DATE_SUB(NOW(), INTERVAL 1 WEEK));

-- Cek struktur tabel
DESCRIBE counseling_requests;

-- Cek data yang ada
SELECT * FROM counseling_requests LIMIT 5;
