<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GuruBKSeeder extends Seeder
{
    public function run()
    {
        // Get guru_bk role id
        $guruBKRole = $this->db->table('roles')->where('name', 'guru_bk')->get()->getRowArray();
        $guruBKRoleId = $guruBKRole['id'];

        // Create Guru BK user
        $userData = [
            'username' => 'guru.bk',
            'full_name' => 'Dr. Sari Indrawati, M.Pd',
            'email' => 'sari.indrawati@smpn1pasuruan.sch.id',
            'password' => password_hash('gurubk123', PASSWORD_DEFAULT),
            'role_id' => $guruBKRoleId,
            'is_active' => true,
            'phone' => '081234567999',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('users')->insert($userData);
        $userId = $this->db->insertID();

        // Create teacher record
        $teacherData = [
            'user_id' => $userId,
            'nip' => '197505152005012003',
            'subject' => 'Bimbingan Konseling',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('teachers')->insert($teacherData);
    }
}
