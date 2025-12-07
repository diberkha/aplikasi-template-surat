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
            ['nama_ruangan' => 'Direksi'],
        ];

        Ruangan::insert($ruangan);

        $this->command->info('Data ruangan berhasil dibuat');
    }
}