<?php

/**
 * Indonesian Language Constants
 * Common texts used throughout the application
 */

// Define Indonesian language constants
if (!defined('LANG_ID')) {
    define('LANG_ID', [
        // Navigation & Menu
        'HOME' => 'Beranda',
        'DASHBOARD' => 'Dashboard',
        'ADMIN' => 'Admin',
        'USERS' => 'Pengguna',
        'STUDENTS' => 'Siswa',
        'TEACHERS' => 'Guru',
        'COUNSELING' => 'Bimbingan Konseling',
        'REPORTS' => 'Laporan',
        'SETTINGS' => 'Pengaturan',
        'PROFILE' => 'Profil',
        
        // Actions
        'ADD' => 'Tambah',
        'EDIT' => 'Edit',
        'DELETE' => 'Hapus',
        'SAVE' => 'Simpan',
        'CANCEL' => 'Batal',
        'SEARCH' => 'Cari',
        'FILTER' => 'Filter',
        'EXPORT' => 'Ekspor',
        'IMPORT' => 'Impor',
        'PRINT' => 'Cetak',
        'VIEW' => 'Lihat',
        'DETAILS' => 'Detail',
        
        // Status
        'ACTIVE' => 'Aktif',
        'INACTIVE' => 'Tidak Aktif',
        'PENDING' => 'Menunggu',
        'APPROVED' => 'Disetujui',
        'COMPLETED' => 'Selesai',
        'CANCELLED' => 'Dibatalkan',
        
        // Form Fields
        'NAME' => 'Nama',
        'EMAIL' => 'Email',
        'USERNAME' => 'Nama Pengguna',
        'PASSWORD' => 'Kata Sandi',
        'CONFIRM_PASSWORD' => 'Konfirmasi Kata Sandi',
        'PHONE' => 'Telepon',
        'ADDRESS' => 'Alamat',
        'DATE' => 'Tanggal',
        'TIME' => 'Waktu',
        'DESCRIPTION' => 'Deskripsi',
        'NOTES' => 'Catatan',
        
        // Messages
        'SUCCESS' => 'Berhasil',
        'ERROR' => 'Error',
        'WARNING' => 'Peringatan',
        'INFO' => 'Informasi',
        'LOADING' => 'Memuat...',
        'NO_DATA' => 'Tidak ada data',
        'DATA_SAVED' => 'Data berhasil disimpan',
        'DATA_UPDATED' => 'Data berhasil diperbarui',
        'DATA_DELETED' => 'Data berhasil dihapus',
        
        // Roles
        'SUPER_ADMIN' => 'Super Admin',
        'KEPALA_SEKOLAH' => 'Kepala Sekolah',
        'GURU_BK' => 'Guru BK',
        'GURU_MAPEL' => 'Guru Mata Pelajaran',
        'WALI_KELAS' => 'Wali Kelas',
        'WALI_MURID' => 'Wali Murid',
        'MURID' => 'Murid',
        
        // Academic
        'CLASS' => 'Kelas',
        'GRADE' => 'Tingkat',
        'SUBJECT' => 'Mata Pelajaran',
        'SCHEDULE' => 'Jadwal',
        'ATTENDANCE' => 'Absensi',
        'GRADES' => 'Nilai',
        'EXAM' => 'Ujian',
        'ACADEMIC_YEAR' => 'Tahun Ajaran',
        'SEMESTER' => 'Semester',
        
        // Common Phrases
        'PLEASE_SELECT' => 'Silakan pilih',
        'ARE_YOU_SURE' => 'Apakah Anda yakin?',
        'CONFIRM_DELETE' => 'Apakah Anda yakin ingin menghapus data ini?',
        'OPERATION_SUCCESS' => 'Operasi berhasil dilakukan',
        'OPERATION_FAILED' => 'Operasi gagal dilakukan',
        'ACCESS_DENIED' => 'Akses ditolak',
        'PAGE_NOT_FOUND' => 'Halaman tidak ditemukan',
        'WELCOME_BACK' => 'Selamat datang kembali',
        'GOOD_MORNING' => 'Selamat pagi',
        'GOOD_AFTERNOON' => 'Selamat siang',
        'GOOD_EVENING' => 'Selamat sore',
        'GOOD_NIGHT' => 'Selamat malam',
        
        // Time & Date
        'TODAY' => 'Hari ini',
        'YESTERDAY' => 'Kemarin',
        'TOMORROW' => 'Besok',
        'THIS_WEEK' => 'Minggu ini',
        'THIS_MONTH' => 'Bulan ini',
        'THIS_YEAR' => 'Tahun ini',
        'LAST_WEEK' => 'Minggu lalu',
        'LAST_MONTH' => 'Bulan lalu',
        'LAST_YEAR' => 'Tahun lalu',
        
        // Days of Week
        'MONDAY' => 'Senin',
        'TUESDAY' => 'Selasa',
        'WEDNESDAY' => 'Rabu',
        'THURSDAY' => 'Kamis',
        'FRIDAY' => 'Jumat',
        'SATURDAY' => 'Sabtu',
        'SUNDAY' => 'Minggu',
        
        // Months
        'JANUARY' => 'Januari',
        'FEBRUARY' => 'Februari',
        'MARCH' => 'Maret',
        'APRIL' => 'April',
        'MAY' => 'Mei',
        'JUNE' => 'Juni',
        'JULY' => 'Juli',
        'AUGUST' => 'Agustus',
        'SEPTEMBER' => 'September',
        'OCTOBER' => 'Oktober',
        'NOVEMBER' => 'November',
        'DECEMBER' => 'Desember'
    ]);
}

// Helper function to get language constant
if (!function_exists('t')) {
    function t(string $key): string {
        return LANG_ID[$key] ?? $key;
    }
}
