<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Akademik',
                'description' => 'Masalah yang berkaitan dengan prestasi akademik, kesulitan belajar, dan motivasi belajar',
                'color' => '#2563eb',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Sosial',
                'description' => 'Masalah dalam berinteraksi dengan teman sebaya, guru, dan lingkungan sekolah',
                'color' => '#16a34a',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Pribadi',
                'description' => 'Masalah kepribadian, emosi, dan pengembangan diri siswa',
                'color' => '#dc2626',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Keluarga',
                'description' => 'Masalah yang berkaitan dengan hubungan keluarga dan kondisi rumah',
                'color' => '#7c3aed',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Karir',
                'description' => 'Bimbingan untuk pemilihan jurusan dan perencanaan masa depan',
                'color' => '#ea580c',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Perilaku',
                'description' => 'Masalah kedisiplinan, kenakalan, dan penyesuaian perilaku',
                'color' => '#dc2626',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Kesehatan Mental',
                'description' => 'Masalah kecemasan, depresi, stress, dan kesehatan mental lainnya',
                'color' => '#059669',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Bullying',
                'description' => 'Kasus perundungan baik sebagai korban maupun pelaku',
                'color' => '#b91c1c',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('categories')->insertBatch($data);
    }
}
