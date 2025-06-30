<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DebugController extends BaseController
{
    public function index()
    {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'DebugController is working!',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }
    
    public function checkCounseling()
    {
        try {
            // Check if CounselingController file exists
            $controllerPath = APPPATH . 'Controllers/CounselingController.php';
            
            if (!file_exists($controllerPath)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'CounselingController.php file does not exist',
                    'path' => $controllerPath
                ]);
            }
            
            // Try to create instance
            $controller = new \App\Controllers\CounselingController();
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'CounselingController can be instantiated',
                'class' => get_class($controller)
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
