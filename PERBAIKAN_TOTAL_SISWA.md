# 🔧 PERBAIKAN TOTAL SISWA MENAMPILKAN 0

## ❌ MASALAH:
Card "Total Siswa" di dashboard menampilkan 0 padahal seharusnya ada data siswa.

## ✅ PERBAIKAN YANG DILAKUKAN:

### 1. **Fixed Query Role Name**
**Masalah:** Query mencari role `'siswa'` tapi seharusnya `'murid'`
**Perbaikan:** Updated query di `DashboardController.php`:

```php
// SEBELUM (SALAH):
WHERE r.name = 'siswa'

// SESUDAH (BENAR):
WHERE r.name = 'murid'
```

### 2. **Added Guru Role Variants**
Juga menambahkan variant nama role guru:
```php
WHERE r.name IN ('guru_bk', 'guru_mapel', 'guru')
```

### 3. **Added Cache Clear Function**
- ✅ Method `clearCache()` di DashboardController
- ✅ Route `/dashboard/clear-cache` untuk refresh data

### 4. **Added Debug Tools**
- ✅ `DebugController::checkStudentData()`
- ✅ Route `/debug/students` untuk troubleshooting

## 🚀 LANGKAH TESTING:

### **1. Clear Cache Dashboard**
Akses: http://localhost:8080/dashboard/clear-cache

### **2. Debug Data Siswa (opsional)**
Akses: http://localhost:8080/debug/students
- Akan menampilkan semua roles di database
- Menampilkan users dengan role 'murid'
- Menampilkan count total siswa

### **3. Refresh Dashboard**
Akses: http://localhost:8080/dashboard
- Card "Total Siswa" seharusnya sudah menampilkan angka yang benar

## 📋 KEMUNGKINAN SKENARIO:

### **Skenario A: Data Sudah Fix**
- ✅ Total Siswa menampilkan angka > 0
- ✅ Dashboard berfungsi normal

### **Skenario B: Masih 0 - Tidak Ada Role 'murid'**
Jika masih 0, kemungkinan:
1. **Role name berbeda** (misal: 'student', 'pelajar', dll)
2. **Tidak ada users dengan role murid**
3. **Role table kosong**

**Solusi:** Gunakan debug tool untuk mengecek nama role yang benar

### **Skenario C: Masih 0 - Database Issue**
Kemungkinan masalah database:
1. **Tabel users kosong**
2. **Tabel roles kosong** 
3. **Foreign key tidak matching**

## 🔍 DEBUG STEPS JIKA MASIH BERMASALAH:

### **1. Check Roles**
```sql
SELECT * FROM roles;
```
Pastikan ada role untuk siswa (murid/student/pelajar)

### **2. Check Users**
```sql
SELECT u.*, r.name as role_name 
FROM users u 
INNER JOIN roles r ON r.id = u.role_id;
```

### **3. Manual Count**
```sql
SELECT COUNT(*) FROM users u 
INNER JOIN roles r ON r.id = u.role_id 
WHERE r.name = 'murid';
```

## 📁 FILE YANG DIMODIFIKASI:
- ✅ `app/Controllers/DashboardController.php` - Fixed query role name
- ✅ `app/Controllers/DebugController.php` - Added debug method
- ✅ `app/Config/Routes.php` - Added routes untuk cache clear & debug

## 🎯 HASIL YANG DIHARAPKAN:
- ✅ Card "Total Siswa" menampilkan jumlah yang benar
- ✅ Card "Total Guru" menampilkan jumlah yang benar  
- ✅ Dashboard data akurat dan up-to-date

**NEXT STEP:** Clear cache dashboard dan refresh halaman!
