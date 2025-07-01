<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DebugController extends BaseController
{
    public function index()
    {
        // Simple debug view without any extends
        echo "<!DOCTYPE html>";
        echo "<html><head><title>Debug</title></head><body>";
        echo "<h1>Debug Info</h1>";
        echo "<p>CodeIgniter Version: " . \CodeIgniter\CodeIgniter::CI_VERSION . "</p>";
        echo "<p>PHP Version: " . phpversion() . "</p>";
        echo "<p>Session Data:</p>";
        echo "<pre>" . print_r(session()->get(), true) . "</pre>";
        echo "<p>View Path: " . APPPATH . 'Views/' . "</p>";
        echo "<p>Environment: " . ENVIRONMENT . "</p>";
        echo "</body></html>";
        return;
    }
    
    public function testView()
    {
        try {
            $data = ['title' => 'Test'];
            return view('debug/test', $data);
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            echo "<br>File: " . $e->getFile();
            echo "<br>Line: " . $e->getLine();
            echo "<br>Trace: <pre>" . $e->getTraceAsString() . "</pre>";
        }
    }
}
