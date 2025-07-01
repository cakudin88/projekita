<?php
echo "Starting database fix...\n";
flush();

try {
    $pdo = new PDO("mysql:host=localhost;dbname=appbke", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database\n";
    flush();
    
    // Add column
    $pdo->exec("ALTER TABLE users ADD COLUMN can_report_incident TINYINT(1) NOT NULL DEFAULT 0");
    echo "Column added\n";
    flush();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    flush();
}

echo "Done\n";
flush();
?>
