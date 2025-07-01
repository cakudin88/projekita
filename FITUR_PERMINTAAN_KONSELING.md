# 🎯 Sistem Permintaan Konseling Role-Based

## ✨ Fitur yang Diimplementasikan

### 🧑‍🎓 **Untuk Role MURID:**
- ✅ **Ajukan Permintaan Konseling**
  - Form lengkap dengan jenis konseling (individu, kelompok, klasikal)
  - Input tema/topik, nama kelompok (opsional), dan deskripsi
  - Validasi input dengan pesan error dalam Bahasa Indonesia
  
- ✅ **Lihat Status Permintaan**
  - Daftar semua permintaan yang pernah diajukan
  - Modal detail untuk melihat informasi lengkap
  - Status real-time: Menunggu, Disetujui, Ditolak, Selesai
  - Lihat jadwal konseling jika sudah disetujui
  - Lihat pesan dari Guru BK atau alasan penolakan

### 👨‍🏫 **Untuk Role GURU BK:**
- ✅ **Kelola Semua Permintaan**
  - Dashboard lengkap semua permintaan dari seluruh siswa
  - Filter berdasarkan status
  - Informasi detail siswa yang mengajukan

- ✅ **Approve Permintaan**
  - Set tanggal dan waktu konseling
  - Tambahkan pesan/catatan untuk siswa
  - Otomatis update status dan notifikasi

- ✅ **Reject Permintaan**
  - Berikan alasan penolakan yang jelas
  - Pesan akan dilihat oleh siswa
  - Dokumentasi untuk transparansi

### 🔐 **Role-Based Access Control:**
- **Murid**: Hanya bisa melihat dan mengelola permintaan sendiri
- **Guru BK**: Bisa melihat dan mengelola semua permintaan
- **Super Admin**: Akses penuh untuk monitoring
- **Role Lain**: Tidak memiliki akses ke sistem ini

---

## 🗂️ Struktur Database

### Tabel `counseling_requests`:
```sql
- id (Primary Key)
- student_id (Foreign Key ke users)
- type (individu/kelompok/klasikal)
- theme (tema/topik konseling)
- group_name (nama kelompok, opsional)
- description (deskripsi lengkap)
- status (pending/approved/rejected/completed)
- counselor_id (Foreign Key ke users - guru BK)
- counseling_date (tanggal & waktu konseling)
- response_message (pesan dari guru BK)
- rejected_reason (alasan penolakan)
- created_at, updated_at (timestamp)
```

---

## 🚀 Cara Penggunaan

### **Untuk Murid:**
1. Login dengan role 'murid'
2. Akses menu "Permintaan Konseling"
3. Klik "Ajukan Permintaan Baru"
4. Isi form dengan lengkap
5. Submit dan tunggu persetujuan dari Guru BK
6. Cek status secara berkala

### **Untuk Guru BK:**
1. Login dengan role 'guru_bk'
2. Akses menu "Permintaan Konseling"
3. Lihat semua permintaan masuk
4. Untuk permintaan "Menunggu":
   - Klik tombol "Kelola"
   - Pilih **Setujui**: Set tanggal/waktu + pesan
   - Pilih **Tolak**: Berikan alasan jelas
5. Untuk permintaan yang sudah diproses: Klik "Lihat Detail"

---

## 📁 File yang Dimodifikasi/Dibuat

### **Controllers:**
- `app/Controllers/CounselingRequestController.php` - Controller utama dengan role-based logic

### **Models:**
- `app/Models/CounselingRequestModel.php` - Model dengan method lengkap untuk CRUD

### **Views:**
- `app/Views/counseling_requests/index.php` - Daftar permintaan (role-based)
- `app/Views/counseling_requests/create.php` - Form ajukan permintaan (murid)
- `app/Views/counseling_requests/manage.php` - Form approve/reject (guru BK)

### **Database:**
- `create_counseling_requests_table.sql` - Script SQL dengan data dummy

### **Routes:**
- Route group `counseling-requests/*` dengan proteksi role

---

## 🎨 Fitur UI/UX

### **Modern Design:**
- ✅ Responsive design untuk semua device
- ✅ Bootstrap 5 dengan custom CSS
- ✅ Icons FontAwesome untuk visual appeal
- ✅ Color-coded status badges
- ✅ Modal untuk detail view
- ✅ Alert messages dengan auto-dismiss

### **User Experience:**
- ✅ Breadcrumb navigation
- ✅ Form validation dengan pesan Indonesia
- ✅ Loading states dan feedback
- ✅ Consistent layout dengan sidebar menu
- ✅ Intuitive button placements

---

## 🔧 Pengaturan dan Maintenance

### **Permission Setup:**
Pastikan role di database sesuai:
- `murid` - untuk siswa
- `guru_bk` - untuk guru BK
- `super_admin` - untuk admin

### **Database Maintenance:**
```sql
-- Cleanup old completed requests (opsional)
DELETE FROM counseling_requests 
WHERE status = 'completed' 
AND created_at < DATE_SUB(NOW(), INTERVAL 6 MONTH);

-- Check statistics
SELECT status, COUNT(*) as total 
FROM counseling_requests 
GROUP BY status;
```

---

## 🚨 Troubleshooting

### **Jika "Role tidak memiliki akses":**
1. Cek session role_name di database
2. Pastikan user login dengan role yang benar
3. Cek tabel `roles` dan `users.role_id`

### **Jika error "Table doesn't exist":**
1. Jalankan: `mysql -u root -p appbke < create_counseling_requests_table.sql`
2. Atau akses `/debug/dashboard` untuk auto-fix

### **Jika form tidak submit:**
1. Cek CSRF token di form
2. Cek validation rules di controller
3. Cek network tab di browser untuk error detail

---

## 📈 Status Implementation

- ✅ **Role-based Access Control** - Complete
- ✅ **Murid: Ajukan Permintaan** - Complete  
- ✅ **Guru BK: Approve/Reject** - Complete
- ✅ **Database Schema** - Complete
- ✅ **UI/UX Modern** - Complete
- ✅ **Form Validation** - Complete
- ✅ **Status Tracking** - Complete
- ✅ **Documentation** - Complete

**🎉 SISTEM SIAP DIGUNAKAN!**

Akses: `http://localhost:8080/counseling-requests`
