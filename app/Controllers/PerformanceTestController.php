<?php

namespace App\Controllers;

use App\Controllers\BaseController;

/**
 * Performance Testing Controller
 */
class PerformanceTestController extends BaseController
{
    /**
     * Test different dashboard versions and compare performance
     */
    public function index()
    {
        $results = [];
        
        // Test 1: Lightning Dashboard
        $start = microtime(true);
        $memory_start = memory_get_usage();
        
        try {
            $dashboardController = new DashboardController();
            $lightning = $dashboardController->lightning();
            $lightning_time = round((microtime(true) - $start) * 1000, 2);
            $lightning_memory = round((memory_get_usage() - $memory_start) / 1024 / 1024, 2);
        } catch (\Exception $e) {
            $lightning_time = 'Error';
            $lightning_memory = 'Error';
        }
        
        // Test 2: Optimized Dashboard  
        $start = microtime(true);
        $memory_start = memory_get_usage();
        
        try {
            $optimized = $dashboardController->index();
            $optimized_time = round((microtime(true) - $start) * 1000, 2);
            $optimized_memory = round((memory_get_usage() - $memory_start) / 1024 / 1024, 2);
        } catch (\Exception $e) {
            $optimized_time = 'Error';
            $optimized_memory = 'Error';
        }
        
        $data = [
            'title' => 'Performance Test',
            'results' => [
                'lightning' => [
                    'time' => $lightning_time . ' ms',
                    'memory' => $lightning_memory . ' MB'
                ],
                'optimized' => [
                    'time' => $optimized_time . ' ms', 
                    'memory' => $optimized_memory . ' MB'
                ],
                'system' => [
                    'php_version' => PHP_VERSION,
                    'ci_version' => \CodeIgniter\CodeIgniter::CI_VERSION,
                    'total_memory' => round(memory_get_usage() / 1024 / 1024, 2) . ' MB',
                    'peak_memory' => round(memory_get_peak_usage() / 1024 / 1024, 2) . ' MB'
                ]
            ]
        ];
        
        return view('performance/test', $data);
    }
    
    /**
     * Simple benchmark test
     */
    public function benchmark()
    {
        $iterations = 100;
        $times = [];
        
        for ($i = 0; $i < $iterations; $i++) {
            $start = microtime(true);
            
            // Simulate dashboard data loading
            $userModel = new \App\Models\UserModel();
            $count = $userModel->countAllResults(false);
            
            $times[] = (microtime(true) - $start) * 1000;
        }
        
        $average = array_sum($times) / count($times);
        $min = min($times);
        $max = max($times);
        
        echo "<h2>Benchmark Results ($iterations iterations)</h2>";
        echo "<p>Average: " . round($average, 2) . " ms</p>";
        echo "<p>Min: " . round($min, 2) . " ms</p>";
        echo "<p>Max: " . round($max, 2) . " ms</p>";
        echo "<p>Total memory: " . round(memory_get_usage() / 1024 / 1024, 2) . " MB</p>";
        
        return;
    }
}
