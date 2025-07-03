<?php
// Test script untuk memastikan controller bisa di-load tanpa error

require_once __DIR__ . '/vendor/autoload.php';

// Test loading controller classes
try {
    echo "Testing controller classes...\n";
    
    // Test CounselingRequestController
    $reflection = new ReflectionClass('App\Controllers\CounselingRequestController');
    echo "✅ CounselingRequestController: OK\n";
    
    // Test BKController  
    $reflection = new ReflectionClass('App\Controllers\BKController');
    echo "✅ BKController: OK\n";
    
    // Test Models
    $reflection = new ReflectionClass('App\Models\CounselingRequestModel');
    echo "✅ CounselingRequestModel: OK\n";
    
    $reflection = new ReflectionClass('App\Models\StudentModel');
    echo "✅ StudentModel: OK\n";
    
    $reflection = new ReflectionClass('App\Models\AppointmentModel');
    echo "✅ AppointmentModel: OK\n";
    
    $reflection = new ReflectionClass('App\Models\CategoryModel');
    echo "✅ CategoryModel: OK\n";
    
    echo "\n🎉 Semua class berhasil di-load!\n";
    echo "\nLangkah selanjutnya:\n";
    echo "1. Jalankan script SQL (create_missing_tables.sql) di phpMyAdmin\n";
    echo "2. Start server: php spark serve --port=8080\n";
    echo "3. Test di browser: http://localhost:8080/counseling-requests\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
?>
