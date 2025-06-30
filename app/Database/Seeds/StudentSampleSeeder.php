<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StudentSampleSeeder extends Seeder
{
    public function run()
    {
        // Get murid role id
        $muridRole = $this->db->table('roles')->where('name', 'murid')->get()->getRowArray();
        $muridRoleId = $muridRole['id'];

        // Create users for students first
        $students = [
            [
                'nis' => '2024001',
                'name' => 'Ahmad Rizki Pratama',
                'class' => '7A',
                'grade' => '7',
                'email' => 'ahmad.rizki@student.smpn1pasuruan.sch.id',
            ],
            [
                'nis' => '2024002',
                'name' => 'Siti Nurhaliza',
                'class' => '7A',
                'grade' => '7',
                'email' => 'siti.nurhaliza@student.smpn1pasuruan.sch.id',
            ],
            [
                'nis' => '2024003',
                'name' => 'Budi Santoso',
                'class' => '7B',
                'grade' => '7',
                'email' => 'budi.santoso@student.smpn1pasuruan.sch.id',
            ],
            [
                'nis' => '2024004',
                'name' => 'Dewi Kartika',
                'class' => '8A',
                'grade' => '8',
                'email' => 'dewi.kartika@student.smpn1pasuruan.sch.id',
            ],
            [
                'nis' => '2024005',
                'name' => 'Eko Prasetyo',
                'class' => '8B',
                'grade' => '8',
                'email' => 'eko.prasetyo@student.smpn1pasuruan.sch.id',
            ],
            [
                'nis' => '2024006',
                'name' => 'Fatima Zahra',
                'class' => '9A',
                'grade' => '9',
                'email' => 'fatima.zahra@student.smpn1pasuruan.sch.id',
            ],
            [
                'nis' => '2024007',
                'name' => 'Galih Prakoso',
                'class' => '9B',
                'grade' => '9',
                'email' => 'galih.prakoso@student.smpn1pasuruan.sch.id',
            ],
            [
                'nis' => '2024008',
                'name' => 'Hilda Permata',
                'class' => '7C',
                'grade' => '7',
                'email' => 'hilda.permata@student.smpn1pasuruan.sch.id',
            ],
        ];

        foreach ($students as $student) {
            // Create user first
            $userData = [
                'username' => strtolower(str_replace(' ', '.', $student['name'])),
                'full_name' => $student['name'],
                'email' => $student['email'],
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role_id' => $muridRoleId,
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('users')->insert($userData);
            $userId = $this->db->insertID();

            // Create student record
            $studentData = [
                'user_id' => $userId,
                'nis' => $student['nis'],
                'class' => $student['class'],
                'grade' => $student['grade'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('students')->insert($studentData);
        }
    }
}
