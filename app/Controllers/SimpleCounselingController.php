<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SimpleCounselingController extends BaseController
{
    public function index()
    {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'SimpleCounselingController working!',
            'controller' => 'SimpleCounselingController'
        ]);
    }
}
