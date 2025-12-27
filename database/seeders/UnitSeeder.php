<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            'Instalasi Gawat Darurat',
            'Instalasi Rawat Inap',
            'Instalasi Rawat Jalan',
            'Instalasi Penunjang Medis',
        ];

        foreach ($units as $unit) {
            Unit::updateOrCreate(
                ['nama_unit' => $unit],
                ['nama_unit' => $unit]
            );
        }
    }
}
