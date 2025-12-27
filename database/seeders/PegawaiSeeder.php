<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use Carbon\Carbon;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        Pegawai::create([
            'nama' => 'Budi Santoso, S.Kep., Ns.',
            'nip' => '199001012020011001',
            'tanggal_masuk' => Carbon::now()->subYears(3)->subMonths(2),
            'sisa_cuti_tahunan' => 12,
        ]);

        Pegawai::create([
            'nama' => 'Siti Aminah, S.Tr.Keb.',
            'nip' => '199505052021022002',
            'tanggal_masuk' => Carbon::now()->subYears(1)->subMonths(5),
            'sisa_cuti_tahunan' => 6,
        ]);

        Pegawai::create([
            'nama' => 'dr. Andi Pratama, Sp.PD',
            'nip' => '198703152019031003',
            'tanggal_masuk' => Carbon::now()->subYears(5)->subMonths(1),
            'sisa_cuti_tahunan' => 10,
        ]);

        Pegawai::create([
            'nama' => 'Rina Wulandari, S.KM',
            'nip' => '199211202022072004',
            'tanggal_masuk' => Carbon::now()->subYears(2),
            'sisa_cuti_tahunan' => 12,
        ]);

        Pegawai::create([
            'nama' => 'Ahmad Fauzi, A.Md.Kep',
            'nip' => '199808102023061005',
            'tanggal_masuk' => Carbon::now()->subMonths(10),
            'sisa_cuti_tahunan' => 0, 
        ]);

        Pegawai::create([
            'nama' => 'Dewi Lestari, S.Farm., Apt.',
            'nip' => '199402182018022006',
            'tanggal_masuk' => Carbon::now()->subYears(6)->subMonths(3),
            'sisa_cuti_tahunan' => 8,
        ]);
    }
}
