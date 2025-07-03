# Testing Dashboard Role Murid

## Cara Test Dashboard Murid:

### 1. Login sebagai Murid
Gunakan salah satu akun murid yang ada:
- Email: `murid@test.com` atau sesuai seeder
- Password: `password123` atau sesuai seeder

### 2. Jika belum ada user murid, buat user baru:
```sql
-- Buat user murid untuk testing
INSERT INTO users (username, email, password, full_name, role_id, is_active, created_at, updated_at) 
VALUES 
('murid_test', 'murid_test@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Siswa Test', 
(SELECT id FROM roles WHERE name = 'murid'), 1, NOW(), NOW());
```

### 3. Error yang Sudah Diperbaiki:
- ✅ Error "Unknown column 'user_id'" sudah diperbaiki
- ✅ Query sekarang menggunakan `student_id` sebagaimana struktur tabel
- ✅ Added error handling untuk mencegah crash dashboard
- ✅ Fallback data jika query gagal

### 4. Fitur Dashboard Murid:
- **Stats Cards:**
  - Tingkat Kehadiran (96%)
  - Rata-rata Nilai (82.5)
  - Tugas Menunggu (3)
  - Prestasi (5)

- **Quick Actions:**
  - Ajukan Konseling
  - Status Konseling
  - Chat Guru BK
  - Lapor Kejadian

- **Content Sections:**
  - Jadwal Hari Ini
  - Tugas Mendatang
  - Nilai Terbaru
  - Status Konseling & Bimbingan
  - Ringkasan Aktivitas

### 5. URL untuk Testing:
- Login: `http://localhost/appbke/public/login`
- Dashboard: `http://localhost/appbke/public/dashboard`

### 6. Troubleshooting:
Jika masih error:
1. Pastikan tabel `counseling_requests` sudah ada
2. Jalankan script `check_counseling_table.sql`
3. Pastikan ada user dengan role 'murid'
4. Cek log error di `writable/logs/`

### 7. Database Columns Used:
- `counseling_requests.student_id` → untuk link ke users.id
- `counseling_requests.status` → untuk menampilkan status
- `counseling_requests.created_at` → untuk sorting terbaru

### 8. Session Variables Required:
- `user_id` → ID user yang login
- `role_name` → harus 'murid'
- `full_name` → untuk greeting
- `username` → untuk display
