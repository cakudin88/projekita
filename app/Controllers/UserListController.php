<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class UserListController extends BaseController
{
    public function listUsers()
    {
        $db = \Config\Database::connect();
        
        try {
            echo "<h2>Daftar Username dan Password Sistem</h2>";
            echo "<div style='font-family: Arial, sans-serif; margin: 20px;'>";
            
            // Check if users table exists
            if (!$db->tableExists('users')) {
                echo "<p style='color: red;'>Tabel users tidak ditemukan!</p>";
                return;
            }
            
            // Get all users with their roles
            $query = "
                SELECT 
                    u.id,
                    u.username,
                    u.password_plain,
                    u.full_name,
                    u.email,
                    r.name as role_name,
                    u.is_active
                FROM users u
                LEFT JOIN roles r ON u.role_id = r.id
                ORDER BY r.id, u.username
            ";
            
            $result = $db->query($query);
            $users = $result->getResultArray();
            
            if (empty($users)) {
                echo "<p style='color: orange;'>Tidak ada data user ditemukan.</p>";
                echo "<p>Silakan import data user terlebih dahulu.</p>";
                return;
            }
            
            // Group by role
            $usersByRole = [];
            foreach ($users as $user) {
                $role = $user['role_name'] ?? 'No Role';
                if (!isset($usersByRole[$role])) {
                    $usersByRole[$role] = [];
                }
                $usersByRole[$role][] = $user;
            }
            
            // Display users by role
            foreach ($usersByRole as $role => $roleUsers) {
                $roleColor = match($role) {
                    'super_admin' => '#dc3545',
                    'kepala_sekolah' => '#6f42c1', 
                    'guru_bk' => '#28a745',
                    'wali_kelas' => '#fd7e14',
                    'guru' => '#20c997',
                    'murid' => '#0dcaf0',
                    default => '#6c757d'
                };
                
                echo "<div style='margin-bottom: 30px; padding: 15px; border: 2px solid $roleColor; border-radius: 8px;'>";
                echo "<h3 style='color: $roleColor; margin-top: 0;'>👤 " . strtoupper($role) . " (" . count($roleUsers) . " user)</h3>";
                
                echo "<table border='1' style='width: 100%; border-collapse: collapse; background: white;'>";
                echo "<tr style='background: $roleColor; color: white;'>";
                echo "<th style='padding: 10px; text-align: left;'>ID</th>";
                echo "<th style='padding: 10px; text-align: left;'>Username</th>";
                echo "<th style='padding: 10px; text-align: left;'>Password</th>";
                echo "<th style='padding: 10px; text-align: left;'>Nama Lengkap</th>";
                echo "<th style='padding: 10px; text-align: left;'>Email</th>";
                echo "<th style='padding: 10px; text-align: left;'>Status</th>";
                echo "</tr>";
                
                foreach ($roleUsers as $user) {
                    $statusColor = $user['is_active'] ? '#28a745' : '#dc3545';
                    $statusText = $user['is_active'] ? 'Aktif' : 'Non-Aktif';
                    
                    echo "<tr>";
                    echo "<td style='padding: 8px; border: 1px solid #ddd;'>" . $user['id'] . "</td>";
                    echo "<td style='padding: 8px; border: 1px solid #ddd; font-weight: bold;'>" . esc($user['username']) . "</td>";
                    echo "<td style='padding: 8px; border: 1px solid #ddd; font-family: monospace; background: #f8f9fa;'>" . 
                         esc($user['password_plain'] ?? 'Encrypted') . "</td>";
                    echo "<td style='padding: 8px; border: 1px solid #ddd;'>" . esc($user['full_name'] ?? '-') . "</td>";
                    echo "<td style='padding: 8px; border: 1px solid #ddd;'>" . esc($user['email'] ?? '-') . "</td>";
                    echo "<td style='padding: 8px; border: 1px solid #ddd; color: $statusColor; font-weight: bold;'>$statusText</td>";
                    echo "</tr>";
                }
                
                echo "</table>";
                echo "</div>";
            }
            
            // Quick test links
            echo "<div style='margin-top: 30px; padding: 20px; background: #e9ecef; border-radius: 8px;'>";
            echo "<h3>🔗 Quick Test Links</h3>";
            echo "<p><strong>Login Page:</strong> <a href='/login' target='_blank'>http://localhost:8080/login</a></p>";
            echo "<p><strong>Dashboard:</strong> <a href='/dashboard' target='_blank'>http://localhost:8080/dashboard</a></p>";
            echo "<p><strong>Counseling Requests:</strong> <a href='/counseling-requests' target='_blank'>http://localhost:8080/counseling-requests</a></p>";
            echo "</div>";
            
            // Usage instructions
            echo "<div style='margin-top: 20px; padding: 20px; background: #d1ecf1; border-radius: 8px;'>";
            echo "<h3>📋 Cara Penggunaan</h3>";
            echo "<ol>";
            echo "<li><strong>Login sebagai Murid:</strong> Gunakan username murid → akan langsung ke form pengajuan konseling</li>";
            echo "<li><strong>Login sebagai Guru BK:</strong> Gunakan username guru_bk → akan langsung ke list permintaan untuk disetujui/ditolak</li>";
            echo "<li><strong>Login sebagai Admin:</strong> Gunakan username super_admin → akses penuh ke semua fitur</li>";
            echo "</ol>";
            echo "</div>";
            
            echo "</div>";
            
        } catch (\Exception $e) {
            echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            
            // Try to show table structure if users table exists
            try {
                if ($db->tableExists('users')) {
                    echo "<h4>Struktur Tabel Users:</h4>";
                    $result = $db->query("DESCRIBE users");
                    echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
                    foreach ($result->getResultArray() as $row) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>" . htmlspecialchars($value ?? '') . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            } catch (\Exception $e2) {
                echo "<p>Could not show table structure: " . $e2->getMessage() . "</p>";
            }
        }
    }
}
?>
