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
            ['nama_template_surat' => 'Standar Operasional Prosedur (SOP)'],
            ['nama_template_surat' => 'Surat Izin Cuti PNS'],
            ['nama_template_surat' => 'Surat Izin Cuti PPPK'],
            ['nama_template_surat' => 'Surat Izin Cuti Non ASN'],
            ['nama_template_surat' => 'Surat Undangan'],
        ];

        foreach ($templates as $tpl) {
            TemplateSurat::firstOrCreate(
                ['nama_template_surat' => $tpl['nama_template_surat']],
                $tpl
            );
        }
    }
}
