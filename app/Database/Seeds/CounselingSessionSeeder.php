<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CounselingSessionSeeder extends Seeder
{
    public function run()
    {
        // Get guru BK user id
        $guruBK = $this->db->table('users')->where('username', 'guru.bk')->get()->getRowArray();
        $counselorId = $guruBK['id'];

        // Get some students
        $students = $this->db->table('students')->limit(5)->get()->getResultArray();
        
        // Get categories
        $categories = $this->db->table('categories')->get()->getResultArray();

        $sessions = [
            [
                'student_id' => $students[0]['id'],
                'counselor_id' => $counselorId,
                'category_id' => $categories[0]['id'], // Akademik
                'title' => 'Konsultasi Prestasi Belajar',
                'description' => 'Siswa mengalami penurunan nilai matematika dalam 2 bulan terakhir.',
                'session_date' => date('Y-m-d H:i:s', strtotime('+2 days 09:00')),
                'status' => 'scheduled',
                'notes' => null,
                'follow_up' => null,
                'is_urgent' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'student_id' => $students[1]['id'],
                'counselor_id' => $counselorId,
                'category_id' => $categories[1]['id'], // Sosial
                'title' => 'Masalah Interaksi dengan Teman',
                'description' => 'Siswa merasa kesulitan bergaul dengan teman sekelas.',
                'session_date' => date('Y-m-d H:i:s', strtotime('today 10:30')),
                'status' => 'ongoing',
                'notes' => null,
                'follow_up' => null,
                'is_urgent' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'student_id' => $students[2]['id'],
                'counselor_id' => $counselorId,
                'category_id' => $categories[7]['id'], // Bullying
                'title' => 'Laporan Kasus Bullying',
                'description' => 'Siswa melaporkan mengalami intimidasi dari siswa kelas atas.',
                'session_date' => date('Y-m-d H:i:s', strtotime('today 13:00')),
                'status' => 'scheduled',
                'notes' => null,
                'follow_up' => null,
                'is_urgent' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('counseling_sessions')->insertBatch($sessions);
    }
}
