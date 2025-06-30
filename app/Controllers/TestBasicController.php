<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TestBasicController extends BaseController
{
    public function index()
    {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'TestBasicController working with BaseController!',
            'controller' => 'TestBasicController'
        ]);
    }
}
