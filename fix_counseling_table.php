<?php
// Script untuk memperbaiki tabel counseling_requests
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

    echo "Connected to database successfully!\n";

    // Check current table structure
    echo "\n=== Checking current table structure ===\n";
    $stmt = $pdo->query("DESCRIBE counseling_requests");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $hascounselorId = false;
    foreach ($columns as $column) {
        echo "Column: " . $column['Field'] . " - Type: " . $column['Type'] . "\n";
        if ($column['Field'] === 'counselor_id') {
            $hascounselorId = true;
        }
    }

    if (!$hascounselorId) {
        echo "\n=== Adding missing counselor_id column ===\n";
        $pdo->exec("ALTER TABLE counseling_requests ADD COLUMN counselor_id INT(11) DEFAULT NULL COMMENT 'ID guru BK yang menangani' AFTER status");
        echo "counselor_id column added successfully!\n";
    } else {
        echo "\ncounselor_id column already exists!\n";
    }

    // Check if we need other columns
    $requiredColumns = [
        'counseling_date' => 'DATETIME DEFAULT NULL',
        'response_message' => 'TEXT DEFAULT NULL',
        'rejected_reason' => 'TEXT DEFAULT NULL'
    ];

    foreach ($requiredColumns as $colName => $colDefinition) {
        $found = false;
        foreach ($columns as $column) {
            if ($column['Field'] === $colName) {
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            echo "Adding missing column: $colName\n";
            $pdo->exec("ALTER TABLE counseling_requests ADD COLUMN $colName $colDefinition");
        }
    }

    echo "\n=== Final table structure ===\n";
    $stmt = $pdo->query("DESCRIBE counseling_requests");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        echo "Column: " . $column['Field'] . " - Type: " . $column['Type'] . "\n";
    }

    echo "\nDatabase repair completed successfully!\n";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
