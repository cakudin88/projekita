<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WalasSeeder extends Seeder
{
    public function run()
    {
        // Get role ID for walas
        $roleId = $this->db->table('roles')->where('name', 'walas')->get()->getRow()->id ?? null;
        
        if (!$roleId) {
            echo "Role 'walas' tidak ditemukan. Pastikan roles sudah di-seed terlebih dahulu.\n";
            return;
        }

        $data = [
            [
                'username' => 'walas1',
                'email' => 'walas1@sekolah.sch.id',
                'password' => password_hash('walas123', PASSWORD_DEFAULT),
                'full_name' => 'Drs. Bambang Sudrajat, M.Pd.',
                'role_id' => $roleId,
                'phone' => '081234567701',
                'address' => 'Jl. Wali Kelas No. 10, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'walas2',
                'email' => 'walas2@sekolah.sch.id',
                'password' => password_hash('walas123', PASSWORD_DEFAULT),
                'full_name' => 'Dra. Indah Permatasari, M.Pd.',
                'role_id' => $roleId,
                'phone' => '081234567702',
                'address' => 'Jl. Pembimbing No. 15, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'walas3',
                'email' => 'walas3@sekolah.sch.id',
                'password' => password_hash('walas123', PASSWORD_DEFAULT),
                'full_name' => 'Drs. Haryanto Wijaya, M.Si.',
                'role_id' => $roleId,
                'phone' => '081234567703',
                'address' => 'Jl. Pendidik No. 20, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'walas4',
                'email' => 'walas4@sekolah.sch.id',
                'password' => password_hash('walas123', PASSWORD_DEFAULT),
                'full_name' => 'Dra. Sri Mulyani, M.Pd.',
                'role_id' => $roleId,
                'phone' => '081234567704',
                'address' => 'Jl. Bimbingan No. 25, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'walas5',
                'email' => 'walas5@sekolah.sch.id',
                'password' => password_hash('walas123', PASSWORD_DEFAULT),
                'full_name' => 'Drs. Agus Setiawan, M.Pd.',
                'role_id' => $roleId,
                'phone' => '081234567705',
                'address' => 'Jl. Mentor No. 18, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'walas6',
                'email' => 'walas6@sekolah.sch.id',
                'password' => password_hash('walas123', PASSWORD_DEFAULT),
                'full_name' => 'Dra. Fitri Rahayu, M.Pd.',
                'role_id' => $roleId,
                'phone' => '081234567706',
                'address' => 'Jl. Pengasuh No. 12, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert data
        foreach ($data as $userData) {
            $this->db->table('users')->insert($userData);
        }

        echo "Seeder WalasSeeder berhasil dijalankan. " . count($data) . " wali kelas ditambahkan.\n";
    }
}
