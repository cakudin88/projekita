<?php

// Test file untuk debug
phpinfo();

// Cek apakah mod_rewrite aktif
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<br><b>mod_rewrite: AKTIF</b>";
    } else {
        echo "<br><b>mod_rewrite: TIDAK AKTIF</b>";
    }
}

// Cek database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=appbku_school', 'root', '');
    echo "<br><b>Database: TERHUBUNG</b>";
    
    // Cek tabel roles
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM roles");
    $result = $stmt->fetch();
    echo "<br><b>Jumlah roles: " . $result['count'] . "</b>";
    
} catch (Exception $e) {
    echo "<br><b>Database: ERROR - " . $e->getMessage() . "</b>";
}

?>
