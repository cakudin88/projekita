<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;

class DatabaseTestController extends BaseController
{
    public function index()
    {
        echo "<h2>Database Connection Test</h2>";
        
        try {
            $db = \Config\Database::connect();
            echo "<p>✅ Database connection successful</p>";
            
            // Test basic query
            $query = $db->query("SELECT COUNT(*) as count FROM users");
            $result = $query->getRow();
            echo "<p>✅ Basic query test: " . $result->count . " users found</p>";
            
            // Test UserModel
            $userModel = new UserModel();
            $userCount = $userModel->countAllResults(false);
            echo "<p>✅ UserModel test: " . $userCount . " users</p>";
            
            // Test RoleModel
            $roleModel = new RoleModel();
            $roleCount = $roleModel->countAllResults(false);
            echo "<p>✅ RoleModel test: " . $roleCount . " roles</p>";
            
            // Test join query
            $userModel2 = new UserModel();
            $joinQuery = $userModel2
                ->select('users.*, r.name as role_name')
                ->join('roles r', 'r.id = users.role_id', 'left')
                ->findAll();
            echo "<p>✅ Join query test: " . count($joinQuery) . " records with roles</p>";
            
            // Test specific role count
            $userModel3 = new UserModel();
            $siswaCount = $userModel3
                ->join('roles rs', 'rs.id = users.role_id')
                ->where('rs.name', 'siswa')
                ->countAllResults(false);
            echo "<p>✅ Siswa count test: " . $siswaCount . " siswa</p>";
            
            // Test guru count
            $userModel4 = new UserModel();
            $guruCount = $userModel4
                ->join('roles rg', 'rg.id = users.role_id')
                ->whereIn('rg.name', ['guru_bk', 'guru_mapel'])
                ->countAllResults(false);
            echo "<p>✅ Guru count test: " . $guruCount . " guru</p>";
            
        } catch (\Exception $e) {
            echo "<p>❌ Error: " . $e->getMessage() . "</p>";
            echo "<p>File: " . $e->getFile() . " Line: " . $e->getLine() . "</p>";
        }
        
        echo "<hr>";
        echo "<a href='/dashboard'>Back to Dashboard</a>";
    }
}
