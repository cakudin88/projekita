<?php
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

    echo "=== ADDING MISSING COLUMNS ===\n\n";

    // Add can_report_incident column if it doesn't exist
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN can_report_incident TINYINT(1) NOT NULL DEFAULT 0");
        echo "✅ Column can_report_incident added to users table\n";
    } catch (Exception $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "ℹ️ Column can_report_incident already exists\n";
        } else {
            echo "❌ Error adding can_report_incident: " . $e->getMessage() . "\n";
        }
    }

    // Create chat_messages table if it doesn't exist
    try {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS chat_messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                sender_id INT NOT NULL,
                receiver_id INT NOT NULL,
                message TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ");
        echo "✅ Table chat_messages created/verified\n";
    } catch (Exception $e) {
        echo "❌ Error creating chat_messages: " . $e->getMessage() . "\n";
    }

    // Create incident_reports table if it doesn't exist
    try {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS incident_reports (
                id INT AUTO_INCREMENT PRIMARY KEY,
                student_id INT NOT NULL,
                description TEXT NOT NULL,
                status ENUM('pending','reviewed','closed') DEFAULT 'pending',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                reviewed_by INT DEFAULT NULL,
                reviewed_at DATETIME DEFAULT NULL,
                FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL
            )
        ");
        echo "✅ Table incident_reports created/verified\n";
    } catch (Exception $e) {
        echo "❌ Error creating incident_reports: " . $e->getMessage() . "\n";
    }

    // Set can_report_incident for ahmad.rizki.pratama
    try {
        $stmt = $pdo->prepare("UPDATE users SET can_report_incident = 1 WHERE username = ?");
        $stmt->execute(['ahmad.rizki.pratama']);
        echo "✅ Set can_report_incident=1 for ahmad.rizki.pratama\n";
    } catch (Exception $e) {
        echo "❌ Error updating user: " . $e->getMessage() . "\n";
    }

    echo "\n=== CURRENT USERS STATUS ===\n";
    $stmt = $pdo->query("
        SELECT 
            u.username,
            u.full_name,
            r.name as role_name,
            u.can_report_incident
        FROM users u 
        LEFT JOIN roles r ON u.role_id = r.id 
        ORDER BY r.name, u.username
    ");
    
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
        $flag = $user['can_report_incident'] ? ' [CanReport]' : '';
        echo sprintf("👤 %-20s | %-10s | %s%s\n", 
            $user['username'], 
            $user['role_name'], 
            $user['full_name'],
            $flag
        );
    }

} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
}
?>
