<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=appbku_school', 'root', '');
    
    echo "<h3>Data Users:</h3>";
    $stmt = $pdo->query("SELECT u.id, u.username, u.email, r.name as role_name FROM users u JOIN roles r ON u.role_id = r.id");
    while ($row = $stmt->fetch()) {
        echo "ID: {$row['id']}, Username: {$row['username']}, Email: {$row['email']}, Role: {$row['role_name']}<br>";
    }
    
    echo "<h3>Data Roles:</h3>";
    $stmt = $pdo->query("SELECT * FROM roles");
    while ($row = $stmt->fetch()) {
        echo "ID: {$row['id']}, Name: {$row['name']}, Description: {$row['description']}<br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>
