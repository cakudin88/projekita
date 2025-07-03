<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OrangTuaSeeder extends Seeder
{
    public function run()
    {
        // Get role ID for orang_tua
        $roleId = $this->db->table('roles')->where('name', 'orang_tua')->get()->getRow()->id ?? null;
        
        if (!$roleId) {
            echo "Role 'orang_tua' tidak ditemukan. Pastikan roles sudah di-seed terlebih dahulu.\n";
            return;
        }

        $data = [
            [
                'username' => 'orangtua1',
                'email' => 'orangtua1@gmail.com',
                'password' => password_hash('ortu123', PASSWORD_DEFAULT),
                'full_name' => 'Bapak Suryadi',
                'role_id' => $roleId,
                'phone' => '081234567901',
                'address' => 'Jl. Keluarga Sejahtera No. 10, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'orangtua2',
                'email' => 'orangtua2@gmail.com',
                'password' => password_hash('ortu123', PASSWORD_DEFAULT),
                'full_name' => 'Ibu Sari Dewi',
                'role_id' => $roleId,
                'phone' => '081234567902',
                'address' => 'Jl. Keluarga Sejahtera No. 10, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'orangtua3',
                'email' => 'orangtua3@gmail.com',
                'password' => password_hash('ortu123', PASSWORD_DEFAULT),
                'full_name' => 'Bapak Andi Wijaya',
                'role_id' => $roleId,
                'phone' => '081234567903',
                'address' => 'Jl. Harmoni No. 25, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'orangtua4',
                'email' => 'orangtua4@gmail.com',
                'password' => password_hash('ortu123', PASSWORD_DEFAULT),
                'full_name' => 'Ibu Rina Susanti',
                'role_id' => $roleId,
                'phone' => '081234567904',
                'address' => 'Jl. Harmoni No. 25, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'orangtua5',
                'email' => 'orangtua5@gmail.com',
                'password' => password_hash('ortu123', PASSWORD_DEFAULT),
                'full_name' => 'Bapak Hendra Gunawan',
                'role_id' => $roleId,
                'phone' => '081234567905',
                'address' => 'Jl. Bahagia No. 33, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'orangtua6',
                'email' => 'orangtua6@gmail.com',
                'password' => password_hash('ortu123', PASSWORD_DEFAULT),
                'full_name' => 'Ibu Lisa Marlina',
                'role_id' => $roleId,
                'phone' => '081234567906',
                'address' => 'Jl. Bahagia No. 33, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'orangtua7',
                'email' => 'orangtua7@gmail.com',
                'password' => password_hash('ortu123', PASSWORD_DEFAULT),
                'full_name' => 'Bapak Rudi Hartono',
                'role_id' => $roleId,
                'phone' => '081234567907',
                'address' => 'Jl. Sukses No. 44, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'orangtua8',
                'email' => 'orangtua8@gmail.com',
                'password' => password_hash('ortu123', PASSWORD_DEFAULT),
                'full_name' => 'Ibu Diana Putri',
                'role_id' => $roleId,
                'phone' => '081234567908',
                'address' => 'Jl. Sukses No. 44, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'orangtua9',
                'email' => 'orangtua9@gmail.com',
                'password' => password_hash('ortu123', PASSWORD_DEFAULT),
                'full_name' => 'Bapak Agung Prasetya',
                'role_id' => $roleId,
                'phone' => '081234567909',
                'address' => 'Jl. Prestasi No. 17, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'orangtua10',
                'email' => 'orangtua10@gmail.com',
                'password' => password_hash('ortu123', PASSWORD_DEFAULT),
                'full_name' => 'Ibu Fitri Handayani',
                'role_id' => $roleId,
                'phone' => '081234567910',
                'address' => 'Jl. Prestasi No. 17, Jakarta',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert data
        foreach ($data as $userData) {
            $this->db->table('users')->insert($userData);
        }

        echo "Seeder OrangTuaSeeder berhasil dijalankan. " . count($data) . " orang tua ditambahkan.\n";
    }
}
