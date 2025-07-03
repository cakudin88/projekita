-- Script untuk memperbaiki tabel roles yang kosong
-- Jalankan script ini jika tabel roles kosong

-- Cek apakah tabel roles ada
CREATE TABLE IF NOT EXISTS `roles` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `description` text,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Hapus data lama jika ada (untuk reset)
DELETE FROM roles;

-- Insert default roles
INSERT INTO `roles` (`name`, `description`) VALUES
('super_admin', 'Super Administrator'),
('kepala_sekolah', 'Kepala Sekolah'), 
('guru_bk', 'Guru Bimbingan Konseling'),
('guru_mapel', 'Guru Mata Pelajaran'),
('guru', 'Guru Umum'),
('murid', 'Murid/Siswa'),
('staff', 'Staff Sekolah'),
('orang_tua', 'Orang Tua Murid');

-- Cek hasil
SELECT * FROM roles;

-- Cek jumlah total
SELECT COUNT(*) as total_roles FROM roles;
