# Script untuk menjalankan semua seeder users
# File: run_all_seeders.ps1

Write-Host "=== Menjalankan All Users Seeder ===" -ForegroundColor Green
Write-Host ""

# Pindah ke direktori aplikasi
Set-Location "c:\xampp\htdocs\appbke"

# Jalankan seeder satu per satu
Write-Host "1. Menjalankan GuruMapelSeeder..." -ForegroundColor Yellow
php spark db:seed GuruMapelSeeder

Write-Host ""
Write-Host "2. Menjalankan WalasSeeder..." -ForegroundColor Yellow
php spark db:seed WalasSeeder

Write-Host ""
Write-Host "3. Menjalankan KepalaSekolahSeeder..." -ForegroundColor Yellow
php spark db:seed KepalaSekolahSeeder

Write-Host ""
Write-Host "4. Menjalankan OrangTuaSeeder..." -ForegroundColor Yellow
php spark db:seed OrangTuaSeeder

Write-Host ""
Write-Host "=== Seeder selesai dijalankan ===" -ForegroundColor Green
Write-Host ""

Write-Host "Kredensial login untuk testing:" -ForegroundColor Cyan
Write-Host "- Guru Mapel: gurumapel1 / mapel123" -ForegroundColor White
Write-Host "- Wali Kelas: walas1 / walas123" -ForegroundColor White
Write-Host "- Kepala Sekolah: kepsek / kepsek123" -ForegroundColor White
Write-Host "- Orang Tua: orangtua1 / ortu123" -ForegroundColor White
Write-Host ""

# Tampilkan jumlah total user
Write-Host "Mengecek total users di database..." -ForegroundColor Yellow
php spark db:query "SELECT r.name as role, COUNT(*) as jumlah FROM users u JOIN roles r ON r.id = u.role_id GROUP BY r.name ORDER BY r.name"

Write-Host ""
Write-Host "Seeder berhasil dijalankan! Aplikasi siap digunakan." -ForegroundColor Green
