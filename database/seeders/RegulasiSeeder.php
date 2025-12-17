<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Regulasi;
use App\Models\User;

class RegulasiSeeder extends Seeder
{
    public function run(): void
    {
        $dasarHukums = [
            'Undang-undang Nomor 36 Tahun 2009 tentang Kesehatan',
            'Undang-undang Nomor 44 Tahun 2009 tentang Rumah Sakit',
            'Undang-undang Nomor 40 Tahun 2004 tentang Sistem Jaminan Sosial Nasional (SJSN)',
            'Undang-undang Nomor 24 Tahun 2011 tentang Badan Penyelenggara Jaminan Sosial (BPJS)',
            'Peraturan Presiden Nomor 12 Tahun 2013 tentang Jaminan Kesehatan',
            'Peraturan Presiden Nomor 111 Tahun 2013 tentang Perubahan atas Peraturan Presiden nomor 12 tahun 2013 tentang Jaminan Kesehatan',
            'Permenkes RI Nomor 71 Tahun 2013 tentang pelayanan Kesehatan pada Jaminan Kesehatan Nasional',
            'Peraturan BPJS Kesehatan Nomor 1 Tahun 2014 tentang Penyelenggaraan Jaminan Kesehatan',
            'Peraturan Menteri Dalam Negeri Nomor 79 Tahun 2018 tentang Badan Layanan Umum Daerah',
            'Peraturan Daerah Kabupaten Sragen Nomor 2 Tahun 2009 tentang Pokok-Pokok Pengelolaan Keuangan Daerah',
            'Peraturan Bupati Sragen Nomor 44 Tahun 2020 tentang Pembentukan Unit Pelaksana Teknis Daerah Rumah Sakit Umum Daerah dr. Soeratno Gemolong',
        ];

        $regulasis = collect($dasarHukums)->map(function ($isi) {
            return [
                'isi_regulasi' => $isi,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->all();

        Regulasi::insert($regulasis);

        $this->command->info('RegulasiSeeder: ' . count($regulasis) . ' data regulasi berhasil dibuat');
    }
}
