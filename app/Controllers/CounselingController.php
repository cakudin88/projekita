<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CounselingController extends BaseController
{
    public function index()
    {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'CounselingController working - recreated!',
            'controller' => 'CounselingController',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }
    
    public function simple()
    {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'CounselingController simple method working!',
            'method' => 'simple'
        ]);
    }
    
    public function testCategoryModel()
    {
        try {
            $categoryModel = new \App\Models\CategoryModel();
            $count = $categoryModel->countAll();
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'CategoryModel loaded successfully!',
                'count' => $count
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
    
    public function dashboard()
    {
        try {
            // Load models
            $categoryModel = new \App\Models\CategoryModel();
            $counselingModel = new \App\Models\CounselingModel();

            // Get basic statistics
            $stats = [
                'total_sessions' => $counselingModel->countAll(),
                'today_sessions' => 0,
                'pending_sessions' => 0,
                'urgent_sessions' => 0,
            ];

            $categories = $categoryModel->findAll();

            $data = [
                'title' => 'Dashboard Bimbingan Konseling',
                'user_role' => 'test',
                'recent_sessions' => [],
                'upcoming_sessions' => [],
                'stats' => $stats,
                'categories' => $categories
            ];

            return view('counseling/index', $data);
            
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
