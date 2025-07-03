<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MissingRolesSeeder extends Seeder
{
    public function run()
    {
        // Check if roles exist, if not create them
        $roleData = [
            ['name' => 'guru_mapel', 'description' => 'Guru Mata Pelajaran'],
            ['name' => 'walas', 'description' => 'Wali Kelas'],
            ['name' => 'kepala_sekolah', 'description' => 'Kepala Sekolah'],
            ['name' => 'orang_tua', 'description' => 'Orang Tua/Wali Murid']
        ];

        foreach ($roleData as $role) {
            // Check if role already exists
            $existingRole = $this->db->table('roles')->where('name', $role['name'])->get()->getRow();
            
            if (!$existingRole) {
                $this->db->table('roles')->insert([
                    'name' => $role['name'],
                    'description' => $role['description'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                echo "Role '{$role['name']}' ditambahkan.\n";
            } else {
                echo "Role '{$role['name']}' sudah ada.\n";
            }
        }

        echo "Seeder MissingRolesSeeder selesai dijalankan.\n";
    }
}
