<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;

class DashboardController extends BaseController
{
    /**
     * Displays the main dashboard page with user statistics.
     * This version is optimized with caching and minimal database queries.
     */
    public function index()
    {
        try {
            // Check if stats are cached (cache for 5 minutes)
            $cache = \Config\Services::cache();
            $cacheKey = 'dashboard_stats_' . session()->get('user_id');
            $cachedData = $cache->get($cacheKey);
            
            if ($cachedData !== null) {
                // Use cached data
                $data = $cachedData;
            } else {
                // Generate fresh data with completely separate queries to avoid conflicts
                $db = \Config\Database::connect();
                
                // Use direct database queries to avoid model conflicts
                $totalUsers = $db->query("SELECT COUNT(*) as count FROM users")->getRow()->count;
                $totalRoles = $db->query("SELECT COUNT(*) as count FROM roles")->getRow()->count;
                $activeUsers = $db->query("SELECT COUNT(*) as count FROM users WHERE is_active = 1")->getRow()->count;
                
                // Count murid with direct query (nama role yang benar adalah 'murid')
                $muridQuery = "SELECT COUNT(*) as count FROM users u 
                              INNER JOIN roles r ON r.id = u.role_id 
                              WHERE r.name = 'murid'";
                $muridCount = $db->query($muridQuery)->getRow()->count;
                
                // Count guru with direct query
                $guruQuery = "SELECT COUNT(*) as count FROM users u 
                             INNER JOIN roles r ON r.id = u.role_id 
                             WHERE r.name IN ('guru_bk', 'guru_mapel', 'guru')";
                $guruCount = $db->query($guruQuery)->getRow()->count;

                // 4. Prepare optimized data structure
                $data = [
                    'title' => 'Dashboard',
                    'stats' => [
                        'total_roles'  => $totalRoles,
                        'total_murid'  => $muridCount,
                        'guru_count'   => $guruCount,
                        'active_users' => $activeUsers,
                    ]
                ];
                
                // Cache the data for 5 minutes (300 seconds)
                $cache->save($cacheKey, $data, 300);
            }

            return view('dashboard/full', optimize_view_data($data));
            
        } catch (\Exception $e) {
            log_message('error', 'Dashboard Error: ' . $e->getMessage());
            // Return simple error page
            $errorData = [
                'title' => 'Dashboard Error',
                'stats' => [
                    'total_roles' => 0,
                    'total_murid' => 0,
                    'guru_count' => 0,
                    'active_users' => 0,
                ]
            ];
            return view('dashboard/optimized', $errorData);
        }
    }

    /**
     * Displays the profile page of the currently logged-in user.
     */
    public function profile()
    {
        try {
            $userModel = new UserModel();
            $userId = session()->get('user_id');

            if (!$userId) {
                return redirect()->to('/login')->with('error', 'Sesi tidak valid. Silakan login kembali.');
            }

            $user = $userModel
                ->select('users.*, roles.name as role_name, roles.description as role_description')
                ->join('roles', 'roles.id = users.role_id', 'left')
                ->where('users.id', $userId)
                ->first();

            if (!$user) {
                return redirect()->to('/login')->with('error', 'User tidak ditemukan atau belum login.');
            }

            $data = [
                'title' => 'Profile',
                'user' => $user
            ];

            return view('dashboard/profile', $data);

        } catch (\Throwable $e) {
            log_message('error', '[DashboardController] ' . $e->getMessage());
            return "Terjadi error pada halaman profile. Silakan hubungi administrator.";
        }
    }

    /**
     * Clear dashboard cache - useful for testing or when data changes
     */
    public function clearCache()
    {
        $cache = \Config\Services::cache();
        $cacheKey = 'dashboard_stats_' . session()->get('user_id');
        $cache->delete($cacheKey);
        
        return redirect()->to('/dashboard')->with('success', 'Cache dashboard berhasil dibersihkan!');
    }

    /**
     * Ultra-fast lightweight dashboard version
     */
    public function lightning()
    {
        try {
            // Use ultra-aggressive caching (10 minutes)
            $cache = \Config\Services::cache();
            $cacheKey = cache_key_user('lightning_stats');
            $data = $cache->get($cacheKey);
            
            if ($data === null) {
                // Use direct database queries to avoid any model conflicts
                $db = \Config\Database::connect();

                // Minimal queries, maximum efficiency
                $data = [
                    'title' => 'Dashboard',
                    'stats' => [
                        'total_roles'  => $db->query("SELECT COUNT(*) as count FROM roles")->getRow()->count,
                        'total_murid'  => $db->query("SELECT COUNT(*) as count FROM users u INNER JOIN roles r ON r.id = u.role_id WHERE r.name = 'murid'")->getRow()->count,
                        'guru_count'   => $db->query("SELECT COUNT(*) as count FROM users u INNER JOIN roles r ON r.id = u.role_id WHERE r.name IN ('guru_bk', 'guru_mapel')")->getRow()->count,
                        'active_users' => $db->query("SELECT COUNT(*) as count FROM users WHERE is_active = 1")->getRow()->count,
                    ]
                ];
                
                // Cache for 10 minutes
                $cache->save($cacheKey, $data, 600);
            }

            return view('dashboard/lightning', optimize_view_data($data));
            
        } catch (\Exception $e) {
            log_message('error', 'Lightning Dashboard Error: ' . $e->getMessage());
            
            // Ultra-minimal fallback
            $data = [
                'title' => 'Dashboard',
                'stats' => array_fill_keys(['total_roles', 'total_murid', 'guru_count', 'active_users'], 0)
            ];
            return view('dashboard/lightning', $data);
        }
    }

    /**
     * Debug dashboard version - minimal queries for testing
     */
    public function debug()
    {
        try {
            // Bypass cache for debugging
            $data = [
                'title' => 'Dashboard Debug',
                'stats' => [
                    'total_roles' => 'Testing...',
                    'total_murid' => 'Testing...',
                    'guru_count' => 'Testing...',
                    'active_users' => 'Testing...',
                ]
            ];
            
            // Try to get real data step by step
            try {
                $roleModel = new RoleModel();
                $data['stats']['total_roles'] = $roleModel->countAllResults(false);
            } catch (\Exception $e) {
                $data['stats']['total_roles'] = 'Error: ' . $e->getMessage();
            }
            
            try {
                $activeModel = new UserModel();
                $data['stats']['active_users'] = $activeModel->where('is_active', 1)->countAllResults(false);
            } catch (\Exception $e) {
                $data['stats']['active_users'] = 'Error: ' . $e->getMessage();
            }
            
            try {
                $muridModel = new UserModel();
                $data['stats']['total_murid'] = $muridModel
                    ->join('roles r', 'r.id = users.role_id')
                    ->where('r.name', 'murid')
                    ->countAllResults(false);
            } catch (\Exception $e) {
                $data['stats']['total_murid'] = 'Error: ' . $e->getMessage();
            }
            
            try {
                $guruModel = new UserModel();
                $data['stats']['guru_count'] = $guruModel
                    ->join('roles rg', 'rg.id = users.role_id')
                    ->whereIn('rg.name', ['guru_bk', 'guru_mapel'])
                    ->countAllResults(false);
            } catch (\Exception $e) {
                $data['stats']['guru_count'] = 'Error: ' . $e->getMessage();
            }

            return view('dashboard/debug', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Debug Dashboard Error: ' . $e->getMessage());
            
            $data = [
                'title' => 'Dashboard Debug Error',
                'stats' => [
                    'error' => $e->getMessage(),
                    'total_roles' => 'Failed',
                    'total_murid' => 'Failed',
                    'guru_count' => 'Failed',
                    'active_users' => 'Failed',
                ]
            ];
            return view('dashboard/debug', $data);
        }
    }
}
