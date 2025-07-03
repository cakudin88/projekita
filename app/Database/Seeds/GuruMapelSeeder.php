<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GuruMapelSeeder extends Seeder
{
    public function run()
    {
        // Get role ID for guru_mapel
        $roleId = $this->db->table('roles')->where('name', 'guru_mapel')->get()->getRow()->id ?? null;
        
        if (!$roleId) {
            echo "Role 'guru_mapel' tidak ditemukan. Pastikan roles sudah di-seed terlebih dahulu.\n";
            return;
        }

        $data = [
            [
                'username' => 'gurumapel1',
                'email' => 'gurumapel1@sekolah.sch.id',
                'password' => password_hash('mapel123', PASSWORD_DEFAULT),
                'full_name' => 'Dr. Ahmad Wijaya, S.Pd., M.Pd.',
                'role_id' => $roleId,
                'phone' => '081234567801',
                'address' => 'Jl. Pendidikan No. 15, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'gurumapel2',
                'email' => 'gurumapel2@sekolah.sch.id',
                'password' => password_hash('mapel123', PASSWORD_DEFAULT),
                'full_name' => 'Dra. Siti Nurhaliza, M.Si.',
                'role_id' => $roleId,
                'phone' => '081234567802',
                'address' => 'Jl. Guru Raya No. 22, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'gurumapel3',
                'email' => 'gurumapel3@sekolah.sch.id',
                'password' => password_hash('mapel123', PASSWORD_DEFAULT),
                'full_name' => 'Ir. Budi Santoso, M.T.',
                'role_id' => $roleId,
                'phone' => '081234567803',
                'address' => 'Jl. Teknologi No. 8, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'gurumapel4',
                'email' => 'gurumapel4@sekolah.sch.id',
                'password' => password_hash('mapel123', PASSWORD_DEFAULT),
                'full_name' => 'Drs. Eko Prasetyo, M.Pd.',
                'role_id' => $roleId,
                'phone' => '081234567804',
                'address' => 'Jl. Bahasa No. 12, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'gurumapel5',
                'email' => 'gurumapel5@sekolah.sch.id',
                'password' => password_hash('mapel123', PASSWORD_DEFAULT),
                'full_name' => 'Prof. Dr. Maya Sari, M.A.',
                'role_id' => $roleId,
                'phone' => '081234567805',
                'address' => 'Jl. Global No. 5, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'gurumapel6',
                'email' => 'gurumapel6@sekolah.sch.id',
                'password' => password_hash('mapel123', PASSWORD_DEFAULT),
                'full_name' => 'Drs. Hadi Kusuma, M.Pd.',
                'role_id' => $roleId,
                'phone' => '081234567806',
                'address' => 'Jl. Sejarah No. 9, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'gurumapel7',
                'email' => 'gurumapel7@sekolah.sch.id',
                'password' => password_hash('mapel123', PASSWORD_DEFAULT),
                'full_name' => 'Dra. Rina Widyawati, M.Pd.',
                'role_id' => $roleId,
                'phone' => '081234567807',
                'address' => 'Jl. Geografi No. 18, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'gurumapel8',
                'email' => 'gurumapel8@sekolah.sch.id',
                'password' => password_hash('mapel123', PASSWORD_DEFAULT),
                'full_name' => 'Drs. Agus Riyanto, M.Si.',
                'role_id' => $roleId,
                'phone' => '081234567808',
                'address' => 'Jl. Biologi No. 7, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert data
        foreach ($data as $userData) {
            $this->db->table('users')->insert($userData);
        }

        echo "Seeder GuruMapelSeeder berhasil dijalankan. " . count($data) . " guru mata pelajaran ditambahkan.\n";
    }
}
