<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keputusan;

class KeputusanSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Keputusan::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $keputusans = [
            ['nama_keputusan' => 'Pembentukan Tim'],
        ];

        Keputusan::insert($keputusans);

        $this->command->info('KeputusanSeeder: ' . count($keputusans) . ' data keputusan berhasil dibuat.');
    }
}
