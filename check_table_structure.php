<?php
// Script untuk memeriksa dan membuat tabel counseling_requests jika diperlukan

$host = 'localhost';
$dbname = 'appbke_school';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully.\n";
    
    // Check if table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'counseling_requests'");
    $tableExists = $stmt->rowCount() > 0;
    
    if ($tableExists) {
        echo "Table counseling_requests exists.\n";
        
        // Check table structure
        $stmt = $pdo->query("DESCRIBE counseling_requests");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "Current table structure:\n";
        foreach ($columns as $column) {
            echo "- {$column['Field']} ({$column['Type']})\n";
        }
        
        // Check if created_at column exists
        $hasCreatedAt = false;
        foreach ($columns as $column) {
            if ($column['Field'] === 'created_at') {
                $hasCreatedAt = true;
                break;
            }
        }
        
        if (!$hasCreatedAt) {
            echo "\nAdding created_at and updated_at columns...\n";
            $pdo->exec("ALTER TABLE counseling_requests 
                       ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
            echo "Columns added successfully.\n";
        } else {
            echo "\ncreated_at column already exists.\n";
        }
        
        // Check data count
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM counseling_requests");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "\nTotal records: $count\n";
        
    } else {
        echo "Table counseling_requests does not exist. Creating table...\n";
        
        $createTableSQL = "
        CREATE TABLE counseling_requests (
            id INT AUTO_INCREMENT PRIMARY KEY,
            student_id INT NOT NULL,
            type ENUM('individu', 'kelompok', 'klasikal') DEFAULT 'individu',
            theme VARCHAR(255),
            group_name VARCHAR(255),
            description TEXT,
            status ENUM('pending', 'approved', 'rejected', 'scheduled', 'completed') DEFAULT 'pending',
            counselor_id INT,
            counseling_date DATETIME,
            response_message TEXT,
            rejected_reason TEXT,
            requested_at DATETIME,
            approved_by INT,
            approved_at DATETIME,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_student_id (student_id),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        
        $pdo->exec($createTableSQL);
        echo "Table created successfully.\n";
        
        // Insert sample data
        $insertSQL = "INSERT INTO counseling_requests (student_id, type, theme, description, status) VALUES 
                     (5, 'individu', 'Kesulitan Belajar', 'Butuh bantuan dalam mata pelajaran matematika', 'pending'),
                     (5, 'individu', 'Masalah Sosial', 'Ingin konsultasi tentang hubungan pertemanan', 'completed')";
        
        try {
            $pdo->exec($insertSQL);
            echo "Sample data inserted.\n";
        } catch (Exception $e) {
            echo "Note: Could not insert sample data (user might not exist): " . $e->getMessage() . "\n";
        }
    }
    
    echo "\nTable check completed successfully!\n";
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    echo "Please check your database connection settings.\n";
}
?>
