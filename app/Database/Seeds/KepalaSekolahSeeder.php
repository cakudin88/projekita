<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KepalaSekolahSeeder extends Seeder
{
    public function run()
    {
        // Get role ID for kepala_sekolah
        $roleId = $this->db->table('roles')->where('name', 'kepala_sekolah')->get()->getRow()->id ?? null;
        
        if (!$roleId) {
            echo "Role 'kepala_sekolah' tidak ditemukan. Pastikan roles sudah di-seed terlebih dahulu.\n";
            return;
        }

        $data = [
            [
                'username' => 'kepsek',
                'email' => 'kepala.sekolah@sekolah.sch.id',
                'password' => password_hash('kepsek123', PASSWORD_DEFAULT),
                'full_name' => 'Prof. Dr. H. Muhammad Rizki Hakim, M.Pd.',
                'role_id' => $roleId,
                'phone' => '081234567000',
                'address' => 'Jl. Kepemimpinan No. 1, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert data
        foreach ($data as $userData) {
            $this->db->table('users')->insert($userData);
        }

        echo "Seeder KepalaSekolahSeeder berhasil dijalankan. " . count($data) . " kepala sekolah ditambahkan.\n";
    }
}
