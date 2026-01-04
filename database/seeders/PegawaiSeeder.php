<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use Carbon\Carbon;

class PegawaiSeeder extends Seeder
{
    private const DEFAULT_MASA_KERJA = '2000-01-01';

    public function run()
    {
        Pegawai::truncate();

        $files = [
            base_path('database/seeders/data/database_pegawai_pns_151.csv'),
            base_path('database/seeders/data/database_pegawai_pppk_76.csv'),
            base_path('database/seeders/data/database_pegawai_non_asn_68.csv'),
        ];

        foreach ($files as $path) {
            $this->seedFromCsv($path);
        }
    }

    private function seedFromCsv(string $path): void
    {
        if (!file_exists($path)) {
            throw new \RuntimeException("File CSV tidak ditemukan: {$path}");
        }

        $file = new \SplFileObject($path);
        $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY);
        $file->setCsvControl(',');

        $header = null;

        foreach ($file as $row) {
            if ($row === [null] || $row === false) {
                continue;
            }

            if ($header === null) {
                $header = array_map(fn ($h) => $this->clean($h), $row);

                if (isset($header[0])) {
                    $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
                }
                continue;
            }

            $data = [];
            foreach ($header as $i => $key) {
                if ($key === null || $key === '') continue;
                $data[$key] = isset($row[$i]) ? $this->clean($row[$i]) : null;
            }

            if (empty(array_filter($data, fn ($v) => $v !== null && $v !== ''))) {
                continue;
            }

            $masaKerja = $this->parseDateOrDefault($data['masa_kerja'] ?? null);

            $nip = $data['nip'] ?? null;
            $nip = ($nip !== null && $nip !== '') ? (string) $nip : null;

            Pegawai::create([
                'nama' => $data['nama'] ?? null,
                'nip' => $nip,
                'jenis_pegawai' => $data['jenis_pegawai'] ?? null,
                'jabatan' => $data['jabatan'] ?? null,
                'masa_kerja' => $masaKerja,

                'sisa_cuti_tahunan' => 12,
                'sisa_cuti_n' => 12,
                'sisa_cuti_n1' => 0,
                'sisa_cuti_n2' => 0,
            ]);
        }
    }

    private function clean($value): ?string
    {
        if ($value === null) return null;
        $v = trim((string) $value);
        return $v === '' ? null : $v;
    }

    private function parseDateOrDefault(?string $value): Carbon
    {
        $default = Carbon::parse(self::DEFAULT_MASA_KERJA);

        if ($value === null || trim($value) === '') {
            return $default;
        }

        $raw = trim($value);

        if (is_numeric($raw)) {
            try {
                return Carbon::create(1899, 12, 30)->addDays((int) $raw);
            } catch (\Throwable $e) {
                return $default;
            }
        }

        $formats = [
            'Y-m-d',
            'Y-m-d H:i:s',
            'd/m/Y',
            'd/m/Y H:i:s',
            'd-m-Y',
            'd-m-Y H:i:s',
        ];

        foreach ($formats as $fmt) {
            try {
                return Carbon::createFromFormat($fmt, $raw);
            } catch (\Throwable $e) {
            }
        }

        try {
            return Carbon::parse($raw);
        } catch (\Throwable $e) {
            return $default;
        }
    }
}
