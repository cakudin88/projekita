<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TestController extends BaseController
{
    public function testCounseling()
    {
        try {
            // Test if we can load models correctly
            $result = [];
            
            // Test CategoryModel
            try {
                $categoryModel = new \App\Models\CategoryModel();
                $result['CategoryModel'] = 'OK - Count: ' . $categoryModel->countAll();
            } catch (\Exception $e) {
                $result['CategoryModel'] = 'ERROR: ' . $e->getMessage();
            }
            
            // Test CounselingModel  
            try {
                $counselingModel = new \App\Models\CounselingModel();
                $result['CounselingModel'] = 'OK - Count: ' . $counselingModel->countAll();
            } catch (\Exception $e) {
                $result['CounselingModel'] = 'ERROR: ' . $e->getMessage();
            }
            
            // Test if the old class name is still referenced somewhere
            if (class_exists('\App\Models\CounselingSessionModel')) {
                $result['CounselingSessionModel'] = 'WARNING: Old class still exists!';
            } else {
                $result['CounselingSessionModel'] = 'OK: Old class properly removed';
            }
            
            return $this->response->setJSON([
                'status' => 'success',
                'results' => $result
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    public function testUsers()
    {
        try {
            $userModel = new \App\Models\UserModel();
            $users = $userModel->findAll();
            
            $result = [];
            foreach ($users as $user) {
                $result[] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'] ?? 'N/A',
                    'role_id' => $user['role_id'],
                    'created_at' => $user['created_at'] ?? 'N/A'
                ];
            }
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Users found: ' . count($users),
                'users' => $result
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }
}
