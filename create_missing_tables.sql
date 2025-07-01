-- Script untuk membuat tabel yang diperlukan jika belum ada

-- Drop table jika sudah ada (untuk memastikan struktur yang benar)
DROP TABLE IF EXISTS `counseling_requests`;

-- Tabel counseling_requests dengan struktur yang benar
CREATE TABLE `counseling_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `type` enum('individu','kelompok','klasikal') NOT NULL DEFAULT 'individu',
  `theme` varchar(255) NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `status` enum('pending','approved','rejected','scheduled','completed') NOT NULL DEFAULT 'pending',
  `requested_at` timestamp NULL DEFAULT NULL,
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_student_id` (`student_id`),
  KEY `idx_status` (`status`),
  KEY `idx_type` (`type`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel appointments jika belum ada
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `counselor_id` int(11) NOT NULL,
  `requested_by` int(11) NOT NULL,
  `appointment_date` timestamp NOT NULL,
  `purpose` text DEFAULT NULL,
  `status` enum('pending','approved','rejected','completed','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_student_id` (`student_id`),
  KEY `idx_counselor_id` (`counselor_id`),
  KEY `idx_status` (`status`),
  KEY `idx_appointment_date` (`appointment_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel categories jika belum ada
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert beberapa kategori default
INSERT IGNORE INTO `categories` (`name`, `description`) VALUES
('Pribadi', 'Konseling masalah pribadi dan pengembangan diri'),
('Akademik', 'Konseling terkait masalah akademik dan pembelajaran'),
('Karir', 'Konseling bimbingan karir dan masa depan'),
('Sosial', 'Konseling masalah sosial dan hubungan interpersonal'),
('P5', 'Project Penguatan Profil Pelajar Pancasila'),
('Lainnya', 'Kategori konseling lainnya');

-- Insert beberapa data dummy untuk testing (opsional)
INSERT IGNORE INTO `counseling_requests` (`student_id`, `type`, `theme`, `description`, `status`, `requested_at`) VALUES
(1, 'individu', 'Karir', 'Butuh bimbingan untuk memilih jurusan kuliah', 'pending', NOW()),
(2, 'kelompok', 'Sosial', 'Masalah komunikasi dalam kelompok belajar', 'approved', NOW()),
(3, 'individu', 'Akademik', 'Kesulitan memahami mata pelajaran matematika', 'pending', NOW());
