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
            ['nama_ruangan' => 'Keperawatan'],
            ['nama_ruangan' => 'IT'],
        ];

        Ruangan::insert($ruangan);
    }
}