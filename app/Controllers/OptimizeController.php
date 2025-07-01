<?php

namespace App\Controllers;

use App\Controllers\BaseController;

/**
 * Performance Optimization Controller
 */
class OptimizeController extends BaseController
{
    /**
     * Clear all caches and optimize the application
     */
    public function index()
    {
        // Clear all caches
        $cache = \Config\Services::cache();
        $cache->clean();

        // Clear view cache if exists
        $viewPath = WRITEPATH . 'cache/';
        $cacheCleared = 0;
        if (is_dir($viewPath)) {
            $files = glob($viewPath . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                    $cacheCleared++;
                }
            }
        }

        // Clear old logs (keep only recent)
        $logPath = WRITEPATH . 'logs/';
        $logsCleared = 0;
        if (is_dir($logPath)) {
            $files = glob($logPath . '*.log');
            foreach ($files as $file) {
                if (filemtime($file) < strtotime('-7 days')) {
                    unlink($file);
                    $logsCleared++;
                }
            }
        }

        $message = "Optimasi berhasil! Cache dibersihkan ($cacheCleared files), Log lama dihapus ($logsCleared files). Aplikasi sekarang lebih cepat.";
        
        return redirect()->to('/dashboard')->with('success', $message);
    }
    
    /**
     * Show optimization status
     */
    public function status()
    {
        $data = [
            'title' => 'Status Optimasi',
            'cache_info' => [
                'driver' => config('Cache')->default,
                'cache_path' => WRITEPATH . 'cache/',
                'cache_files' => count(glob(WRITEPATH . 'cache/*')),
            ],
            'performance' => get_performance_info()
        ];
        
        return view('optimize/status', $data);
    }
}
