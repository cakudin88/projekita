<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class DatabaseFixController extends BaseController
{
    public function fixCounselingTable()
    {
        $db = \Config\Database::connect();
        
        try {
            echo "<h3>Fixing Counseling Requests Table - Advanced Fix</h3>";
            
            // Check if table exists
            if (!$db->tableExists('counseling_requests')) {
                echo "<p style='color: red;'>Table counseling_requests does not exist! Creating...</p>";
                $this->createCounselingTable($db);
                return;
            }
            
            echo "<p style='color: green;'>Table counseling_requests exists</p>";
            
            // Get current columns
            $fields = $db->getFieldNames('counseling_requests');
            echo "<h4>Current columns:</h4><ul>";
            foreach ($fields as $field) {
                echo "<li>$field</li>";
            }
            echo "</ul>";
            
            // Check for created_at and updated_at columns
            if (!in_array('created_at', $fields)) {
                echo "<p style='color: orange;'>Adding created_at column...</p>";
                $db->query("ALTER TABLE counseling_requests ADD COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
            } else {
                echo "<p style='color: green;'>created_at column exists</p>";
            }
            
            if (!in_array('updated_at', $fields)) {
                echo "<p style='color: orange;'>Adding updated_at column...</p>";
                $db->query("ALTER TABLE counseling_requests ADD COLUMN updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
            } else {
                echo "<p style='color: green;'>updated_at column exists</p>";
            }
            
            // Add other missing columns
            $requiredColumns = [
                'counselor_id' => 'INT(11) DEFAULT NULL',
                'counseling_date' => 'DATETIME DEFAULT NULL',
                'response_message' => 'TEXT DEFAULT NULL',
                'rejected_reason' => 'TEXT DEFAULT NULL'
            ];
            
            $fieldsAfter = $db->getFieldNames('counseling_requests'); // Refresh field list
            foreach ($requiredColumns as $column => $definition) {
                if (!in_array($column, $fieldsAfter)) {
                    echo "<p style='color: orange;'>Adding missing column: $column</p>";
                    $db->query("ALTER TABLE counseling_requests ADD COLUMN $column $definition");
                } else {
                    echo "<p style='color: green;'>Column $column exists</p>";
                }
            }
            
            // Test a simple query
            echo "<h4>Testing query...</h4>";
            try {
                $result = $db->query("SELECT COUNT(*) as total FROM counseling_requests")->getRow();
                echo "<p style='color: green;'>Query test successful! Total records: " . $result->total . "</p>";
                
                // Test ordering by created_at
                $testOrder = $db->query("SELECT id FROM counseling_requests ORDER BY created_at DESC LIMIT 1")->getRow();
                echo "<p style='color: green;'>ORDER BY created_at test successful!</p>";
                
            } catch (\Exception $e) {
                echo "<p style='color: red;'>Query test failed: " . $e->getMessage() . "</p>";
            }
            
            echo "<hr><p style='color: green; font-weight: bold; font-size: 18px;'>✅ Database fix completed successfully!</p>";
            echo "<p><a href='/counseling-requests' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Test Counseling Requests →</a></p>";
            
        } catch (\Exception $e) {
            echo "<p style='color: red; font-weight: bold;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}
?>
