<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TestBKController extends BaseController
{
    public function index()
    {
        // Basic test without complex models
        $data = [
            'title' => 'Test Dashboard BK',
            'stats' => [
                'total_sessions' => 5,
                'today_sessions' => 2,
                'pending_sessions' => 3,
                'urgent_sessions' => 1
            ],
            'categories' => [
                ['name' => 'Akademik', 'color' => '#2563eb'],
                ['name' => 'Sosial', 'color' => '#16a34a'],
                ['name' => 'Pribadi', 'color' => '#dc2626']
            ],
            'recent_sessions' => [],
            'upcoming_sessions' => [],
            'user_role' => session()->get('role_name') ?: 'guest'
        ];

        return view('counseling/index', $data);
    }
}
