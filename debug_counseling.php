<?php
echo "Starting debug...\n";

// Try to autoload the class
echo "Autoloading CounselingModel...\n";
try {
    require_once 'c:/xampp/htdocs/appbku/app/Models/CounselingModel.php';
    echo "✓ CounselingModel file found\n";
} catch (Exception $e) {
    echo "✗ Error loading CounselingModel: " . $e->getMessage() . "\n";
}

// Check if class exists
if (class_exists('App\Models\CounselingModel')) {
    echo "✓ CounselingModel class exists\n";
} else {
    echo "✗ CounselingModel class NOT found\n";
}

// List all files in Models directory
echo "\nFiles in Models directory:\n";
$files = scandir('c:/xampp/htdocs/appbku/app/Models/');
foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        echo "- $file\n";
    }
}

echo "\nDebug complete.\n";
?>
