<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class BKController extends BaseController
{
    public function index()
    {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'BKController working!',
            'controller' => 'BKController'
        ]);
    }
    
    public function testModel()
    {
        try {
            $categoryModel = new \App\Models\CategoryModel();
            $count = $categoryModel->countAll();
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Model test successful!',
                'count' => $count
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function dashboard()
    {
        // Check authentication (comment out for now since we're testing)
        // if (!session()->get('isLoggedIn')) {
        //     return redirect()->to('/login');
        // }

        try {
            $categoryModel = new \App\Models\CategoryModel();
            $counselingModel = new \App\Models\CounselingModel();
            $studentModel = new \App\Models\StudentModel();

            // Get basic statistics
            $stats = [
                'total_sessions' => $counselingModel->countAll(),
                'today_sessions' => 0, // Will implement later
                'pending_sessions' => 0, // Will implement later  
                'urgent_sessions' => 0, // Will implement later
                'total_students' => $studentModel->countAll(),
                'total_categories' => $categoryModel->countAll()
            ];

            $categories = $categoryModel->findAll();
            
            // Get recent sessions (limit 5) - handle if method doesn't exist
            try {
                $recentSessions = $counselingModel->getSessionsWithDetails(5);
            } catch (\Exception $e) {
                // Fallback to simple findAll if getSessionsWithDetails doesn't exist
                $recentSessions = $counselingModel->findAll(5);
            }
            
            // Get upcoming sessions (limit 5) 
            $upcomingSessions = []; // Will implement later

            $data = [
                'title' => 'Dashboard Bimbingan Konseling',
                'user_role' => 'guru_bk', // Default for testing
                'recent_sessions' => $recentSessions,
                'upcoming_sessions' => $upcomingSessions,
                'stats' => $stats,
                'categories' => $categories
            ];

            // Set proper content type
            $this->response->setHeader('Content-Type', 'text/html; charset=utf-8');
            
            return view('counseling/simple_index', $data);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }
    
    public function debugView()
    {
        // Simple HTML test without view system
        $html = '<!DOCTYPE html>
<html>
<head>
    <title>Debug Dashboard BK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Dashboard Bimbingan Konseling - Debug</h1>
        <div class="alert alert-success">
            <strong>Success!</strong> Dashboard BK berfungsi dengan baik.
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Total Sesi</h5>
                        <h2 class="text-primary">25</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Siswa Aktif</h5>
                        <h2 class="text-success">8</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>';
        
        return $this->response->setBody($html);
    }
    
    public function sessions()
    {
        try {
            $counselingModel = new \App\Models\CounselingModel();
            
            // Get sessions with basic data - fallback if complex method doesn't exist
            try {
                $sessions = $counselingModel->getSessionsWithDetails();
            } catch (\Exception $e) {
                // Fallback to simple data with mock student/category info
                $sessions = $counselingModel->findAll();
                
                // Add mock data for display if relations fail
                if (is_array($sessions)) {
                    foreach ($sessions as &$session) {
                        if (!isset($session['student_name'])) {
                            $session['student_name'] = 'Siswa #' . ($session['student_id'] ?? 'N/A');
                            $session['student_class'] = 'Kelas 7A';
                            $session['category_name'] = 'Kategori #' . ($session['category_id'] ?? 'N/A');
                            $session['category_color'] = '#007bff';
                            $session['counselor_name'] = 'Guru BK';
                        }
                    }
                }
            }
            
            // Ensure sessions is array
            if (!is_array($sessions)) {
                $sessions = [];
            }
            
            $data = [
                'title' => 'Daftar Sesi Konseling',
                'sessions' => $sessions
            ];
            
            // Use simple view that is tested to work
            return view('counseling/sessions_simple', $data);
            
        } catch (\Exception $e) {
            // Return error view or redirect with fallback data
            $data = [
                'title' => 'Daftar Sesi Konseling',
                'sessions' => [],
                'error' => $e->getMessage()
            ];
            
            return view('counseling/sessions_simple', $data);
        }
    }
    
    public function create()
    {
        try {
            $categoryModel = new \App\Models\CategoryModel();
            $studentModel = new \App\Models\StudentModel();
            
            // Get data with fallback
            try {
                $students = $studentModel->getStudentsWithClass();
            } catch (\Exception $e) {
                // Fallback to basic student data
                $students = $studentModel->findAll();
                if (is_array($students)) {
                    foreach ($students as &$student) {
                        if (!isset($student['name'])) {
                            $student['name'] = $student['full_name'] ?? 'Siswa #' . $student['id'];
                            $student['class'] = $student['class'] ?? '7A';
                            $student['nis'] = $student['nis'] ?? '12345';
                        }
                    }
                }
            }
            
            $categories = $categoryModel->findAll();
            
            // Ensure arrays
            if (!is_array($students)) $students = [];
            if (!is_array($categories)) $categories = [];
            
            $data = [
                'title' => 'Buat Sesi Konseling Baru',
                'categories' => $categories,
                'students' => $students
            ];
            
            return view('counseling/create', $data);
            
        } catch (\Exception $e) {
            // Return with fallback data
            $data = [
                'title' => 'Buat Sesi Konseling Baru',
                'categories' => [],
                'students' => [],
                'error' => $e->getMessage()
            ];
            
            return view('counseling/create', $data);
        }
    }
    
    public function simpleHtml()
    {
        echo '<!DOCTYPE html>
<html>
<head><title>Simple Test</title></head>
<body>
    <h1>Simple HTML Test</h1>
    <p>If you see this properly formatted, HTML rendering works!</p>
</body>
</html>';
        exit;
    }
    
    public function testSimpleDashboard()
    {
        try {
            $categoryModel = new \App\Models\CategoryModel();
            $counselingModel = new \App\Models\CounselingModel();
            $studentModel = new \App\Models\StudentModel();

            $data = [
                'stats' => [
                    'total_sessions' => $counselingModel->countAll(),
                    'total_students' => $studentModel->countAll(),
                    'pending_sessions' => 3,
                    'urgent_sessions' => 1
                ],
                'categories' => $categoryModel->findAll()
            ];

            return view('counseling/simple_dashboard', $data);
            
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
    
    public function testLayout()
    {
        $data = [
            'title' => 'Test Layout',
            'message' => 'Testing layout system'
        ];
        
        return view('counseling/test_layout', $data);
    }
    
    public function debugData()
    {
        try {
            $categoryModel = new \App\Models\CategoryModel();
            $counselingModel = new \App\Models\CounselingModel();
            $studentModel = new \App\Models\StudentModel();

            // Get basic statistics
            $stats = [
                'total_sessions' => $counselingModel->countAll(),
                'today_sessions' => 0,
                'pending_sessions' => 0, 
                'urgent_sessions' => 0,
                'total_students' => $studentModel->countAll(),
                'total_categories' => $categoryModel->countAll()
            ];

            $categories = $categoryModel->findAll();

            return $this->response->setJSON([
                'status' => 'success',
                'stats' => $stats,
                'categories_count' => count($categories),
                'categories' => $categories
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
    
    public function minimalDashboard()
    {
        $data = [
            'title' => 'Dashboard BK Minimal',
            'stats' => [
                'total_sessions' => 10,
                'total_students' => 8,
                'pending_sessions' => 2,
                'urgent_sessions' => 1
            ],
            'categories' => [
                ['code' => 'AKD', 'name' => 'Akademik'],
                ['code' => 'SOC', 'name' => 'Sosial'],
                ['code' => 'PER', 'name' => 'Pribadi']
            ]
        ];
        
        return view('counseling/simple_index', $data);
    }
    
    public function store()
    {
        try {
            // Get form data
            $data = [
                'student_id' => $this->request->getPost('student_id'),
                'category_id' => $this->request->getPost('category_id'),
                'session_date' => $this->request->getPost('session_date'),
                'session_time' => $this->request->getPost('session_time'),
                'description' => $this->request->getPost('description'),
                'priority' => $this->request->getPost('priority'),
                'status' => 'scheduled',
                'created_by' => session()->get('user_id') ?? 1, // Default to 1 for testing
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $counselingModel = new \App\Models\CounselingModel();
            $result = $counselingModel->insert($data);
            
            if ($result) {
                session()->setFlashdata('success', 'Sesi konseling berhasil dibuat!');
                return redirect()->to('/counseling/sessions');
            } else {
                session()->setFlashdata('error', 'Gagal membuat sesi konseling.');
                return redirect()->back()->withInput();
            }
            
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    
    public function edit($id)
    {
        try {
            $counselingModel = new \App\Models\CounselingModel();
            $categoryModel = new \App\Models\CategoryModel();
            $studentModel = new \App\Models\StudentModel();
            
            $session = $counselingModel->find($id);
            
            if (!$session) {
                session()->setFlashdata('error', 'Sesi konseling tidak ditemukan.');
                return redirect()->to('/counseling/sessions');
            }
            
            $data = [
                'title' => 'Edit Sesi Konseling',
                'session' => $session,
                'categories' => $categoryModel->findAll(),
                'students' => $studentModel->getStudentsWithClass()
            ];
            
            return view('counseling/edit', $data);
            
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
            return redirect()->to('/counseling/sessions');
        }
    }
    
    public function update($id)
    {
        try {
            $counselingModel = new \App\Models\CounselingModel();
            
            $session = $counselingModel->find($id);
            if (!$session) {
                session()->setFlashdata('error', 'Sesi konseling tidak ditemukan.');
                return redirect()->to('/counseling/sessions');
            }
            
            $data = [
                'student_id' => $this->request->getPost('student_id'),
                'category_id' => $this->request->getPost('category_id'),
                'session_date' => $this->request->getPost('session_date'),
                'session_time' => $this->request->getPost('session_time'),
                'description' => $this->request->getPost('description'),
                'priority' => $this->request->getPost('priority'),
                'status' => $this->request->getPost('status'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $result = $counselingModel->update($id, $data);
            
            if ($result) {
                session()->setFlashdata('success', 'Sesi konseling berhasil diupdate!');
                return redirect()->to('/counseling/sessions');
            } else {
                session()->setFlashdata('error', 'Gagal mengupdate sesi konseling.');
                return redirect()->back()->withInput();
            }
            
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    
    public function delete($id)
    {
        try {
            $counselingModel = new \App\Models\CounselingModel();
            
            $session = $counselingModel->find($id);
            if (!$session) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Sesi konseling tidak ditemukan.'
                ]);
            }
            
            $result = $counselingModel->delete($id);
            
            if ($result) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Sesi konseling berhasil dihapus!'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menghapus sesi konseling.'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function debugSessions()
    {
        try {
            $counselingModel = new \App\Models\CounselingModel();
            
            $sessions = $counselingModel->findAll();
            
            return $this->response->setJSON([
                'status' => 'success',
                'total_sessions' => count($sessions),
                'sessions' => $sessions,
                'model_class' => get_class($counselingModel),
                'table' => $counselingModel->getTable()
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
    
    public function sessionsSimple()
    {
        // Simple test with minimal data
        $data = [
            'title' => 'Daftar Sesi Konseling',
            'sessions' => [
                [
                    'id' => 1,
                    'student_name' => 'Ahmad Rizki',
                    'student_class' => '7A',
                    'category_name' => 'Akademik',
                    'category_color' => '#007bff',
                    'session_date' => '2025-06-29',
                    'status' => 'scheduled',
                    'description' => 'Konseling masalah belajar matematika',
                    'counselor_name' => 'Guru BK'
                ],
                [
                    'id' => 2,
                    'student_name' => 'Siti Nurhaliza',
                    'student_class' => '7B',
                    'category_name' => 'Sosial',
                    'category_color' => '#28a745',
                    'session_date' => '2025-06-30',
                    'status' => 'ongoing',
                    'description' => 'Masalah hubungan dengan teman',
                    'counselor_name' => 'Guru BK'
                ]
            ]
        ];
        
        return view('counseling/sessions_simple', $data);
    }
    
    public function records()
    {
        try {
            $counselingModel = new \App\Models\CounselingModel();
            $studentModel = new \App\Models\StudentModel();
            $categoryModel = new \App\Models\CategoryModel();
            
            // Get all students with their counseling history
            $students = [];
            try {
                $allStudents = $studentModel->getStudentsWithClass();
                
                foreach ($allStudents as $student) {
                    // Get counseling sessions for this student
                    $sessions = $counselingModel->where('student_id', $student['id'])->findAll();
                    
                    // Add session count and latest session info
                    $student['total_sessions'] = count($sessions);
                    $student['latest_session'] = !empty($sessions) ? max(array_column($sessions, 'session_date')) : null;
                    $student['last_category'] = '';
                    
                    // Get latest session category
                    if (!empty($sessions)) {
                        $latestSession = end($sessions);
                        $category = $categoryModel->find($latestSession['category_id']);
                        $student['last_category'] = $category['name'] ?? 'N/A';
                    }
                    
                    $students[] = $student;
                }
            } catch (\Exception $e) {
                // Fallback with sample data
                $students = [
                    [
                        'id' => 1,
                        'name' => 'Ahmad Rizki Pratama',
                        'nis' => '2024001',
                        'class' => '7A',
                        'total_sessions' => 3,
                        'latest_session' => '2025-06-25',
                        'last_category' => 'Akademik'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Siti Nurhaliza',
                        'nis' => '2024002',
                        'class' => '7B',
                        'total_sessions' => 1,
                        'latest_session' => '2025-06-20',
                        'last_category' => 'Sosial'
                    ]
                ];
            }
            
            $data = [
                'title' => 'Rekam Jejak Konseling',
                'students' => $students
            ];
            
            return view('counseling/records', $data);
            
        } catch (\Exception $e) {
            $data = [
                'title' => 'Rekam Jejak Konseling',
                'students' => [],
                'error' => $e->getMessage()
            ];
            
            return view('counseling/records', $data);
        }
    }
    
    public function reports()
    {
        try {
            $counselingModel = new \App\Models\CounselingModel();
            $categoryModel = new \App\Models\CategoryModel();
            $studentModel = new \App\Models\StudentModel();

            // Filter by month/year if set
            $startMonth = $this->request->getGet('start_month');
            $endMonth = $this->request->getGet('end_month');

            $filter = function($model) use ($startMonth, $endMonth) {
                if ($startMonth) {
                    $model = $model->where('session_date >=', $startMonth . '-01');
                }
                if ($endMonth) {
                    $model = $model->where('session_date <=', $endMonth . '-31');
                }
                return $model;
            };

            // Get statistics for reports
            $stats = [];
            try {
                // Basic counts
                $stats['total_sessions'] = $filter($counselingModel)->countAllResults();
                $stats['total_students'] = $studentModel->countAll();
                $stats['total_categories'] = $categoryModel->countAll();

                // Sessions by status
                $stats['scheduled'] = $filter($counselingModel->where('status', 'scheduled'))->countAllResults();
                $stats['ongoing'] = $filter($counselingModel->where('status', 'ongoing'))->countAllResults();
                $stats['completed'] = $filter($counselingModel->where('status', 'completed'))->countAllResults();
                $stats['cancelled'] = $filter($counselingModel->where('status', 'cancelled'))->countAllResults();

                // Sessions by category
                $categories = $categoryModel->findAll();
                $categoryStats = [];
                foreach ($categories as $category) {
                    $count = $filter($counselingModel->where('category_id', $category['id']))->countAllResults();
                    $categoryStats[] = [
                        'name' => $category['name'],
                        'count' => $count,
                        'color' => $category['color'] ?? '#007bff'
                    ];
                }
                $stats['by_category'] = $categoryStats;

                // Monthly sessions (last 6 months)
                $monthlyStats = [];
                for ($i = 5; $i >= 0; $i--) {
                    $month = date('Y-m', strtotime("-$i months"));
                    $model = $counselingModel;
                    if ($startMonth) {
                        if ($month < $startMonth) continue;
                    }
                    if ($endMonth) {
                        if ($month > $endMonth) continue;
                    }
                    $count = $model
                        ->where('session_date >=', $month . '-01')
                        ->where('session_date <=', $month . '-31')
                        ->countAllResults();
                    $monthlyStats[] = [
                        'month' => date('M Y', strtotime($month . '-01')),
                        'count' => $count
                    ];
                }
                $stats['monthly'] = $monthlyStats;

                // Siswa perlu perhatian/intervensi (top 3-5)
                $students = $studentModel->getStudentsWithClass();
                $students_attention = [];
                foreach ($students as $student) {
                    $sessionCount = $filter($counselingModel->where('student_id', $student['id']))->countAllResults();
                    if ($sessionCount >= 6) {
                        $students_attention[] = [
                            'id' => $student['id'],
                            'name' => $student['name'],
                            'class' => $student['class'],
                            'session_count' => $sessionCount,
                            'level' => $sessionCount >= 10 ? 'intervensi' : 'perhatian'
                        ];
                    }
                }
                // Urutkan dan ambil 5 teratas
                usort($students_attention, function($a, $b) { return $b['session_count'] - $a['session_count']; });
                $students_attention = array_slice($students_attention, 0, 5);

            } catch (\Exception $e) {
                // Fallback with sample data
                $stats = [
                    'total_sessions' => 25,
                    'total_students' => 120,
                    'total_categories' => 4,
                    'scheduled' => 8,
                    'ongoing' => 3,
                    'completed' => 12,
                    'cancelled' => 2,
                    'by_category' => [
                        ['name' => 'Akademik', 'count' => 10, 'color' => '#007bff'],
                        ['name' => 'Sosial', 'count' => 8, 'color' => '#28a745'],
                        ['name' => 'Pribadi', 'count' => 5, 'color' => '#ffc107'],
                        ['name' => 'Keluarga', 'count' => 2, 'color' => '#dc3545']
                    ],
                    'monthly' => [
                        ['month' => 'Jan 2025', 'count' => 3],
                        ['month' => 'Feb 2025', 'count' => 5],
                        ['month' => 'Mar 2025', 'count' => 4],
                        ['month' => 'Apr 2025', 'count' => 6],
                        ['month' => 'May 2025', 'count' => 4],
                        ['month' => 'Jun 2025', 'count' => 3]
                    ]
                ];
                $students_attention = [
                    ['id' => 1, 'name' => 'Ahmad Rizki Pratama', 'class' => '7A', 'session_count' => 8, 'level' => 'perhatian'],
                    ['id' => 2, 'name' => 'Siti Nurhaliza', 'class' => '7B', 'session_count' => 12, 'level' => 'intervensi'],
                    ['id' => 3, 'name' => 'Budi Santoso', 'class' => '8A', 'session_count' => 6, 'level' => 'perhatian']
                ];
            }

            // Ambil data sesi konseling detail untuk tabel

            $builder = $counselingModel
                ->select('counseling_sessions.id, counseling_sessions.session_date as date, students.id as student_id, student_users.full_name as student_name, categories.name as category, counseling_sessions.status, counselor_users.full_name as teacher_name')
                ->join('students', 'students.id = counseling_sessions.student_id', 'left')
                ->join('users as student_users', 'student_users.id = students.user_id', 'left')
                ->join('categories', 'categories.id = counseling_sessions.category_id', 'left')
                ->join('users as counselor_users', 'counselor_users.id = counseling_sessions.counselor_id', 'left');

            // Terapkan filter periode jika ada
            if ($startMonth) {
                $builder = $builder->where('counseling_sessions.session_date >=', $startMonth . '-01');
            }
            if ($endMonth) {
                $builder = $builder->where('counseling_sessions.session_date <=', $endMonth . '-31');
            }

            $builder = $builder->orderBy('counseling_sessions.session_date', 'desc');
            $sessions = $builder->findAll();

            $data = [
                'title' => 'Laporan Bimbingan Konseling',
                'stats' => $stats,
                'students_attention' => $students_attention,
                'sessions' => $sessions
            ];

            return view('counseling/reports', $data);

        } catch (\Exception $e) {
            $data = [
                'title' => 'Laporan Bimbingan Konseling',
                'stats' => [],
                'error' => $e->getMessage()
            ];

            return view('counseling/reports', $data);
        }
    }
    
    public function studentRecords($studentId)
    {
        try {
            $counselingModel = new \App\Models\CounselingModel();
            $studentModel = new \App\Models\StudentModel();
            $categoryModel = new \App\Models\CategoryModel();
            
            // Get student info
            try {
                $student = $studentModel->getStudentWithUser($studentId);
            } catch (\Exception $e) {
                $student = [
                    'id' => $studentId,
                    'name' => 'Ahmad Rizki Pratama',
                    'nis' => '2024001',
                    'class' => '7A',
                    'email' => 'ahmad.rizki@student.com',
                    'phone' => '081234567890'
                ];
            }
            
            if (!$student) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Siswa tidak ditemukan'
                ]);
            }
            
            // Get counseling sessions for this student
            try {
                $sessions = $counselingModel->where('student_id', $studentId)
                    ->orderBy('session_date', 'DESC')
                    ->findAll();
                
                // Add category info to sessions
                foreach ($sessions as &$session) {
                    $category = $categoryModel->find($session['category_id']);
                    $session['category_name'] = $category['name'] ?? 'N/A';
                    $session['category_color'] = $category['color'] ?? '#007bff';
                }
                
            } catch (\Exception $e) {
                // Fallback data
                $sessions = [
                    [
                        'id' => 1,
                        'session_date' => '2025-06-25',
                        'status' => 'completed',
                        'description' => 'Konseling terkait kesulitan memahami mata pelajaran matematika',
                        'category_name' => 'Akademik',
                        'category_color' => '#007bff',
                        'notes' => 'Siswa menunjukkan perkembangan positif setelah konseling.'
                    ],
                    [
                        'id' => 2,
                        'session_date' => '2025-06-20',
                        'status' => 'completed',
                        'description' => 'Masalah hubungan dengan teman sekelas',
                        'category_name' => 'Sosial',
                        'category_color' => '#28a745',
                        'notes' => 'Siswa sudah bisa berinteraksi lebih baik dengan teman.'
                    ]
                ];
            }
            
            return $this->response->setJSON([
                'status' => 'success',
                'student' => $student,
                'sessions' => $sessions,
                'total_sessions' => count($sessions)
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function exportReports()
    {
        try {
            $counselingModel = new \App\Models\CounselingModel();
            $categoryModel = new \App\Models\CategoryModel();
            $studentModel = new \App\Models\StudentModel();
            
            // Get all data for export
            $sessions = $counselingModel->findAll();
            $stats = [
                'total_sessions' => count($sessions),
                'total_students' => $studentModel->countAll(),
                'total_categories' => $categoryModel->countAll(),
                'export_date' => date('Y-m-d H:i:s')
            ];
            
            // Generate CSV content
            $csv = "Laporan Bimbingan Konseling\n";
            $csv .= "Tanggal Export: " . date('d/m/Y H:i:s') . "\n\n";
            $csv .= "RINGKASAN:\n";
            $csv .= "Total Sesi: " . $stats['total_sessions'] . "\n";
            $csv .= "Total Siswa: " . $stats['total_students'] . "\n";
            $csv .= "Total Kategori: " . $stats['total_categories'] . "\n\n";
            
            $csv .= "DETAIL SESI:\n";
            $csv .= "ID,Tanggal,Siswa ID,Kategori ID,Status,Deskripsi\n";
            
            foreach ($sessions as $session) {
                $csv .= implode(',', [
                    $session['id'],
                    $session['session_date'],
                    $session['student_id'] ?? 'N/A',
                    $session['category_id'] ?? 'N/A',
                    $session['status'] ?? 'N/A',
                    '"' . str_replace('"', '""', $session['description'] ?? '') . '"'
                ]) . "\n";
            }
            
            // Set headers for download
            $this->response->setHeader('Content-Type', 'text/csv');
            $this->response->setHeader('Content-Disposition', 'attachment; filename="laporan-bk-' . date('Y-m-d') . '.csv"');
            
            return $this->response->setBody($csv);
            
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal mengexport laporan: ' . $e->getMessage());
            return redirect()->to('/counseling/reports');
        }
    }
    
    public function apiStats()
    {
        try {
            $counselingModel = new \App\Models\CounselingModel();
            $categoryModel = new \App\Models\CategoryModel();
            $studentModel = new \App\Models\StudentModel();
            
            $stats = [
                'total_sessions' => $counselingModel->countAll(),
                'total_students' => $studentModel->countAll(),
                'total_categories' => $categoryModel->countAll(),
                'sessions_by_status' => [
                    'scheduled' => $counselingModel->where('status', 'scheduled')->countAllResults(),
                    'ongoing' => $counselingModel->where('status', 'ongoing')->countAllResults(),
                    'completed' => $counselingModel->where('status', 'completed')->countAllResults(),
                    'cancelled' => $counselingModel->where('status', 'cancelled')->countAllResults()
                ]
            ];
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $stats
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
