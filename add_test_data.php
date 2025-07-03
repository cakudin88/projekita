<?php
// Script untuk menambahkan data dummy counseling_requests untuk testing

$host = 'localhost';
$dbname = 'appbke_school';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully.\n";
    
    // Get a user with murid role
    $stmt = $pdo->query("
        SELECT u.id, u.full_name, u.username 
        FROM users u 
        JOIN roles r ON r.id = u.role_id 
        WHERE r.name = 'murid' 
        LIMIT 1
    ");
    $murid = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($murid) {
        echo "Found murid user: {$murid['full_name']} (ID: {$murid['id']})\n";
        
        // Insert sample counseling requests
        $insertSQL = "INSERT INTO counseling_requests 
                     (student_id, type, theme, description, status, created_at, updated_at) 
                     VALUES 
                     (?, 'individu', 'Kesulitan Belajar', 'Saya mengalami kesulitan dalam mata pelajaran matematika dan butuh bimbingan khusus', 'pending', NOW(), NOW())";
        
        $stmt = $pdo->prepare($insertSQL);
        $stmt->execute([$murid['id']]);
        
        $insertSQL2 = "INSERT INTO counseling_requests 
                      (student_id, type, theme, description, status, created_at, updated_at) 
                      VALUES 
                      (?, 'individu', 'Masalah Sosial', 'Ingin berkonsultasi tentang hubungan dengan teman-teman di kelas', 'completed', DATE_SUB(NOW(), INTERVAL 1 WEEK), DATE_SUB(NOW(), INTERVAL 1 WEEK))";
        
        $stmt = $pdo->prepare($insertSQL2);
        $stmt->execute([$murid['id']]);
        
        $insertSQL3 = "INSERT INTO counseling_requests 
                      (student_id, type, theme, description, status, created_at, updated_at) 
                      VALUES 
                      (?, 'kelompok', 'Bimbingan Karir', 'Diskusi kelompok tentang pilihan jurusan untuk SMA', 'scheduled', DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY))";
        
        $stmt = $pdo->prepare($insertSQL3);
        $stmt->execute([$murid['id']]);
        
        echo "Sample counseling requests inserted for user: {$murid['full_name']}\n";
        
        // Show current data
        $stmt = $pdo->prepare("SELECT * FROM counseling_requests WHERE student_id = ? ORDER BY created_at DESC");
        $stmt->execute([$murid['id']]);
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "\nCurrent counseling requests for this user:\n";
        foreach ($requests as $request) {
            echo "- {$request['theme']} ({$request['status']}) - {$request['created_at']}\n";
        }
        
    } else {
        echo "No murid user found. Creating a test murid user...\n";
        
        // Get murid role ID
        $stmt = $pdo->query("SELECT id FROM roles WHERE name = 'murid'");
        $role = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($role) {
            // Create test murid user
            $insertUserSQL = "INSERT INTO users 
                             (username, email, password, full_name, role_id, is_active, created_at, updated_at) 
                             VALUES 
                             ('murid_test', 'murid.test@school.com', ?, 'Siswa Test', ?, 1, NOW(), NOW())";
            
            $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare($insertUserSQL);
            $stmt->execute([$hashedPassword, $role['id']]);
            
            $newUserId = $pdo->lastInsertId();
            echo "Test murid user created with ID: $newUserId\n";
            echo "Login credentials: murid.test@school.com / password123\n";
            
            // Insert sample counseling requests for new user
            $insertSQL = "INSERT INTO counseling_requests 
                         (student_id, type, theme, description, status, created_at, updated_at) 
                         VALUES 
                         (?, 'individu', 'Kesulitan Belajar', 'Saya mengalami kesulitan dalam mata pelajaran matematika', 'pending', NOW(), NOW()),
                         (?, 'individu', 'Masalah Sosial', 'Ingin berkonsultasi tentang hubungan pertemanan', 'completed', DATE_SUB(NOW(), INTERVAL 1 WEEK), DATE_SUB(NOW(), INTERVAL 1 WEEK))";
            
            $stmt = $pdo->prepare($insertSQL);
            $stmt->execute([$newUserId, $newUserId]);
            
            echo "Sample counseling requests inserted for new test user.\n";
        } else {
            echo "Murid role not found. Please check your roles table.\n";
        }
    }
    
    echo "\nData setup completed successfully!\n";
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>
