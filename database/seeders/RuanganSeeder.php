<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ruangan;

class RuanganSeeder extends Seeder
{
    public function run(): void
    {
        $ruangan = [
            ['nama_ruangan' => 'Admin'],
            ['nama_ruangan' => 'Direktur'],
            ['nama_ruangan' => 'Tata Usaha'],
            ['nama_ruangan' => 'Pelayanan'],
            ['nama_ruangan' => 'Pengembangan'],
            ['nama_ruangan' => 'Pengadaan'],
            ['nama_ruangan' => 'Keuangan'],
            ['nama_ruangan' => 'Keperawatan'],
            ['nama_ruangan' => 'Farmasi'],
            ['nama_ruangan' => 'IT RSUD'],
        ];

        Ruangan::insert($ruangan);
    }
}
