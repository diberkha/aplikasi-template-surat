<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Regulasi;
use App\Models\TemplateSurat;
use App\Models\Surat;
use App\Models\User;

class RegulasiSeeder extends Seeder
{
    public function run(): void
    {
        Regulasi::truncate();

        $templateHukum = TemplateSurat::where('nama_template_surat', 'Surat Hukum & Kerja Sama')->first();

        $suratKeputusan = Surat::where('nama_surat', 'Surat Keputusan Direktur')->first();

        $user = User::first();

        if (!$templateHukum || !$suratKeputusan || !$user) {
            $this->command->error('Data yang diperlukan tidak ditemukan. Pastikan seeder berikut sudah dijalankan:');
            $this->command->error('- TemplateSuratSeeder');
            $this->command->error('- SuratSeeder');
            $this->command->error('- UserSeeder');
            return;
        }

        $regulasis = [
            [
                'id_template_surat' => $templateHukum->id_template_surat,
                'id_surat' => $suratKeputusan->id_surat,
                'isi_regulasi' => json_encode([
                    'menimbang' => 'a. bahwa dalam rangka mendukung program pemerintah di bidang pelayanan kesehatan melalui Jaminan Kesehatan Nasional yang dikelola oleh Badan Penyelenggara Jaminan Sosial (BPJS) bidang kesehatan, rumah sakit diminta untuk berperan serta dalam meningkatkan pelayanan kesehatan;
b. bahwa untuk pemantapan mutu dan pengendalian biaya dalam pelaksanaan Program Jaminan Kesehatan Nasional, perlu dibentuk Tim Kendali Mutu Kendali Biaya JKN RSUD dr. Soeratno Gemolong;
c. bahwa berdasarkan pertimbangan sebagaimana dimaksud huruf a dan b tersebut di atas maka perlu diatur dan ditetapkan dengan Surat Keputusan Direktur RSUD dr. Soeratno Gemolong.',
                    'mengingat' => '1. Undang-undang Nomor 36 Tahun 2009 tentang Kesehatan;
2. Undang-undang Nomor 44 Tahun 2009 tentang Rumah Sakit;
3. Undang-undang Nomor 40 Tahun 2004 tentang Sistem Jaminan Sosial Nasional (SJSN);
4. Undang-undang Nomor 24 Tahun 2011 tentang Badan Penyelenggara Jaminan Sosial (BPJS);
5. Peraturan Presiden Nomor 12 Tahun 2013 tentang Jaminan Kesehatan;
6. Peraturan Presiden Nomor 111 Tahun 2013 tentang Perubahan atas Peraturan Presiden nomor 12 tahun 2013 tentang Jaminan Kesehatan;
7. Permenkes RI Nomor 71 Tahun 2013 tentang pelayanan Kesehatan pada Jaminan Kesehatan Nasional;
8. Peraturan BPJS Kesehatan Nomor 1 Tahun 2014 tentang Penyelenggaraan Jaminan Kesehatan;
9. Peraturan Menteri Dalam Negeri Nomor 79 Tahun 2018 tentang Badan Layanan Umum Daerah;
10. Peraturan Daerah Kabupaten Sragen Nomor 2 Tahun 2009 tentang Pokok-Pokok Pengelolaan Keuangan Daerah;
11. Peraturan Bupati Sragen Nomor 44 Tahun 2020 tentang Pembentukan Unit Pelaksana Teknis Daerah Rumah Sakit Umum Daerah dr. Soeratno Gemolong.',
                ]),
                'created_by' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Regulasi::insert($regulasis);

        $this->command->info('RegulasiSeeder: ' . count($regulasis) . ' data regulasi berhasil dibuat.');
    }
}