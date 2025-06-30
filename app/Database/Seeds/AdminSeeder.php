<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin',
            'email' => 'admin@school.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'full_name' => 'Super Administrator',
            'phone' => '08123456789',
            'address' => 'Alamat Admin',
            'role_id' => 1, // super_admin
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('users')->insert($data);
    }
}
