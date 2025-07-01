-- Script untuk membuat/update tabel counseling_requests dengan fitur lengkap

-- Drop table jika ada (untuk reset)
DROP TABLE IF EXISTS `counseling_requests`;

-- Buat tabel counseling_requests dengan struktur lengkap
CREATE TABLE `counseling_requests` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `student_id` int(11) NOT NULL COMMENT 'ID murid yang mengajukan',
    `type` enum('individu','kelompok','klasikal') NOT NULL COMMENT 'Jenis konseling',
    `theme` varchar(255) NOT NULL COMMENT 'Tema/topik konseling',
    `group_name` varchar(255) DEFAULT NULL COMMENT 'Nama kelompok jika jenis kelompok/klasikal',
    `description` text NOT NULL COMMENT 'Deskripsi permintaan konseling',
    `status` enum('pending','approved','rejected','completed') NOT NULL DEFAULT 'pending' COMMENT 'Status permintaan',
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

-- Insert data dummy untuk testing
INSERT INTO `counseling_requests` (`student_id`, `type`, `theme`, `group_name`, `description`, `status`, `counselor_id`, `counseling_date`, `response_message`, `rejected_reason`) VALUES
-- Permintaan pending (belum diproses)
(1, 'individu', 'Masalah Akademik', NULL, 'Saya mengalami kesulitan dalam mengikuti pelajaran matematika. Nilai saya terus menurun dan saya merasa tidak percaya diri.', 'pending', NULL, NULL, NULL, NULL),
(2, 'kelompok', 'Konflik Teman Sebaya', 'Kelompok Resolusi', 'Ada masalah komunikasi dalam kelompok belajar kami. Beberapa anggota sering bertengkar dan tidak bisa bekerja sama.', 'pending', NULL, NULL, NULL, NULL),
(3, 'klasikal', 'Persiapan Ujian', 'Kelas 12 IPA 1', 'Kami membutuhkan bimbingan untuk persiapan ujian nasional dan manajemen stress menghadapi ujian.', 'pending', NULL, NULL, NULL, NULL),

-- Permintaan yang sudah disetujui
(4, 'individu', 'Masalah Keluarga', NULL, 'Saya sedang mengalami masalah di rumah yang mempengaruhi konsentrasi belajar saya di sekolah.', 'approved', 2, '2025-07-05 10:00:00', 'Baik, kita akan membahas masalah keluarga yang kamu alami. Silakan datang tepat waktu dan bawa catatan jika perlu.', NULL),
(5, 'kelompok', 'Bullying', 'Kelompok Anti-Bullying', 'Beberapa siswa di kelas kami mengalami bullying dan kami ingin mengatasi masalah ini bersama-sama.', 'approved', 2, '2025-07-06 14:00:00', 'Terima kasih telah melaporkan. Kita akan adakan sesi konseling kelompok untuk membahas pencegahan bullying.', NULL),

-- Permintaan yang ditolak
(6, 'individu', 'Minta Izin Bolos', NULL, 'Saya ingin minta izin untuk tidak masuk sekolah minggu depan karena ada acara keluarga.', 'rejected', 2, NULL, NULL, 'Permintaan ini bukan untuk konseling. Untuk izin tidak masuk sekolah, silakan hubungi wali kelas atau bagian administrasi.'),

-- Permintaan yang sudah selesai
(7, 'individu', 'Pilihan Karir', NULL, 'Saya bingung memilih jurusan untuk melanjutkan ke perguruan tinggi. Mohon bimbingan untuk menentukan pilihan yang tepat.', 'completed', 2, '2025-07-03 09:00:00', 'Kita akan eksplorasi minat dan bakat kamu untuk menentukan jurusan yang sesuai. Bawa hasil tes minat bakat jika ada.', NULL);

-- Pastikan ada foreign key constraints (opsional, tergantung struktur database)
-- ALTER TABLE `counseling_requests` ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `users`(`id`) ON DELETE CASCADE;
-- ALTER TABLE `counseling_requests` ADD CONSTRAINT `fk_counselor` FOREIGN KEY (`counselor_id`) REFERENCES `users`(`id`) ON DELETE SET NULL;

-- Tampilkan hasil
SELECT 'Counseling Requests Table Created Successfully!' as status;
SELECT COUNT(*) as total_requests FROM counseling_requests;
SELECT status, COUNT(*) as count FROM counseling_requests GROUP BY status;
