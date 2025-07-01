<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class DatabaseFixController extends BaseController
{
    public function fixCounselingTable()
    {
        $db = \Config\Database::connect();
        
        try {
            echo "<h3>Fixing Counseling Requests Table</h3>";
            
            // Check if table exists
            if (!$db->tableExists('counseling_requests')) {
                echo "<p style='color: red;'>Table counseling_requests does not exist! Creating...</p>";
                $this->createCounselingTable($db);
            } else {
                echo "<p style='color: green;'>Table counseling_requests exists</p>";
            }
            
            // Check columns
            $fields = $db->getFieldNames('counseling_requests');
            echo "<h4>Current columns:</h4><ul>";
            foreach ($fields as $field) {
                echo "<li>$field</li>";
            }
            echo "</ul>";
            
            // Add missing columns
            $requiredColumns = [
                'counselor_id' => 'INT(11) DEFAULT NULL',
                'counseling_date' => 'DATETIME DEFAULT NULL',
                'response_message' => 'TEXT DEFAULT NULL',
                'rejected_reason' => 'TEXT DEFAULT NULL'
            ];
            
            foreach ($requiredColumns as $column => $definition) {
                if (!in_array($column, $fields)) {
                    echo "<p style='color: orange;'>Adding missing column: $column</p>";
                    $db->query("ALTER TABLE counseling_requests ADD COLUMN $column $definition");
                } else {
                    echo "<p style='color: green;'>Column $column exists</p>";
                }
            }
            
            echo "<h4>Final table structure:</h4>";
            $result = $db->query("DESCRIBE counseling_requests");
            echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
            foreach ($result->getResultArray() as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            
            echo "<p style='color: green; font-weight: bold;'>Database fix completed!</p>";
            echo "<p><a href='/counseling-requests'>Test Counseling Requests</a></p>";
            
        } catch (\Exception $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        }
    }
    
    private function createCounselingTable($db)
    {
        $sql = "
        CREATE TABLE `counseling_requests` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) NOT NULL,
            `type` enum('individu','kelompok','klasikal') NOT NULL,
            `theme` varchar(255) NOT NULL,
            `group_name` varchar(255) DEFAULT NULL,
            `description` text NOT NULL,
            `status` enum('pending','approved','rejected','completed') NOT NULL DEFAULT 'pending',
            `counselor_id` int(11) DEFAULT NULL,
            `counseling_date` datetime DEFAULT NULL,
            `response_message` text DEFAULT NULL,
            `rejected_reason` text DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";
        
        $db->query($sql);
        echo "<p style='color: green;'>Table counseling_requests created successfully!</p>";
    }
}
?>
