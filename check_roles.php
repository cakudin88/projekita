<?php
// Check roles table
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $db = new PDO(
        "mysql:host=" . $_ENV['database_default_hostname'] . ";dbname=" . $_ENV['database_default_database'],
        $_ENV['database_default_username'],
        $_ENV['database_default_password']
    );
    
    echo "=== Checking roles table ===\n";
    
    // Check if table exists
    $result = $db->query("SHOW TABLES LIKE 'roles'");
    if ($result->rowCount() == 0) {
        echo "❌ Table 'roles' does not exist!\n";
        
        // Create roles table
        echo "\n🔧 Creating roles table...\n";
        $createTable = "
        CREATE TABLE `roles` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `description` text,
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `name` (`name`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        
        $db->exec($createTable);
        echo "✅ Table 'roles' created successfully!\n";
        
        // Insert default roles
        echo "\n🔧 Inserting default roles...\n";
        $insertRoles = "
        INSERT INTO `roles` (`name`, `description`) VALUES
        ('super_admin', 'Super Administrator'),
        ('kepala_sekolah', 'Kepala Sekolah'),
        ('guru_bk', 'Guru Bimbingan Konseling'),
        ('guru_mapel', 'Guru Mata Pelajaran'),
        ('guru', 'Guru Umum'),
        ('murid', 'Murid/Siswa'),
        ('staff', 'Staff Sekolah'),
        ('orang_tua', 'Orang Tua Murid');
        ";
        
        $db->exec($insertRoles);
        echo "✅ Default roles inserted successfully!\n";
        
    } else {
        echo "✅ Table 'roles' exists\n";
    }
    
    // Check roles data
    echo "\n=== Current roles data ===\n";
    $stmt = $db->query("SELECT * FROM roles ORDER BY id");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($roles)) {
        echo "❌ No roles found in table!\n";
        
        // Insert default roles if empty
        echo "\n🔧 Inserting default roles...\n";
        $insertRoles = "
        INSERT INTO `roles` (`name`, `description`) VALUES
        ('super_admin', 'Super Administrator'),
        ('kepala_sekolah', 'Kepala Sekolah'),
        ('guru_bk', 'Guru Bimbingan Konseling'),
        ('guru_mapel', 'Guru Mata Pelajaran'),
        ('guru', 'Guru Umum'),
        ('murid', 'Murid/Siswa'),
        ('staff', 'Staff Sekolah'),
        ('orang_tua', 'Orang Tua Murid');
        ";
        
        $db->exec($insertRoles);
        echo "✅ Default roles inserted!\n";
        
        // Re-fetch roles
        $stmt = $db->query("SELECT * FROM roles ORDER BY id");
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    echo "Total roles: " . count($roles) . "\n";
    foreach ($roles as $role) {
        echo "- ID: {$role['id']}, Name: {$role['name']}, Description: {$role['description']}\n";
    }
    
    // Check users with roles
    echo "\n=== Users count by role ===\n";
    $stmt = $db->query("
        SELECT r.name as role_name, COUNT(u.id) as user_count 
        FROM roles r 
        LEFT JOIN users u ON u.role_id = r.id 
        GROUP BY r.id, r.name 
        ORDER BY r.id
    ");
    $userCounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($userCounts as $count) {
        echo "- {$count['role_name']}: {$count['user_count']} users\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
