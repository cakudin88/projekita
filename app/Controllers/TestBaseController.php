<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TestBaseController extends BaseController
{
    public function index()
    {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'TestBaseController working!',
            'controller' => 'TestBaseController'
        ]);
    }
}
