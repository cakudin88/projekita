<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;
use Config\Services;

class DashboardController extends BaseController
{
    /**
     * Menampilkan halaman dashboard utama dengan statistik pengguna.
     * Versi ini dioptimalkan dengan caching.
     */
    public function index()
    {
        try {
            $userRole = session()->get('role_name');
            $userId = session()->get('user_id');
            
            // Route ke dashboard sesuai role
            switch ($userRole) {
                case 'super_admin':
                    return $this->superAdminDashboard();
                case 'guru_bk':
                    return $this->guruBKDashboard();
                case 'guru_mapel':
                    return $this->guruMapelDashboard();
                case 'walas':
                    return $this->walasDashboard();
                case 'orang_tua':
                    return $this->orangTuaDashboard();
                case 'murid':
                    return $this->muridDashboard();
                default:
                    return $this->defaultDashboard();
            }
        } catch (\Exception $e) {
            log_message('error', 'Dashboard Error: ' . $e->getMessage());
            $errorData = [
                'title' => 'Dashboard Error',
                'stats' => [
                    'total_roles' => 0,
                    'total_murid' => 0,
                    'guru_count' => 0,
                    'active_users' => 0,
                ]
            ];
            return view('dashboard/optimized', $errorData);
        }
    }

    /**
     * Menampilkan halaman profil dari pengguna yang sedang login.
     */
    public function profile()
    {
        try {
            $userModel = new UserModel();
            $userId = session()->get('user_id');

            if (!$userId) {
                return redirect()->to('/login')->with('error', 'Sesi tidak valid. Silakan login kembali.');
            }

            $user = $userModel
                ->select('users.*, roles.name as role_name, roles.description as role_description')
                ->join('roles', 'roles.id = users.role_id', 'left')
                ->where('users.id', $userId)
                ->first();

            if (!$user) {
                return redirect()->to('/login')->with('error', 'User tidak ditemukan atau belum login.');
            }

            $data = [
                'title' => 'Profile',
                'user' => $user
            ];

            return view('dashboard/profile', $data);

        } catch (\Throwable $e) {
            log_message('error', '[DashboardController] ' . $e->getMessage());
            return "Terjadi error pada halaman profile. Silakan hubungi administrator.";
        }
    }
    
    /**
     * Menangani logika untuk update informasi profil.
     */
    public function updateProfile()
    {
        $userId = session()->get('user_id');
        $userModel = new UserModel();

        // Ambil data user lama
        $oldUser = $userModel->find($userId);
        $inputUsername = $this->request->getPost('username');
        $inputEmail = $this->request->getPost('email');

        // Gunakan trim dan strtolower untuk membandingkan agar lebih robust
        $isUsernameChanged = (trim(strtolower($inputUsername)) !== trim(strtolower($oldUser['username'])));
        $isEmailChanged = (trim(strtolower($inputEmail)) !== trim(strtolower($oldUser['email'])));

        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'username'  => $isUsernameChanged
                ? "required|min_length[3]|max_length[100]|is_unique[users.username,id,{$userId}]"
                : 'required|min_length[3]|max_length[100]',
            'email'     => $isEmailChanged
                ? "required|valid_email|is_unique[users.email,id,{$userId}]"
                : 'required|valid_email',
            'phone'     => 'permit_empty|max_length[20]',
            'address'   => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }


        // Hanya update field yang memang berubah
        $data = [];
        $newFullName = $this->request->getPost('full_name');
        $newUsername = $this->request->getPost('username');
        $newEmail    = $this->request->getPost('email');
        $newPhone    = $this->request->getPost('phone');
        $newAddress  = $this->request->getPost('address');

        if ($newFullName !== $oldUser['full_name']) {
            $data['full_name'] = $newFullName;
        }
        if ($isUsernameChanged) {
            $data['username'] = $newUsername;
        }
        if ($isEmailChanged) {
            $data['email'] = $newEmail;
        }
        if ($newPhone !== $oldUser['phone']) {
            $data['phone'] = $newPhone;
        }
        if ($newAddress !== $oldUser['address']) {
            $data['address'] = $newAddress;
        }

        // Jika tidak ada perubahan, langsung redirect sukses
        if (empty($data)) {
            return redirect()->to('/profile')->with('success', 'Tidak ada perubahan data.');
        }

        if ($userModel->update($userId, $data)) {
            // Ambil data user terbaru dari database
            $updatedUser = $userModel->find($userId);
            session()->set('full_name', $updatedUser['full_name']);
            session()->set('username', $updatedUser['username']);
            if (!empty($updatedUser['avatar'])) {
                session()->set('avatar', $updatedUser['avatar']);
            }
            return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui!');
        } else {
            // Ambil error validasi model jika ada
            $errors = $userModel->errors();
            if (!empty($errors)) {
                return redirect()->back()->withInput()->with('errors', $errors);
            } else {
                // Log error DB jika ada (debug only)
                if (function_exists('log_message')) {
                    log_message('error', 'Profile update failed for user ' . $userId . ': ' . print_r($data, true));
                }
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan pada server, gagal memperbarui profil.');
            }
        }
    }

    /**
     * Menangani logika untuk ganti password.
     */
    public function changePassword()
    {
        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/profile')->with('error_password', 'Gagal: ' . implode(', ', $this->validator->getErrors()));
        }

        if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->to('/profile')->with('error_password', 'Password saat ini salah!');
        }

        $data = [
            'password' => $this->request->getPost('new_password'),
        ];

        if ($userModel->update($userId, $data)) {
            return redirect()->to('/profile')->with('success', 'Password berhasil diubah!');
        } else {
            return redirect()->to('/profile')->with('error_password', 'Gagal mengubah password.');
        }
    }

    /**
     * Menangani logika untuk upload avatar/foto profil.
     */
    public function uploadAvatar()
    {
        $userId = session()->get('user_id');
        $userModel = new UserModel();

        $validationRule = [
            'avatar' => [
                'label' => 'Image File',
                'rules' => 'uploaded[avatar]'
                    . '|is_image[avatar]'
                    . '|mime_in[avatar,image/jpg,image/jpeg,image/png]'
                    . '|max_size[avatar,2048]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->to('/profile')->with('error_avatar', $this->validator->getErrors()['avatar']);
        }

        $img = $this->request->getFile('avatar');

        if ($img->isValid() && !$img->hasMoved()) {
            $oldAvatar = $userModel->find($userId)['avatar'];
            if ($oldAvatar && file_exists(FCPATH . 'uploads/avatars/' . $oldAvatar)) {
                unlink(FCPATH . 'uploads/avatars/' . $oldAvatar);
            }

            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/avatars', $newName);

            $userModel->update($userId, ['avatar' => $newName]);
            session()->set('avatar', $newName);

            return redirect()->to('/profile')->with('success', 'Foto profil berhasil diubah!');
        }

        return redirect()->to('/profile')->with('error_avatar', 'Gagal mengunggah foto.');
    }

    /**
     * Membersihkan cache dashboard.
     */
    public function clearCache()
    {
        $cache = Services::cache();
        $cacheKey = 'dashboard_stats_' . session()->get('user_id');
        $cache->delete($cacheKey);
        
        return redirect()->to('/dashboard')->with('success', 'Cache dashboard berhasil dibersihkan!');
    }

    /**
     * Versi dashboard ultra-cepat.
     */
    public function lightning()
    {
        try {
            $cache = Services::cache();
            $cacheKey = 'lightning_stats_'.session()->get('user_id');
            $data = $cache->get($cacheKey);
            
            if ($data === null) {
                $db = \Config\Database::connect();
                $data = [
                    'title' => 'Dashboard',
                    'stats' => [
                        'total_roles'  => $db->query("SELECT COUNT(*) as count FROM roles")->getRow()->count,
                        'total_murid'  => $db->query("SELECT COUNT(*) as count FROM users u INNER JOIN roles r ON r.id = u.role_id WHERE r.name = 'murid'")->getRow()->count,
                        'guru_count'   => $db->query("SELECT COUNT(*) as count FROM users u INNER JOIN roles r ON r.id = u.role_id WHERE r.name IN ('guru_bk', 'guru_mapel')")->getRow()->count,
                        'active_users' => $db->query("SELECT COUNT(*) as count FROM users WHERE is_active = 1")->getRow()->count,
                    ]
                ];
                $cache->save($cacheKey, $data, 600);
            }

            return view('dashboard/lightning', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Lightning Dashboard Error: ' . $e->getMessage());
            $data = [
                'title' => 'Dashboard',
                'stats' => array_fill_keys(['total_roles', 'total_murid', 'guru_count', 'active_users'], 0)
            ];
            return view('dashboard/lightning', $data);
        }
    }

    /**
     * Versi dashboard untuk debugging.
     */
    public function debug()
    {
        try {
            $data = [
                'title' => 'Dashboard Debug',
                'stats' => [
                    'total_roles' => 'Testing...',
                    'total_murid' => 'Testing...',
                    'guru_count' => 'Testing...',
                    'active_users' => 'Testing...',
                ]
            ];
            
            try {
                $data['stats']['total_roles'] = (new RoleModel())->countAllResults(false);
            } catch (\Exception $e) {
                $data['stats']['total_roles'] = 'Error: ' . $e->getMessage();
            }
            
            try {
                $data['stats']['active_users'] = (new UserModel())->where('is_active', 1)->countAllResults(false);
            } catch (\Exception $e) {
                $data['stats']['active_users'] = 'Error: ' . $e->getMessage();
            }
            
            try {
                $data['stats']['total_murid'] = (new UserModel())
                    ->join('roles r', 'r.id = users.role_id')
                    ->where('r.name', 'murid')
                    ->countAllResults(false);
            } catch (\Exception $e) {
                $data['stats']['total_murid'] = 'Error: ' . $e->getMessage();
            }
            
            try {
                $data['stats']['guru_count'] = (new UserModel())
                    ->join('roles rg', 'rg.id = users.role_id')
                    ->whereIn('rg.name', ['guru_bk', 'guru_mapel'])
                    ->countAllResults(false);
            } catch (\Exception $e) {
                $data['stats']['guru_count'] = 'Error: ' . $e->getMessage();
            }

            return view('dashboard/debug', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Debug Dashboard Error: ' . $e->getMessage());
            $data = [
                'title' => 'Dashboard Debug Error',
                'stats' => [
                    'error' => $e->getMessage(),
                    'total_roles' => 'Failed',
                    'total_murid' => 'Failed',
                    'guru_count' => 'Failed',
                    'active_users' => 'Failed',
                ]
            ];
            return view('dashboard/debug', $data);
        }
    }
    
    /**
     * Dashboard Super Admin - Kelola seluruh sistem
     */
    private function superAdminDashboard()
    {
        $db = \Config\Database::connect();
        
        $data = [
            'title' => 'Dashboard Super Admin',
            'stats' => [
                'total_users' => $db->query("SELECT COUNT(*) as count FROM users")->getRow()->count,
                'total_roles' => $db->query("SELECT COUNT(*) as count FROM roles")->getRow()->count,
                'active_users' => $db->query("SELECT COUNT(*) as count FROM users WHERE is_active = 1")->getRow()->count,
                'total_guru' => $db->query("SELECT COUNT(*) as count FROM users u INNER JOIN roles r ON r.id = u.role_id WHERE r.name IN ('guru_bk', 'guru_mapel', 'walas')")->getRow()->count,
                'total_murid' => $db->query("SELECT COUNT(*) as count FROM users u INNER JOIN roles r ON r.id = u.role_id WHERE r.name = 'murid'")->getRow()->count,
                'total_orangtua' => $db->query("SELECT COUNT(*) as count FROM users u INNER JOIN roles r ON r.id = u.role_id WHERE r.name = 'orang_tua'")->getRow()->count,
                'counseling_requests' => $db->query("SELECT COUNT(*) as count FROM counseling_requests")->getRow()->count,
                'pending_requests' => $db->query("SELECT COUNT(*) as count FROM counseling_requests WHERE status = 'pending'")->getRow()->count,
            ],
            'recent_activities' => $this->getRecentActivities(),
            'user_growth' => $this->getUserGrowthData()
        ];
        
        return view('dashboard/super_admin', $data);
    }
    
    /**
     * Dashboard Guru BK - Fokus konseling dan bimbingan
     */
    private function guruBKDashboard()
    {
        $db = \Config\Database::connect();
        $userId = session()->get('user_id');
        
        try {
            $data = [
                'title' => 'Dashboard Guru BK',
                'stats' => [
                    'pending_requests' => $db->query("SELECT COUNT(*) as count FROM counseling_requests WHERE status = 'pending'")->getRow()->count,
                    'scheduled_sessions' => $db->query("SELECT COUNT(*) as count FROM counseling_requests WHERE status = 'scheduled' AND counseling_date >= CURDATE()")->getRow()->count,
                    'completed_sessions' => $db->query("SELECT COUNT(*) as count FROM counseling_requests WHERE status = 'completed' AND MONTH(counseling_date) = MONTH(NOW())")->getRow()->count,
                    'total_students' => $db->query("SELECT COUNT(*) as count FROM users u INNER JOIN roles r ON r.id = u.role_id WHERE r.name = 'murid'")->getRow()->count,
                    'incident_reports' => $this->safeCount("SELECT COUNT(*) as count FROM incident_reports WHERE status = 'pending'"),
                    'chat_messages' => $this->safeCount("SELECT COUNT(*) as count FROM chat_messages WHERE receiver_id = {$userId}"),
                ],
                'today_schedule' => $this->getTodaySchedule(),
                'recent_requests' => $this->getRecentCounselingRequests(),
                'student_summary' => $this->getStudentSummary()
            ];
        } catch (\Exception $e) {
            log_message('error', 'Dashboard error: ' . $e->getMessage());
            $data = [
                'title' => 'Dashboard Guru BK',
                'stats' => [
                    'pending_requests' => 0,
                    'scheduled_sessions' => 0,
                    'completed_sessions' => 0,
                    'total_students' => 0,
                    'incident_reports' => 0,
                    'chat_messages' => 0,
                ],
                'today_schedule' => [],
                'recent_requests' => [],
                'student_summary' => []
            ];
        }
        
        return view('dashboard/guru_bk', $data);
    }
    
    /**
     * Dashboard Guru Mapel - Fokus pembelajaran dan nilai
     */
    private function guruMapelDashboard()
    {
        $db = \Config\Database::connect();
        $userId = session()->get('user_id');
        
        $data = [
            'title' => 'Dashboard Guru Mapel',
            'stats' => [
                'total_classes' => 8, // Dummy data - sesuaikan dengan sistem kelas
                'total_students' => $db->query("SELECT COUNT(*) as count FROM users u INNER JOIN roles r ON r.id = u.role_id WHERE r.name = 'murid'")->getRow()->count,
                'assignments_pending' => 12, // Dummy data - sesuaikan dengan sistem tugas
                'avg_grade' => 82.5, // Dummy data - sesuaikan dengan sistem nilai
                'upcoming_tests' => 3, // Dummy data
                'completed_lessons' => 24, // Dummy data
            ],
            'class_performance' => $this->getClassPerformance(),
            'upcoming_schedule' => $this->getTeacherSchedule(),
            'student_attendance' => $this->getStudentAttendance()
        ];
        
        return view('dashboard/guru_mapel', $data);
    }
    
    /**
     * Dashboard Walas - Fokus kelas dan siswa bimbingan
     */
    private function walasDashboard()
    {
        $db = \Config\Database::connect();
        $userId = session()->get('user_id');
        
        $data = [
            'title' => 'Dashboard Wali Kelas',
            'stats' => [
                'class_students' => 32, // Dummy data - sesuaikan dengan sistem kelas
                'present_today' => 28, // Dummy data
                'absent_today' => 4, // Dummy data
                'counseling_needed' => $db->query("SELECT COUNT(*) as count FROM counseling_requests WHERE status = 'pending'")->getRow()->count,
                'parent_meetings' => 2, // Dummy data
                'academic_alerts' => 5, // Dummy data
            ],
            'class_summary' => $this->getClassSummary(),
            'attendance_report' => $this->getAttendanceReport(),
            'student_issues' => $this->getStudentIssues()
        ];
        
        return view('dashboard/walas', $data);
    }
    
    /**
     * Dashboard Orang Tua - Fokus perkembangan anak
     */
    private function orangTuaDashboard()
    {
        $db = \Config\Database::connect();
        $userId = session()->get('user_id');
        
        $data = [
            'title' => 'Dashboard Orang Tua',
            'stats' => [
                'child_attendance' => 95, // Dummy data - persentase kehadiran
                'avg_grade' => 85.2, // Dummy data
                'homework_completed' => 8, // Dummy data
                'homework_pending' => 2, // Dummy data
                'teacher_notes' => 3, // Dummy data
                'counseling_sessions' => 1, // Dummy data
            ],
            'child_progress' => $this->getChildProgress(),
            'upcoming_events' => $this->getUpcomingEvents(),
            'teacher_communications' => $this->getTeacherCommunications()
        ];
        
        return view('dashboard/orang_tua', $data);
    }
    
    /**
     * Dashboard Murid - Fokus pembelajaran dan pengembangan diri
     */
    private function muridDashboard()
    {
        try {
            $db = \Config\Database::connect();
            $userId = session()->get('user_id');
            
            // Get counseling sessions count with error handling
            $counselingSessions = 0;
            try {
                $counselingSessions = $db->query("SELECT COUNT(*) as count FROM counseling_requests WHERE student_id = ?", [$userId])->getRow()->count;
            } catch (\Exception $e) {
                log_message('error', 'Error getting counseling sessions: ' . $e->getMessage());
            }
            
            $data = [
                'title' => 'Dashboard Murid',
                'stats' => [
                    'attendance_rate' => 96, // Dummy data
                    'avg_grade' => 82.5, // Dummy data
                    'assignments_due' => 3, // Dummy data
                    'completed_assignments' => 15, // Dummy data
                    'counseling_sessions' => $counselingSessions,
                    'achievements' => 5, // Dummy data
                ],
                'schedule_today' => $this->getTodayStudentSchedule(),
                'recent_grades' => $this->getRecentGrades(),
                'upcoming_assignments' => $this->getUpcomingAssignments(),
                'counseling_status' => $this->getCounselingStatus($userId)
            ];
            
            return view('dashboard/murid', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Murid Dashboard Error: ' . $e->getMessage());
            
            // Fallback data jika terjadi error
            $data = [
                'title' => 'Dashboard Murid',
                'stats' => [
                    'attendance_rate' => 96,
                    'avg_grade' => 82.5,
                    'assignments_due' => 3,
                    'completed_assignments' => 15,
                    'counseling_sessions' => 0,
                    'achievements' => 5,
                ],
                'schedule_today' => [],
                'recent_grades' => [],
                'upcoming_assignments' => [],
                'counseling_status' => ['status' => 'none', 'message' => 'Belum ada permintaan konseling']
            ];
            
            return view('dashboard/murid', $data);
        }
    }
    
    /**
     * Default dashboard fallback
     */
    private function defaultDashboard()
    {
        $data = [
            'title' => 'Dashboard',
            'message' => 'Role tidak dikenali. Silakan hubungi administrator.'
        ];
        
        return view('dashboard/default', $data);
    }
    
    // Helper methods untuk mendapatkan data
    private function getRecentActivities()
    {
        return [
            ['activity' => 'User baru terdaftar', 'time' => '5 menit lalu', 'type' => 'user'],
            ['activity' => 'Permintaan konseling baru', 'time' => '15 menit lalu', 'type' => 'counseling'],
            ['activity' => 'Laporan insiden masuk', 'time' => '1 jam lalu', 'type' => 'incident'],
        ];
    }
    
    private function getUserGrowthData()
    {
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            'data' => [120, 135, 142, 158, 165, 172]
        ];
    }
    
    private function getTodaySchedule()
    {
        return [
            ['time' => '08:00', 'student' => 'Ahmad Rizki', 'topic' => 'Konsultasi Akademik'],
            ['time' => '10:00', 'student' => 'Siti Nurhaliza', 'topic' => 'Bimbingan Karir'],
            ['time' => '13:00', 'student' => 'Budi Santoso', 'topic' => 'Masalah Sosial'],
        ];
    }
    
    private function getRecentCounselingRequests()
    {
        try {
            $db = \Config\Database::connect();
            return $db->query("
                SELECT cr.*, u.full_name 
                FROM counseling_requests cr 
                JOIN users u ON u.id = cr.student_id 
                ORDER BY cr.created_at DESC 
                LIMIT 5
            ")->getResultArray();
        } catch (\Exception $e) {
            log_message('error', 'Error getting recent counseling requests: ' . $e->getMessage());
            return [];
        }
    }
    
    private function getStudentSummary()
    {
        return [
            'total' => 145,
            'needs_attention' => 12,
            'excellent' => 78,
            'good' => 55
        ];
    }
    
    private function getClassPerformance()
    {
        return [
            ['class' => '7A', 'avg_grade' => 85.2, 'attendance' => 95],
            ['class' => '7B', 'avg_grade' => 82.8, 'attendance' => 92],
            ['class' => '8A', 'avg_grade' => 87.1, 'attendance' => 96],
        ];
    }
    
    private function getTeacherSchedule()
    {
        return [
            ['time' => '07:30', 'class' => '7A', 'subject' => 'Matematika'],
            ['time' => '09:00', 'class' => '8B', 'subject' => 'Matematika'],
            ['time' => '10:30', 'class' => '7C', 'subject' => 'Matematika'],
        ];
    }
    
    private function getStudentAttendance()
    {
        return [
            'present' => 142,
            'absent' => 8,
            'late' => 5,
            'sick' => 3
        ];
    }
    
    private function getClassSummary()
    {
        return [
            'class_name' => '7A',
            'total_students' => 32,
            'male' => 16,
            'female' => 16,
            'avg_grade' => 84.5
        ];
    }
    
    private function getAttendanceReport()
    {
        return [
            'today' => ['present' => 28, 'absent' => 4],
            'this_week' => ['avg_attendance' => 92.5],
            'this_month' => ['avg_attendance' => 94.2]
        ];
    }
    
    private function getStudentIssues()
    {
        return [
            ['student' => 'Ahmad Rizki', 'issue' => 'Sering terlambat', 'severity' => 'medium'],
            ['student' => 'Siti Aisyah', 'issue' => 'Nilai menurun', 'severity' => 'high'],
            ['student' => 'Budi Santoso', 'issue' => 'Konflik dengan teman', 'severity' => 'medium'],
        ];
    }
    
    private function getChildProgress()
    {
        return [
            'academic' => ['current' => 85.2, 'previous' => 82.1, 'trend' => 'up'],
            'behavior' => ['current' => 4.2, 'previous' => 4.0, 'trend' => 'up'],
            'attendance' => ['current' => 95, 'previous' => 92, 'trend' => 'up']
        ];
    }
    
    private function getUpcomingEvents()
    {
        return [
            ['date' => '2025-01-10', 'event' => 'Rapat Wali Murid'],
            ['date' => '2025-01-15', 'event' => 'Ujian Tengah Semester'],
            ['date' => '2025-01-20', 'event' => 'Penerimaan Rapor'],
        ];
    }
    
    private function getTeacherCommunications()
    {
        return [
            ['from' => 'Ibu Sari (Wali Kelas)', 'message' => 'Ahmad menunjukkan perkembangan yang baik...', 'date' => '2025-01-05'],
            ['from' => 'Pak Budi (Guru Matematika)', 'message' => 'Perlu bimbingan tambahan untuk materi...', 'date' => '2025-01-03'],
        ];
    }
    
    private function getTodayStudentSchedule()
    {
        return [
            ['time' => '07:30', 'subject' => 'Matematika', 'teacher' => 'Pak Budi', 'room' => '7A'],
            ['time' => '09:00', 'subject' => 'Bahasa Indonesia', 'teacher' => 'Ibu Sari', 'room' => '7A'],
            ['time' => '10:30', 'subject' => 'IPA', 'teacher' => 'Pak Ahmad', 'room' => 'Lab IPA'],
        ];
    }
    
    private function getRecentGrades()
    {
        return [
            ['subject' => 'Matematika', 'grade' => 85, 'date' => '2025-01-05'],
            ['subject' => 'Bahasa Indonesia', 'grade' => 88, 'date' => '2025-01-04'],
            ['subject' => 'IPA', 'grade' => 82, 'date' => '2025-01-03'],
        ];
    }
    
    private function getUpcomingAssignments()
    {
        return [
            ['subject' => 'Matematika', 'title' => 'Tugas Aljabar', 'due_date' => '2025-01-08'],
            ['subject' => 'Bahasa Indonesia', 'title' => 'Esai Lingkungan', 'due_date' => '2025-01-10'],
            ['subject' => 'IPA', 'title' => 'Laporan Praktikum', 'due_date' => '2025-01-12'],
        ];
    }
    
    private function getCounselingStatus($userId)
    {
        try {
            $db = \Config\Database::connect();
            $result = $db->query("SELECT * FROM counseling_requests WHERE student_id = ? ORDER BY created_at DESC LIMIT 1", [$userId])->getRowArray();
            
            if ($result) {
                // Add formatted date if available
                if (!empty($result['counseling_date'])) {
                    $result['formatted_date'] = date('d M Y H:i', strtotime($result['counseling_date']));
                }
                return $result;
            } else {
                return ['status' => 'none', 'message' => 'Belum ada permintaan konseling'];
            }
        } catch (\Exception $e) {
            log_message('error', 'Error getting counseling status: ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Error mengambil status konseling'];
        }
    }
    
    /**
     * Safe count method to handle potential database errors
     */
    private function safeCount($sql)
    {
        try {
            $db = \Config\Database::connect();
            $result = $db->query($sql)->getRow();
            return $result ? $result->count : 0;
        } catch (\Exception $e) {
            log_message('error', 'Safe count error: ' . $e->getMessage());
            return 0;
        }
    }
}