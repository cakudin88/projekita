<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;

class DashboardController extends BaseController
{
    /**
     * Displays the main dashboard page with user statistics.
     * This version is optimized to use database queries for counting,
     * which is much more efficient than loading all users into memory.
     */
    public function index()
    {
        // Instantiate models
        $userModel = new UserModel();
        $roleModel = new RoleModel();

        // 1. Get current user's data for the welcome message
        $userId = session()->get('user_id');
        $currentUser = $userModel->find($userId);

        // 2. Get all roles and the total count of roles
        $roles = $roleModel->findAll();
        $totalRoles = count($roles);

        // 3. Get user statistics directly from the database (very efficient)
        $totalUsers = $userModel->countAllResults(false); // Use countAllResults for total count. `false` prevents query reset.
        $activeUsers = $userModel->where('is_active', 1)->countAllResults();

        // 4. Get counts for specific roles by joining tables
        // This is the most reliable way to count based on role names.

        // Count all teachers ('guru_bk' and 'guru_mapel')
        $guruCount = $userModel->join('roles', 'roles.id = users.role_id')
                                 ->whereIn('roles.name', ['guru_bk', 'guru_mapel'])
                                 ->countAllResults();

        // Count all students (assuming role name is 'siswa')
        $siswaCount = $userModel->join('roles', 'roles.id = users.role_id')
                                  ->where('roles.name', 'siswa')
                                  ->countAllResults();
        
        // Note: admin_count is not included in the dashboard screenshot, but can be added if needed
        // $adminCount = $userModel->join('roles', 'roles.id = users.role_id')
        //                         ->where('roles.name', 'super_admin')
        //                         ->countAllResults();


        // 5. Prepare all the data to be sent to the view
        $data = [
            'title' => 'Dashboard',
            'user' => $currentUser,
            'stats' => [
                'total_users'  => $totalUsers,
                'total_roles'  => $totalRoles,
                'total_siswa'  => $siswaCount,
                'guru_count'   => $guruCount,
                'active_users' => $activeUsers,
                // 'admin_count'  => $adminCount, // Uncomment if you need this value in the view
            ]
        ];

        // FOR DEBUGGING: If values are still zero, uncomment the line below to check the final data.
        // dd($data);

        return view('dashboard/index', $data);
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
}
