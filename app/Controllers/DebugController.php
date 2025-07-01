<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DebugController extends BaseController
{
    public function index()
    {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'DebugController is working!',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }
    
    public function checkCounseling()
    {
        try {
            // Check if CounselingController file exists
            $controllerPath = APPPATH . 'Controllers/CounselingController.php';
            
            if (!file_exists($controllerPath)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'CounselingController.php file does not exist',
                    'path' => $controllerPath
                ]);
            }
            
            // Try to create instance
            $controller = new \App\Controllers\CounselingController();
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'CounselingController can be instantiated',
                'class' => get_class($controller)
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }
    
    public function checkStudentData()
    {
        $db = \Config\Database::connect();
        
        echo "<h2>Debug Data Siswa</h2>";
        
        // Check roles table
        echo "<h3>1. Semua Roles:</h3>";
        $roles = $db->query("SELECT * FROM roles")->getResult();
        echo "<pre>";
        foreach ($roles as $role) {
            echo "ID: {$role->id}, Name: {$role->name}, Description: {$role->description}\n";
        }
        echo "</pre>";
        
        // Check users with role murid
        echo "<h3>2. Users dengan Role 'murid':</h3>";
        $muridUsers = $db->query("SELECT u.*, r.name as role_name FROM users u 
                                 INNER JOIN roles r ON r.id = u.role_id 
                                 WHERE r.name = 'murid'")->getResult();
        echo "<pre>";
        if (!empty($muridUsers)) {
            foreach ($muridUsers as $user) {
                echo "ID: {$user->id}, Username: {$user->username}, Full Name: {$user->full_name}, Role: {$user->role_name}\n";
            }
        } else {
            echo "Tidak ada user dengan role 'murid'\n";
        }
        echo "</pre>";
        
        // Check count
        echo "<h3>3. Count Siswa:</h3>";
        $count = $db->query("SELECT COUNT(*) as count FROM users u 
                            INNER JOIN roles r ON r.id = u.role_id 
                            WHERE r.name = 'murid'")->getRow()->count;
        echo "<pre>Total Siswa: {$count}</pre>";
        
        echo "<br><a href='/dashboard'>Kembali ke Dashboard</a>";
        echo "<br><a href='/dashboard/clear-cache'>Clear Cache Dashboard</a>";
    }
    
    public function dashboard()
    {
        try {
            $db = \Config\Database::connect();
            
            echo "<h2>🔍 Dashboard Debug Information</h2>";
            
            // Test database connection
            echo "<h3>1. Database Connection</h3>";
            try {
                $result = $db->query("SELECT 1 as test")->getRow();
                echo "✅ Database connected successfully<br>";
            } catch (\Exception $e) {
                echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
                return;
            }
            
            // Check if tables exist
            echo "<h3>2. Tables Check</h3>";
            $tables = ['users', 'roles'];
            foreach ($tables as $table) {
                try {
                    $result = $db->query("SHOW TABLES LIKE '$table'")->getResultArray();
                    if (count($result) > 0) {
                        echo "✅ Table '$table' exists<br>";
                    } else {
                        echo "❌ Table '$table' does not exist<br>";
                    }
                } catch (\Exception $e) {
                    echo "❌ Error checking table '$table': " . $e->getMessage() . "<br>";
                }
            }
            
            // Check roles table structure and data
            echo "<h3>3. Roles Table</h3>";
            try {
                $rolesCount = $db->query("SELECT COUNT(*) as count FROM roles")->getRow()->count;
                echo "📊 Total roles: $rolesCount<br>";
                
                if ($rolesCount == 0) {
                    echo "⚠️ Roles table is empty! Creating default roles...<br>";
                    
                    // Insert default roles
                    $defaultRoles = [
                        ['super_admin', 'Super Administrator'],
                        ['kepala_sekolah', 'Kepala Sekolah'],
                        ['guru_bk', 'Guru Bimbingan Konseling'],
                        ['guru_mapel', 'Guru Mata Pelajaran'],
                        ['guru', 'Guru Umum'],
                        ['murid', 'Murid/Siswa'],
                        ['staff', 'Staff Sekolah'],
                        ['orang_tua', 'Orang Tua Murid']
                    ];
                    
                    foreach ($defaultRoles as $role) {
                        $db->query("INSERT INTO roles (name, description) VALUES (?, ?)", $role);
                    }
                    
                    $rolesCount = $db->query("SELECT COUNT(*) as count FROM roles")->getRow()->count;
                    echo "✅ Inserted default roles. New count: $rolesCount<br>";
                }
                
                // Show all roles
                echo "<h4>Roles List:</h4>";
                $roles = $db->query("SELECT * FROM roles ORDER BY id")->getResultArray();
                foreach ($roles as $role) {
                    echo "- ID: {$role['id']}, Name: {$role['name']}, Description: {$role['description']}<br>";
                }
                
            } catch (\Exception $e) {
                echo "❌ Error with roles table: " . $e->getMessage() . "<br>";
            }
            
            // Check users table
            echo "<h3>4. Users Table</h3>";
            try {
                $usersCount = $db->query("SELECT COUNT(*) as count FROM users")->getRow()->count;
                echo "📊 Total users: $usersCount<br>";
                
                $activeUsers = $db->query("SELECT COUNT(*) as count FROM users WHERE is_active = 1")->getRow()->count;
                echo "📊 Active users: $activeUsers<br>";
                
                // Count users by role
                echo "<h4>Users by Role:</h4>";
                $usersByRole = $db->query("
                    SELECT r.name as role_name, COUNT(u.id) as user_count 
                    FROM roles r 
                    LEFT JOIN users u ON u.role_id = r.id 
                    GROUP BY r.id, r.name 
                    ORDER BY r.id
                ")->getResultArray();
                
                foreach ($usersByRole as $count) {
                    echo "- {$count['role_name']}: {$count['user_count']} users<br>";
                }
                
            } catch (\Exception $e) {
                echo "❌ Error with users table: " . $e->getMessage() . "<br>";
            }
            
            // Test dashboard queries
            echo "<h3>5. Dashboard Queries Test</h3>";
            try {
                $totalRoles = $db->query("SELECT COUNT(*) as count FROM roles")->getRow()->count;
                echo "✅ Total roles query: $totalRoles<br>";
                
                $totalMurid = $db->query("SELECT COUNT(*) as count FROM users u INNER JOIN roles r ON r.id = u.role_id WHERE r.name = 'murid'")->getRow()->count;
                echo "✅ Total murid query: $totalMurid<br>";
                
                $totalGuru = $db->query("SELECT COUNT(*) as count FROM users u INNER JOIN roles r ON r.id = u.role_id WHERE r.name IN ('guru_bk', 'guru_mapel', 'guru')")->getRow()->count;
                echo "✅ Total guru query: $totalGuru<br>";
                
                $activeUsers = $db->query("SELECT COUNT(*) as count FROM users WHERE is_active = 1")->getRow()->count;
                echo "✅ Active users query: $activeUsers<br>";
                
            } catch (\Exception $e) {
                echo "❌ Error with dashboard queries: " . $e->getMessage() . "<br>";
            }
            
            echo "<br><a href='/dashboard/clearCache' class='btn btn-primary'>Clear Dashboard Cache</a>";
            echo " <a href='/dashboard' class='btn btn-success'>Back to Dashboard</a>";
            
        } catch (\Exception $e) {
            echo "❌ General error: " . $e->getMessage();
        }
    }
}
