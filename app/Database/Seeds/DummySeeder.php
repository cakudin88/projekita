<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DummySeeder extends Seeder
{
    public function run()
    {
        // Clear existing data (optional - comment out if you want to keep existing data)
        // $this->db->table('counseling_requests')->truncate();
        // $this->db->table('counseling_sessions')->truncate();
        // $this->db->table('students')->truncate();
        // $this->db->table('teachers')->truncate();
        // $this->db->table('categories')->truncate();
        // $this->db->table('users')->where('id >', 1)->delete(); // Keep admin

        // 1. Roles (if not exists)
        $roleData = [
            ['name' => 'super_admin', 'description' => 'Super Administrator', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'kepala_sekolah', 'description' => 'Kepala Sekolah', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'guru_bk', 'description' => 'Guru Bimbingan Konseling', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'guru_mapel', 'description' => 'Guru Mata Pelajaran', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'wali_kelas', 'description' => 'Wali Kelas', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'wali_murid', 'description' => 'Wali Murid/Orang Tua', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'murid', 'description' => 'Siswa/Murid', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        foreach ($roleData as $role) {
            $exists = $this->db->table('roles')->where('name', $role['name'])->get()->getRow();
            if (!$exists) {
                $this->db->table('roles')->insert($role);
            }
        }

        // Get role IDs
        $roles = $this->db->table('roles')->get()->getResultArray();
        $roleMap = [];
        foreach ($roles as $role) {
            $roleMap[$role['name']] = $role['id'];
        }

        // 2. Users - Admin, Guru BK, Wali Kelas, dan beberapa siswa
        $userData = [
            [
                'username' => 'admin',
                'email' => 'admin@smpn1pasuruan.sch.id',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
                'full_name' => 'Super Administrator',
                'role_id' => $roleMap['super_admin'],
                'is_active' => 1,
                'phone' => '081234567890',
                'address' => 'Jl. Pendidikan No. 1, Pasuruan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'kepala.sekolah',
                'email' => 'kepala@smpn1pasuruan.sch.id',
                'password' => password_hash('kepala123', PASSWORD_BCRYPT),
                'full_name' => 'Drs. Bambang Sutrisno, M.Pd',
                'role_id' => $roleMap['kepala_sekolah'],
                'is_active' => 1,
                'phone' => '081234567891',
                'address' => 'Jl. Pendidikan No. 2, Pasuruan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'guru.bk',
                'email' => 'sari.indrawati@smpn1pasuruan.sch.id',
                'password' => password_hash('gurubk123', PASSWORD_BCRYPT),
                'full_name' => 'Dr. Sari Indrawati, M.Pd',
                'role_id' => $roleMap['guru_bk'],
                'is_active' => 1,
                'phone' => '081234567892',
                'address' => 'Jl. Mawar No. 15, Pasuruan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'wali.7a',
                'email' => 'budi.santoso@smpn1pasuruan.sch.id',
                'password' => password_hash('wali123', PASSWORD_BCRYPT),
                'full_name' => 'Budi Santoso, S.Pd',
                'role_id' => $roleMap['wali_kelas'],
                'is_active' => 1,
                'phone' => '081234567893',
                'address' => 'Jl. Melati No. 20, Pasuruan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert users with duplicate check
        foreach ($userData as $user) {
            $exists = $this->db->table('users')
                ->where('username', $user['username'])
                ->orWhere('email', $user['email'])
                ->get()
                ->getRow();
            if (!$exists) {
                $this->db->table('users')->insert($user);
            }
        }

        // 3. Categories untuk konseling
        $categoryData = [
            ['name' => 'Akademik', 'description' => 'Masalah prestasi belajar, kesulitan memahami pelajaran, motivasi belajar', 'color' => '#2563eb', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Sosial', 'description' => 'Hubungan dengan teman, interaksi sosial, konflik antar siswa', 'color' => '#16a34a', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Pribadi', 'description' => 'Masalah kepribadian, emosi, pengembangan diri, kepercayaan diri', 'color' => '#dc2626', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Keluarga', 'description' => 'Hubungan keluarga, kondisi rumah, ekonomi keluarga', 'color' => '#7c3aed', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Karir', 'description' => 'Pemilihan jurusan, perencanaan masa depan, bakat dan minat', 'color' => '#ea580c', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Perilaku', 'description' => 'Kedisiplinan, kenakalan, penyesuaian tingkah laku', 'color' => '#d97706', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Kesehatan Mental', 'description' => 'Kecemasan, depresi, stress, gangguan psikologis', 'color' => '#059669', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Bullying', 'description' => 'Kasus perundungan, intimidasi, kekerasan verbal/fisik', 'color' => '#b91c1c', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        foreach ($categoryData as $category) {
            $exists = $this->db->table('categories')->where('name', $category['name'])->get()->getRow();
            if (!$exists) {
                $this->db->table('categories')->insert($category);
            }
        }

        // 4. Students - Buat user dulu, lalu student
        $studentUsers = [
            ['username' => 'ahmad.rizki', 'name' => 'Ahmad Rizki Pratama', 'nis' => '2024001', 'class' => '7A', 'grade' => '7', 'email' => 'ahmad.rizki@student.smpn1pasuruan.sch.id'],
            ['username' => 'siti.nurhaliza', 'name' => 'Siti Nurhaliza', 'nis' => '2024002', 'class' => '7A', 'grade' => '7', 'email' => 'siti.nurhaliza@student.smpn1pasuruan.sch.id'],
            ['username' => 'budi.santoso', 'name' => 'Budi Santoso', 'nis' => '2024003', 'class' => '7B', 'grade' => '7', 'email' => 'budi.santoso@student.smpn1pasuruan.sch.id'],
            ['username' => 'dewi.kartika', 'name' => 'Dewi Kartika Sari', 'nis' => '2024004', 'class' => '7C', 'grade' => '7', 'email' => 'dewi.kartika@student.smpn1pasuruan.sch.id'],
            ['username' => 'eko.prasetyo', 'name' => 'Eko Prasetyo', 'nis' => '2024005', 'class' => '8A', 'grade' => '8', 'email' => 'eko.prasetyo@student.smpn1pasuruan.sch.id'],
            ['username' => 'fatima.zahra', 'name' => 'Fatima Zahra', 'nis' => '2024006', 'class' => '8B', 'grade' => '8', 'email' => 'fatima.zahra@student.smpn1pasuruan.sch.id'],
            ['username' => 'galih.prakoso', 'name' => 'Galih Prakoso', 'nis' => '2024007', 'class' => '9A', 'grade' => '9', 'email' => 'galih.prakoso@student.smpn1pasuruan.sch.id'],
            ['username' => 'hilda.permata', 'name' => 'Hilda Permata', 'nis' => '2024008', 'class' => '9B', 'grade' => '9', 'email' => 'hilda.permata@student.smpn1pasuruan.sch.id'],
        ];

        foreach ($studentUsers as $student) {
            // Create user first
            $exists = $this->db->table('users')->where('username', $student['username'])->get()->getRow();
            if (!$exists) {
                $userData = [
                    'username' => $student['username'],
                    'email' => $student['email'],
                    'password' => password_hash('student123', PASSWORD_BCRYPT),
                    'full_name' => $student['name'],
                    'role_id' => $roleMap['murid'],
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->db->table('users')->insert($userData);
                $userId = $this->db->insertID();

                // Create student record
                $studentData = [
                    'user_id' => $userId,
                    'nis' => $student['nis'],
                    'name' => $student['name'],
                    'class' => $student['class'],
                    'grade' => $student['grade'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->db->table('students')->insert($studentData);
            }
        }

        // 5. Teachers - buat user untuk guru yang belum punya akun
        $guruBKUser = $this->db->table('users')->where('username', 'guru.bk')->get()->getRow();
        $waliKelasUser = $this->db->table('users')->where('username', 'wali.7a')->get()->getRow();
        
        // Buat user untuk guru lain yang belum ada
        $additionalTeacherUsers = [
            [
                'username' => 'nurul.hidayah',
                'email' => 'nurul.hidayah@smpn1pasuruan.sch.id',
                'password' => password_hash('guru123', PASSWORD_BCRYPT),
                'full_name' => 'Dra. Nurul Hidayah',
                'role_id' => $roleMap['guru_mapel'],
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'ahmad.fauzi',
                'email' => 'ahmad.fauzi@smpn1pasuruan.sch.id',
                'password' => password_hash('guru123', PASSWORD_BCRYPT),
                'full_name' => 'Ahmad Fauzi, S.Pd',
                'role_id' => $roleMap['guru_mapel'],
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($additionalTeacherUsers as $user) {
            $exists = $this->db->table('users')->where('username', $user['username'])->get()->getRow();
            if (!$exists) {
                $this->db->table('users')->insert($user);
            }
        }

        // Ambil user_id untuk semua guru
        $nurulUser = $this->db->table('users')->where('username', 'nurul.hidayah')->get()->getRow();
        $ahmadUser = $this->db->table('users')->where('username', 'ahmad.fauzi')->get()->getRow();
        
        $teacherData = [
            [
                'user_id' => $guruBKUser ? $guruBKUser->id : 1,
                'nip' => '197505152005012003', 
                'subject' => 'Bimbingan Konseling', 
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => $waliKelasUser ? $waliKelasUser->id : 1,
                'nip' => '198001012005011004', 
                'subject' => 'Matematika', 
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => $nurulUser ? $nurulUser->id : 1,
                'nip' => '197812312001121005', 
                'subject' => 'Bahasa Indonesia', 
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => $ahmadUser ? $ahmadUser->id : 1,
                'nip' => '198505102010012006', 
                'subject' => 'IPA', 
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];

        foreach ($teacherData as $teacher) {
            $exists = $this->db->table('teachers')->where('nip', $teacher['nip'])->get()->getRow();
            if (!$exists) {
                $this->db->table('teachers')->insert($teacher);
            }
        }

        // 6. Get IDs for relationships
        $guruBK = $this->db->table('users')->where('username', 'guru.bk')->get()->getRow();
        $counselorId = $guruBK ? $guruBK->id : 3; // fallback to ID 3

        $students = $this->db->table('students')->get()->getResultArray();
        $categories = $this->db->table('categories')->get()->getResultArray();

        // 7. Counseling Sessions
        if (!empty($students) && !empty($categories)) {
            $sessionData = [
                [
                    'student_id' => $students[0]['id'],
                    'counselor_id' => $counselorId,
                    'category_id' => $categories[0]['id'], // Akademik
                    'title' => 'Konsultasi Prestasi Belajar Matematika',
                    'description' => 'Siswa mengalami penurunan nilai matematika dalam 2 bulan terakhir. Perlu bimbingan untuk meningkatkan pemahaman konsep dasar.',
                    'session_date' => date('Y-m-d H:i:s', strtotime('+2 days 09:00')),
                    'status' => 'scheduled',
                    'is_urgent' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'student_id' => $students[1]['id'],
                    'counselor_id' => $counselorId,
                    'category_id' => $categories[1]['id'], // Sosial
                    'title' => 'Masalah Interaksi Sosial dengan Teman',
                    'description' => 'Siswa merasa kesulitan bergaul dengan teman sekelas dan sering menyendiri saat istirahat.',
                    'session_date' => date('Y-m-d H:i:s', strtotime('today 10:30')),
                    'status' => 'ongoing',
                    'is_urgent' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'student_id' => $students[2]['id'],
                    'counselor_id' => $counselorId,
                    'category_id' => $categories[7]['id'], // Bullying
                    'title' => 'Laporan Kasus Bullying - Mendesak',
                    'description' => 'Siswa melaporkan mengalami intimidasi verbal dan fisik dari kelompok siswa kelas atas. Perlu penanganan segera.',
                    'session_date' => date('Y-m-d H:i:s', strtotime('today 13:00')),
                    'status' => 'scheduled',
                    'is_urgent' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'student_id' => $students[3]['id'],
                    'counselor_id' => $counselorId,
                    'category_id' => $categories[2]['id'], // Pribadi
                    'title' => 'Konseling Masalah Kepercayaan Diri',
                    'description' => 'Siswa memiliki masalah kepercayaan diri yang rendah, terutama saat presentasi di depan kelas.',
                    'session_date' => date('Y-m-d H:i:s', strtotime('-3 days 14:00')),
                    'status' => 'completed',
                    'notes' => 'Siswa menunjukkan perkembangan positif. Perlu follow-up dalam 2 minggu.',
                    'follow_up' => 'Jadwalkan sesi lanjutan untuk evaluasi perkembangan.',
                    'is_urgent' => 0,
                    'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'student_id' => $students[4]['id'],
                    'counselor_id' => $counselorId,
                    'category_id' => $categories[3]['id'], // Keluarga
                    'title' => 'Masalah Keluarga - Perceraian Orang Tua',
                    'description' => 'Siswa mengalami stress karena proses perceraian orang tua. Prestasi menurun drastis.',
                    'session_date' => date('Y-m-d H:i:s', strtotime('-1 week 11:00')),
                    'status' => 'completed',
                    'notes' => 'Siswa membutuhkan dukungan emosional berkelanjutan. Koordinasi dengan wali kelas diperlukan.',
                    'follow_up' => 'Monitoring mingguan dan konsultasi dengan orang tua.',
                    'is_urgent' => 1,
                    'created_at' => date('Y-m-d H:i:s', strtotime('-1 week')),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ];

            foreach ($sessionData as $session) {
                $this->db->table('counseling_sessions')->insert($session);
            }
        }

        // 8. Counseling Requests
        if (!empty($students)) {
            $requestData = [
                [
                    'student_id' => $students[0]['id'],
                    'type' => 'personal',
                    'theme' => 'Akademik',
                    'description' => 'Saya mengalami kesulitan memahami pelajaran fisika. Mohon bimbingan dari guru BK.',
                    'status' => 'pending',
                    'requested_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'student_id' => $students[1]['id'],
                    'type' => 'group',
                    'theme' => 'Sosial',
                    'description' => 'Perlu bimbingan tentang cara berinteraksi yang baik dengan teman sebaya.',
                    'status' => 'approved',
                    'requested_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'student_id' => $students[2]['id'],
                    'type' => 'personal',
                    'theme' => 'Bullying',
                    'description' => 'Saya butuh bantuan segera terkait kasus bullying yang saya alami.',
                    'status' => 'rejected',
                    'requested_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'student_id' => $students[3]['id'],
                    'type' => 'personal',
                    'theme' => 'Pribadi',
                    'description' => 'Konsultasi mengenai masalah pribadi dan pengembangan diri.',
                    'status' => 'completed',
                    'requested_at' => date('Y-m-d H:i:s', strtotime('-1 week')),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'student_id' => $students[4]['id'],
                    'type' => 'group',
                    'theme' => 'Keluarga',
                    'description' => 'Diskusi kelompok tentang dampak perceraian orang tua terhadap anak.',
                    'status' => 'pending',
                    'requested_at' => date('Y-m-d H:i:s', strtotime('today')),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ];

            foreach ($requestData as $request) {
                $this->db->table('counseling_requests')->insert($request);
            }
        }
    }
}
