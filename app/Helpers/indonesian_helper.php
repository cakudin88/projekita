<?php

if (!function_exists('lang_id')) {
    /**
     * Helper function to get Indonesian language strings
     * 
     * @param string $key
     * @param array $data
     * @return string
     */
    function lang_id(string $key, array $data = []): string
    {
        return lang('App.' . $key, $data, 'id');
    }
}

if (!function_exists('validation_id')) {
    /**
     * Helper function to get Indonesian validation strings
     * 
     * @param string $key
     * @param array $data
     * @return string
     */
    function validation_id(string $key, array $data = []): string
    {
        return lang('Validation.' . $key, $data, 'id');
    }
}

if (!function_exists('format_date_id')) {
    /**
     * Format date to Indonesian format
     * 
     * @param string $date
     * @param string $format
     * @return string
     */
    function format_date_id(string $date, string $format = 'd F Y'): string
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $days = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        
        $timestamp = strtotime($date);
        $formatted = date($format, $timestamp);
        
        // Replace month names
        foreach ($months as $num => $name) {
            $formatted = str_replace(date('F', mktime(0, 0, 0, $num, 1)), $name, $formatted);
        }
        
        // Replace day names
        foreach ($days as $eng => $id) {
            $formatted = str_replace($eng, $id, $formatted);
        }
        
        return $formatted;
    }
}

if (!function_exists('currency_id')) {
    /**
     * Format currency to Indonesian Rupiah
     * 
     * @param float $amount
     * @return string
     */
    function currency_id(float $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('role_name_id')) {
    /**
     * Get Indonesian role names
     * 
     * @param string $role
     * @return string
     */
    function role_name_id(string $role): string
    {
        $roles = [
            'super_admin' => 'Super Admin',
            'kepala_sekolah' => 'Kepala Sekolah',
            'guru_bk' => 'Guru BK',
            'guru_mapel' => 'Guru Mata Pelajaran',
            'wali_kelas' => 'Wali Kelas',
            'wali_murid' => 'Wali Murid',
            'murid' => 'Murid'
        ];
        
        return $roles[$role] ?? $role;
    }
}

if (!function_exists('status_id')) {
    /**
     * Get Indonesian status names
     * 
     * @param string $status
     * @return string
     */
    function status_id(string $status): string
    {
        $statuses = [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'draft' => 'Draft',
            'published' => 'Dipublikasi'
        ];
        
        return $statuses[$status] ?? $status;
    }
}

if (!function_exists('indonesian_date')) {
    /**
     * Get current date in Indonesian format
     * 
     * @param string $format
     * @param string|null $date
     * @return string
     */
    function indonesian_date(string $format = 'l, d F Y', $date = null): string
    {
        if ($date === null) {
            $date = date('Y-m-d H:i:s');
        }
        
        return format_date_id($date, $format);
    }
}

if (!function_exists('safe_indonesian_date')) {
    /**
     * Safe Indonesian date function with fallback
     * 
     * @param string $format
     * @param string|null $date
     * @return string
     */
    function safe_indonesian_date(string $format = 'l, d F Y', $date = null): string
    {
        try {
            if (function_exists('indonesian_date')) {
                return indonesian_date($format, $date);
            } elseif (function_exists('format_date_id')) {
                if ($date === null) {
                    $date = date('Y-m-d H:i:s');
                }
                return format_date_id($date, $format);
            } else {
                // Simple fallback
                return date($format, $date ? strtotime($date) : time());
            }
        } catch (\Exception $e) {
            // Ultimate fallback
            return date('d F Y');
        }
    }
}

if (!function_exists('safe_format_number')) {
    /**
     * Safe number formatting with fallback
     * 
     * @param mixed $number
     * @return string|int
     */
    function safe_format_number($number)
    {
        try {
            if (function_exists('format_number_short')) {
                return format_number_short($number);
            } else {
                return is_numeric($number) ? (int)$number : 0;
            }
        } catch (\Exception $e) {
            return is_numeric($number) ? (int)$number : 0;
        }
    }
}
