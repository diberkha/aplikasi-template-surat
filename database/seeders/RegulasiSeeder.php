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
            // Undang-Undang
            'Undang-Undang Nomor 40 Tahun 2004 tentang Sistem Jaminan Sosial Nasional (SJSN)',
            'Undang-Undang Nomor 29 Tahun 2004 tentang Praktik Kedokteran',
            'Undang-Undang Nomor 44 Tahun 2009 tentang Rumah Sakit',
            'Undang-Undang Nomor 24 Tahun 2011 tentang Badan Penyelenggara Jaminan Sosial (BPJS)',
            'Undang-Undang Nomor 11 Tahun 2020 tentang Cipta Kerja',
            'Undang-Undang Nomor 17 Tahun 2023 tentang Kesehatan',
            
            // Peraturan Pemerintah
            'Peraturan Pemerintah Nomor 40 Tahun 2019 tentang Pelaksanaan Undang-Undang Nomor 23 Tahun 2006 tentang Administrasi Kependudukan',
            'Peraturan Pemerintah Nomor 5 Tahun 2021 tentang Penyelenggaraan Perizinan Berusaha Berbasis Risiko',
            'Peraturan Pemerintah Republik Indonesia Nomor 47 Tahun 2021 tentang Penyelenggaraan Bidang Perumahsakitan',
            
            // Peraturan Presiden
            'Peraturan Presiden Nomor 12 Tahun 2013 tentang Jaminan Kesehatan',
            'Peraturan Presiden Nomor 111 Tahun 2013 tentang Perubahan atas Peraturan Presiden Nomor 12 Tahun 2013 tentang Jaminan Kesehatan',
            'Peraturan Presiden Nomor 77 Tahun 2015 tentang Pedoman Organisasi Rumah Sakit',
            'Peraturan Presiden Nomor 96 Tahun 2018 tentang Persyaratan dan Tata Cara Pendaftaran Penduduk dan Catatan Sipil',
            
            // Peraturan Menteri Dalam Negeri
            'Peraturan Menteri Dalam Negeri Nomor 19 Tahun 2016 tentang Pedoman Pengelolaan Barang Milik Daerah',
            'Peraturan Menteri Dalam Negeri Nomor 79 Tahun 2018 tentang Badan Layanan Umum Daerah',
            'Peraturan Menteri Dalam Negeri Nomor 7 Tahun 2019 tentang Pelayanan Administrasi Kependudukan secara daring',
            
            // Peraturan Menteri Kesehatan
            'Peraturan Menteri Kesehatan Nomor 129 Tahun 2008 tentang Standar Pelayanan Minimal Rumah Sakit',
            'Peraturan Menteri Kesehatan Nomor 71 Tahun 2013 tentang Pelayanan Kesehatan pada Jaminan Kesehatan Nasional',
            'Peraturan Menteri Kesehatan Nomor 27 Tahun 2017 tentang Pedoman Pencegahan dan Pengendalian Infeksi',
            'Peraturan Menteri Kesehatan Nomor 3 Tahun 2020 tentang Klasifikasi dan Perizinan Rumah Sakit',
            'Peraturan Menteri Kesehatan Nomor 14 Tahun 2021 tentang Standar Kegiatan Usaha dan Produk pada Penyelenggaraan Perizinan Berusaha Berbasis Risiko Sektor Kesehatan',
            'Peraturan Menteri Kesehatan Nomor 26 Tahun 2021 tentang Pedoman Indonesian Case Base Groups (INA-CBG)',
            'Peraturan Menteri Kesehatan Nomor 26 Tahun 2021 tentang Pencegahan dan Penanganan Kecurangan (Fraud) dalam Program Jaminan Kesehatan',
            'Peraturan Menteri Kesehatan Nomor 40 Tahun 2022 tentang Persyaratan Teknis Bangunan, Prasarana, dan Peralatan',
            
            // Peraturan BPJS Kesehatan
            'Peraturan BPJS Kesehatan Nomor 1 Tahun 2014 tentang Penyelenggaraan Jaminan Kesehatan',
            
            // Peraturan Daerah Kabupaten Sragen
            'Peraturan Daerah Kabupaten Sragen Nomor 15 Tahun 2008 tentang Organisasi dan Tata Kerja Lembaga Teknis Daerah',
            'Peraturan Daerah Kabupaten Sragen Nomor 2 Tahun 2009 tentang Pokok-Pokok Pengelolaan Keuangan Daerah',
            'Peraturan Daerah Kabupaten Sragen Nomor 5 Tahun 2023 tentang APBD Kabupaten Sragen Tahun Anggaran 2023',
            
            // Peraturan Bupati Sragen
            'Peraturan Bupati Sragen Nomor 10 Tahun 2011 tentang Penjabaran Tugas dan Fungsi RSUD dr. Soeratno Gemolong',
            'Peraturan Bupati Sragen Nomor 10 Tahun 2015 tentang Pedoman Pengelolaan Keuangan BLUD RSUD dr. Soeratno Gemolong',
            'Peraturan Bupati Sragen Nomor 67 Tahun 2021 tentang Pembentukan RSUD dr. Soeratno Gemolong Kelas C',
            'Peraturan Bupati Sragen Nomor 8 Tahun 2023 tentang Tata Kelola RSUD dr. Soeratno Gemolong',
            'Peraturan Bupati Sragen Nomor 20 Tahun 2024 tentang Pedoman Pelaksanaan Inventarisasi Barang Milik Daerah',
            
            // Keputusan
            'Keputusan Direktur Jenderal Pencegahan dan Pengendalian Penyakit Kementerian Kesehatan RI Nomor HK.02.02/1/1811/2022 tentang Petunjuk Teknis Kesiapan Sarana Prasarana Rumah Sakit dalam Penerapan Kelas Rawat Inap Standar JKN',
            'Keputusan Bupati Sragen Nomor 900/441/002/2014 tentang Penerapan Pola Pengelolaan Keuangan BLUD secara Penuh pada RSUD dr. Soeratno Gemolong',
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
