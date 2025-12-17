<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TemplateSurat;

class TemplateSuratSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            ['nama_template_surat' => 'Surat Keputusan Direktur'],
        ];

        foreach ($templates as $tpl) {
            TemplateSurat::firstOrCreate(
                ['nama_template_surat' => $tpl['nama_template_surat']],
                $tpl
            );
        }
    }
}