<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Surat;
use App\Models\TemplateSurat;
use App\Models\User;
use Carbon\Carbon;

class SuratSeeder extends Seeder
{
    public function run(): void
    {
        $templates = TemplateSurat::all();
        $users = User::all();

        $suratData = [
            [
                'nama_surat' => 'Surat Keputusan Direktur',
                'nomor_surat' => '006/SHKS/VI/2024',
                'tanggal_dibuat' => Carbon::parse('2024-06-10'),
                'id_template_surat' => $templates->where('nama_template_surat', 'Surat Hukum & Kerja Sama')->first()->id_template_surat,
                'created_by' => $users->first()->id,
            ],
        ];

        Surat::insert($suratData);

        $this->command->info(count($suratData) . ' data surat berhasil dibuat');
    }
}