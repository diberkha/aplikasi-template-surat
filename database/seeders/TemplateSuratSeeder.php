<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TemplateSurat;

class TemplateSuratSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            ['nama_template_surat' => 'Surat Hukum & Kerja Sama'],
        ];

        TemplateSurat::insert($templates);

        $this->command->info('Template surat berhasil dibuat');
    }
}