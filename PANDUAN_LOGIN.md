# PANDUAN AKSES HALAMAN ROLE MANAGEMENT

## Masalah: Error 404 pada /admin/roles

Halaman `/admin/roles` menampilkan error 404 dengan pesan "Can't find a route for 'get_admin/roles'" karena **belum login sebagai super admin**.

## Solusi: Login sebagai Super Admin

### Langkah 1: Akses Halaman Login
Buka browser dan akses: http://localhost:8080/login

### Langkah 2: Login dengan Kredensial Admin
Gunakan kredensial admin default yang telah dibuat seeder:
- **Username**: admin
- **Password**: admin123

### Langkah 3: Verifikasi Login Berhasil
Setelah login, Anda akan diarahkan ke dashboard. Pastikan:
- Sidebar menampilkan menu "Admin"
- Role ditampilkan sebagai "Super Admin"
- Dapat mengakses menu admin

### Langkah 4: Akses Halaman Role Management
Klik menu "Admin" → "Kelola Role" atau akses langsung: http://localhost:8080/admin/roles

## Kredensial Login Default

Data admin yang dibuat oleh seeder:
```
Username: admin
Email: admin@school.com
Password: admin123
Role: super_admin
```

## Cara Cek Status Login

Akses http://localhost:8080/test untuk melihat status session dan login.

## Catatan Penting

1. **Hanya super_admin** yang dapat mengakses halaman `/admin/roles`
2. **Session** harus aktif untuk mengakses area admin
3. **Filter auth dan admin** melindungi semua route admin
4. Jika masih error, restart server atau clear browser cache

## Troubleshooting

### Jika masih error 404:
1. Pastikan server berjalan di http://localhost:8080
2. Clear browser cache dan cookies
3. Coba login ulang
4. Pastikan database ter-update dengan data seeder

### Jika tidak bisa login:
1. Cek apakah database `appbku_school` tersedia
2. Pastikan tabel `users` dan `roles` berisi data
3. Jalankan seeder ulang jika diperlukan

## Menjalankan Seeder Ulang (jika diperlukan)

```bash
cd c:\xampp\htdocs\appbku
php spark db:seed RoleSeeder
php spark db:seed AdminSeeder
```

## Status Aplikasi

✅ Database: Configured (appbku_school)
✅ Tables: Created (users, roles, students, teachers)
✅ Seeder: Executed (admin user & roles created)
✅ Controllers: Complete (Auth, Dashboard, Admin/User, Admin/Role)
✅ Views: Complete (layouts, auth, dashboard, admin)
✅ Routes: Configured (auth, dashboard, admin)
✅ Filters: Active (auth, admin)
✅ Models: Complete (UserModel, RoleModel)

**SOLUSI UTAMA**: Login dengan username "admin" dan password "admin123" di http://localhost:8080/login
