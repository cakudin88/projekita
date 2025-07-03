<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AllUsersSeeder extends Seeder
{
    public function run()
    {
        echo "=== Menjalankan All Users Seeder ===\n\n";
        
        // Jalankan seeder untuk semua role user
        $this->call('AdminSeeder');
        $this->call('GuruBKSeeder'); 
        $this->call('GuruMapelSeeder');
        $this->call('WalasSeeder');
        $this->call('KepalaSekolahSeeder');
        $this->call('OrangTuaSeeder');
        $this->call('StudentSampleSeeder');
        
        echo "\n=== All Users Seeder selesai dijalankan ===\n";
        echo "Total users yang ditambahkan:\n";
        echo "- Admin: 1\n";
        echo "- Guru BK: 2\n";
        echo "- Guru Mapel: 8\n";
        echo "- Wali Kelas: 6\n";
        echo "- Kepala Sekolah: 1\n";
        echo "- Orang Tua: 10\n";
        echo "- Murid: 5\n";
        echo "Total: 33 users\n\n";
        
        echo "Kredensial login:\n";
        echo "Super Admin: admin / admin123\n";
        echo "Guru BK: gurubk / gurubk123\n";
        echo "Guru Mapel: gurumapel1 / mapel123\n";
        echo "Wali Kelas: walas1 / walas123\n";
        echo "Kepala Sekolah: kepsek / kepsek123\n";
        echo "Orang Tua: orangtua1 / ortu123\n";
        echo "Murid: murid1 / murid123\n";
    }
}
