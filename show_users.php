<?php
// Script untuk menampilkan daftar user - HANYA UNTUK DEVELOPMENT
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $host = $_ENV['database_default_hostname'] ?? 'localhost';
    $database = $_ENV['database_default_database'] ?? 'appbke';
    $username = $_ENV['database_default_username'] ?? 'root';
    $password = $_ENV['database_default_password'] ?? '';

    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== DAFTAR USER DI SISTEM ===\n\n";

    // Get users with roles and can_report_incident
    $stmt = $pdo->query("
        SELECT 
            u.id,
            u.username,
            u.email,
            u.full_name,
            u.password,
            u.can_report_incident,
            r.name as role_name
        FROM users u 
        LEFT JOIN roles r ON u.role_id = r.id 
        ORDER BY r.name, u.username
    ");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($users)) {
        echo "❌ Tidak ada user ditemukan di database.\n";
        echo "Membuat user default...\n\n";
        
        // Create default users
        $defaultUsers = [
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'email' => 'admin@appbke.com',
                'full_name' => 'Super Administrator',
                'role_id' => 1
            ],
            [
                'username' => 'guru_bk',
                'password' => password_hash('gurubk123', PASSWORD_DEFAULT),
                'email' => 'gurubk@appbke.com', 
                'full_name' => 'Guru BK',
                'role_id' => 2
            ],
            [
                'username' => 'murid1',
                'password' => password_hash('murid123', PASSWORD_DEFAULT),
                'email' => 'murid1@appbke.com',
                'full_name' => 'Murid Test 1',
                'role_id' => 3
            ],
            [
                'username' => 'murid2', 
                'password' => password_hash('murid123', PASSWORD_DEFAULT),
                'email' => 'murid2@appbke.com',
                'full_name' => 'Murid Test 2',
                'role_id' => 3
            ]
        ];
        
        foreach ($defaultUsers as $user) {
            $insertStmt = $pdo->prepare("
                INSERT INTO users (username, password, email, full_name, role_id) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $insertStmt->execute([
                $user['username'],
                $user['password'], 
                $user['email'],
                $user['full_name'],
                $user['role_id']
            ]);
        }
        
        echo "✅ Default users created!\n\n";
        
        // Re-fetch users
        $stmt = $pdo->query("
            SELECT 
                u.id,
                u.username,
                u.email,
                u.full_name,
                r.name as role_name
            FROM users u 
            LEFT JOIN roles r ON u.role_id = r.id 
            ORDER BY r.name, u.username
        ");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Display users grouped by role
    $currentRole = '';
    foreach ($users as $user) {
        if ($currentRole !== $user['role_name']) {
            $currentRole = $user['role_name'];
            echo "\n🔹 ROLE: " . strtoupper($currentRole ?: 'NO ROLE') . "\n";
            echo str_repeat("-", 60) . "\n";
        }
        $flag = isset($user['can_report_incident']) && $user['can_report_incident'] ? ' [LaporKejadian]' : '';
        echo sprintf(
            "👤 %-15s | %-20s | %s%s\n",
            $user['username'],
            $user['email'],
            $user['full_name'],
            $flag
        );
    }
    
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "📋 LOGIN CREDENTIALS:\n";
    echo str_repeat("=", 60) . "\n";
    
    $loginInfo = [
        'Super Admin' => ['username' => 'admin', 'password' => 'admin123'],
        'Guru BK' => ['username' => 'guru_bk', 'password' => 'gurubk123'], 
        'Murid 1' => ['username' => 'murid1', 'password' => 'murid123'],
        'Murid 2' => ['username' => 'murid2', 'password' => 'murid123']
    ];
    
    foreach ($loginInfo as $role => $creds) {
        echo sprintf(
            "🔑 %-12s | Username: %-10s | Password: %s\n",
            $role,
            $creds['username'],
            $creds['password']
        );
    }
    
    echo "\n📝 NOTES:\n";
    echo "- Login di: http://localhost:8080\n";
    echo "- Gunakan username dan password di atas\n";
    echo "- Setiap role memiliki akses yang berbeda\n";
    echo "- Admin: Full access\n";
    echo "- Guru BK: Kelola permintaan konseling\n";
    echo "- Murid: Ajukan permintaan konseling\n\n";

} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
