# APLIKASI BIMBINGAN KONSELING SMP NEGERI 1 PASURUAN

## Overview
Aplikasi ini adalah modul bimbingan konseling yang terintegrasi dengan sistem manajemen sekolah SMP Negeri 1 Pasuruan. Aplikasi ini memungkinkan guru BK, kepala sekolah, dan administrator untuk mengelola sesi konseling, rekam jejak siswa, dan komunikasi dengan orang tua.

## Fitur Utama

### 1. Dashboard Bimbingan Konseling
- Statistik sesi konseling (total, hari ini, tertunda, mendesak)
- Sesi mendatang dan riwayat sesi terbaru
- Kategori konseling dengan kode warna
- Aksi cepat untuk berbagai kebutuhan

### 2. Manajemen Sesi Konseling
- Membuat sesi konseling baru
- Menjadwalkan pertemuan dengan siswa
- Mencatat hasil konseling dan tindak lanjut
- Menandai sesi yang mendesak
- Status sesi: terjadwal, berlangsung, selesai, dibatalkan

### 3. Kategori Konseling
- **Akademik**: Masalah prestasi dan motivasi belajar
- **Sosial**: Interaksi dengan teman dan lingkungan
- **Pribadi**: Masalah kepribadian dan emosi
- **Keluarga**: Hubungan dan kondisi keluarga
- **Karir**: Bimbingan pemilihan jurusan dan masa depan
- **Perilaku**: Kedisiplinan dan penyesuaian perilaku
- **Kesehatan Mental**: Kecemasan, stress, depresi
- **Bullying**: Kasus perundungan

### 4. Rekam Jejak Siswa
- Catatan perkembangan akademik
- Riwayat perilaku dan prestasi
- Dokumentasi masalah personal dan keluarga
- Rekam jejak yang bersifat rahasia

### 5. Komunikasi dengan Orang Tua
- Pesan dan notifikasi
- Penjadwalan pertemuan
- Laporan perkembangan siswa
- Komunikasi via telepon, email, atau tatap muka

## Role dan Akses

### Super Admin
- Akses penuh ke semua fitur
- Mengelola pengguna dan role
- Melihat semua laporan dan statistik

### Guru BK (Bimbingan Konseling)
- Membuat dan mengelola sesi konseling
- Mencatat hasil konseling
- Berkomunikasi dengan orang tua
- Membuat laporan konseling

### Kepala Sekolah
- Melihat laporan dan statistik
- Memantau sesi konseling
- Akses read-only ke data konseling

### Wali Kelas
- Melihat data siswa di kelasnya
- Merujuk siswa ke guru BK
- Melihat laporan siswa

### Murid
- Melihat jadwal konseling sendiri
- Mengajukan permohonan konseling
- Melihat catatan konseling (terbatas)

### Wali Murid
- Melihat laporan perkembangan anak
- Berkomunikasi dengan guru BK
- Menerima notifikasi dari sekolah

## Database Schema

### Tabel Utama:
1. **categories**: Kategori masalah konseling
2. **counseling_sessions**: Sesi konseling siswa
3. **student_records**: Rekam jejak siswa
4. **parent_communications**: Komunikasi dengan orang tua
5. **appointments**: Jadwal konseling

## Data Contoh
- 8 siswa dari kelas 7A, 7B, 7C, 8A, 8B, 9A, 9B
- 1 guru BK: Dr. Sari Indrawati, M.Pd
- 8 kategori konseling dengan kode warna
- Admin default: username `admin`, password `admin123`

## Cara Menggunakan

### 1. Login sebagai Admin
```
URL: http://localhost:8080/login
Username: admin
Password: admin123
```

### 2. Login sebagai Guru BK
```
Username: guru.bk
Password: gurubk123
```

### 3. Akses Dashboard BK
```
URL: http://localhost:8080/counseling
```

### 4. Menu Bimbingan Konseling
- **Dashboard BK**: Overview dan statistik
- **Sesi Konseling**: Daftar semua sesi
- **Sesi Baru**: Membuat sesi konseling baru
- **Rekam Jejak**: Catatan perkembangan siswa
- **Laporan BK**: Report dan analisis

## Status Implementasi

### ✅ Selesai:
- Database schema dan migration
- Model dan controller dasar (BKController)
- **Dashboard BK BERFUNGSI SEMPURNA dengan layout yang benar**
- Seeder data contoh (siswa, guru BK, kategori, sesi konseling)
- Menu navigasi dan UI terintegrasi dengan sidebar
- Role-based access control
- **Dashboard BK dalam panel aplikasi dengan statistik dan quick actions**
- **Model loading dan view rendering berhasil 100%**
- **Layout app.php dan view system bekerja sempurna**

### 🚧 Dalam Pengembangan:
- Form create sesi konseling
- CRUD sesi konseling lengkap
- Modul rekam jejak siswa
- Komunikasi dengan orang tua
- Laporan dan statistik lanjutan

### 📋 Rencana Selanjutnya:
- Upload dokumen pendukung
- Notifikasi real-time
- Export laporan ke PDF/Excel
- Dashboard analytics yang lebih detail
- Mobile responsive optimization

## Teknologi yang Digunakan
- **Backend**: CodeIgniter 4
- **Database**: MySQL
- **Frontend**: Bootstrap 5, FontAwesome
- **Charts**: Chart.js (planned)
- **Theme**: Modern Blue Responsive

## Instalasi dan Setup
1. Pastikan database `appbku_school` sudah dibuat
2. Jalankan migration: `php spark migrate`
3. Jalankan seeder: `php spark db:seed CategorySeeder`
4. Jalankan seeder: `php spark db:seed StudentSampleSeeder`
5. Jalankan seeder: `php spark db:seed GuruBKSeeder`
6. Jalankan seeder: `php spark db:seed CounselingSessionSeeder`
7. Akses aplikasi di `http://localhost:8080`

## Kontribusi
Aplikasi ini dikembangkan sebagai sistem terintegrasi untuk SMP Negeri 1 Pasuruan dengan fokus pada efektivitas bimbingan konseling dan komunikasi antara sekolah, siswa, dan orang tua.
