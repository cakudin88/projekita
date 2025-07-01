# 🚨 PERBAIKAN ERROR DATABASE - Counseling Requests

## ❌ ERROR YANG TERJADI:
```
CodeIgniter\Database\Exceptions\DatabaseException #1054
Unknown column 'created_at' in 'order clause'
```

## 🔍 PENYEBAB:
Tabel `counseling_requests` belum ada atau tidak memiliki kolom `created_at` yang diperlukan oleh aplikasi.

## ✅ SOLUSI LANGKAH DEMI LANGKAH:

### **1. IMPORT DATABASE TABLES (WAJIB!)**

#### A. Buka phpMyAdmin:
- URL: http://localhost/phpmyadmin
- Login dengan user/password MySQL Anda

#### B. Pilih Database:
- Pilih database yang digunakan aplikasi (misal: `school_management`, `appbke`, dll)

#### C. Jalankan Script SQL:
1. Klik tab **"SQL"** di bagian atas
2. Copy-paste script berikut:

```sql
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

-- Insert beberapa data dummy untuk testing
INSERT INTO `counseling_requests` (`student_id`, `type`, `theme`, `description`, `status`, `requested_at`) VALUES
(1, 'individu', 'Karir', 'Butuh bimbingan untuk memilih jurusan kuliah', 'pending', NOW()),
(2, 'kelompok', 'Sosial', 'Masalah komunikasi dalam kelompok belajar', 'approved', NOW()),
(3, 'individu', 'Akademik', 'Kesulitan memahami mata pelajaran matematika', 'pending', NOW());
```

3. Klik tombol **"Go"** untuk menjalankan

### **2. VERIFIKASI BERHASIL**
Setelah script dijalankan, Anda harus melihat:
- ✅ Tabel `counseling_requests` berhasil dibuat
- ✅ Tabel memiliki 13 kolom termasuk `created_at`
- ✅ 3 data dummy berhasil diinsert

### **3. TEST APLIKASI**
1. **Refresh browser** atau akses kembali:
   - http://localhost:8080/counseling-requests

2. **Hasil yang diharapkan**:
   - ✅ Halaman terbuka tanpa error
   - ✅ Menampilkan 3 data dummy
   - ✅ Menu sidebar konsisten
   - ✅ Tombol "Ajukan Permintaan" berfungsi

## 🎯 FILE YANG SUDAH DIPERBAIKI:

### **1. Controller Enhanced:**
- ✅ `app/Controllers/CounselingRequestController.php`
- ✅ Added better error handling
- ✅ Added table existence check
- ✅ Added fallback for missing columns

### **2. SQL Script Updated:**
- ✅ `create_missing_tables.sql`
- ✅ DROP TABLE IF EXISTS untuk clean install
- ✅ Proper column definitions
- ✅ Sample data untuk testing

### **3. Emergency View:**
- ✅ `app/Views/counseling_requests/emergency.php`
- ✅ User-friendly error explanation
- ✅ Step-by-step repair instructions

## 🔧 TROUBLESHOOTING:

### Jika masih error setelah import:
1. **Check tabel ada**: Di phpMyAdmin, pastikan tabel `counseling_requests` ada
2. **Check kolom**: Pastikan kolom `created_at` ada di tabel
3. **Clear cache**: Restart server CodeIgniter
4. **Check database config**: Pastikan `.env` mengarah ke database yang benar

### Jika tidak bisa akses phpMyAdmin:
1. **Start XAMPP**: Pastikan Apache dan MySQL running
2. **Check port**: Default MySQL port 3306
3. **Alternative**: Gunakan MySQL command line atau tool database lain

## 📋 NEXT STEPS SETELAH PERBAIKAN:

1. ✅ **Test Menu Navigation**: Semua menu BK harus konsisten
2. ✅ **Test Form Submission**: Coba ajukan permintaan konseling baru  
3. ✅ **Test Approval Process**: Login sebagai guru BK dan approve request
4. ✅ **Check Data Integration**: Pastikan data terintegrasi dengan baik

**STATUS: SIAP DIPERBAIKI** ⚡  
Ikuti langkah di atas dan error akan teratasi!
