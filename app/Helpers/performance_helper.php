<?php

if (!function_exists('optimize_view_data')) {
    /**
     * Optimize data for views by removing unnecessary data and formatting efficiently
     */
    function optimize_view_data($data) {
        // Remove any large unnecessary data
        if (isset($data['user']) && is_object($data['user'])) {
            // Only keep essential user data
            $data['user'] = [
                'id' => $data['user']->id ?? null,
                'username' => $data['user']->username ?? null,
                'full_name' => $data['user']->full_name ?? null,
                'role_id' => $data['user']->role_id ?? null
            ];
        }
        
        return $data;
    }
}

if (!function_exists('format_number_short')) {
    /**
     * Format numbers for display (e.g., 1000 -> 1K)
     */
    function format_number_short($number) {
        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }
        return $number;
    }
}

if (!function_exists('get_performance_info')) {
    /**
     * Get basic performance information
     */
    function get_performance_info() {
        return [
            'memory_usage' => round(memory_get_usage() / 1024 / 1024, 2) . ' MB',
            'peak_memory' => round(memory_get_peak_usage() / 1024 / 1024, 2) . ' MB',
            'execution_time' => round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 3) . 's'
        ];
    }
}

if (!function_exists('cache_key_user')) {
    /**
     * Generate cache key for user-specific data
     */
    function cache_key_user($key) {
        $userId = session()->get('user_id') ?? 'guest';
        return $key . '_' . $userId;
    }
}
