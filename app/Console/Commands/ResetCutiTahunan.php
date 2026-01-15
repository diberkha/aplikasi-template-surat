<?php

namespace App\Console\Commands;

use App\Models\Pegawai;
use App\Models\SuratIzinCuti;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ResetCutiTahunan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cuti:reset-tahunan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset cuti tahunan semua pegawai setiap awal tahun';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Memulai proses reset cuti tahunan...');
        $this->newLine();

        $this->info('📋 PEGAWAI PNS (dengan akumulasi)');
        $pnsPegawais = Pegawai::where('jenis_pegawai', 'PNS')->get();
        $pnsUpdated = 0;

        $year_prev_1 = Carbon::now()->subYear()->year;
        $year_prev_2 = Carbon::now()->subYears(2)->year;

        foreach ($pnsPegawais as $pegawai) {
            $usage_prev_1 = SuratIzinCuti::where('kategori', 'PNS')
                ->whereHas('surat', function ($q) use ($pegawai, $year_prev_1) {
                    $q->whereYear('tanggal_dibuat', $year_prev_1);
                })
                ->get()
                ->filter(function ($cuti) use ($pegawai) {
                    $formData = $cuti->form_data;
                    return ($formData['pegawai_id'] ?? null) == $pegawai->id && ($formData['jenis_cuti'] ?? '') === 'Cuti Tahunan';
                })
                ->sum(function ($cuti) {
                    return (int) ($cuti->form_data['lama_cuti'] ?? 0);
                });

            $usage_prev_2 = SuratIzinCuti::where('kategori', 'PNS')
                ->whereHas('surat', function ($q) use ($pegawai, $year_prev_2) {
                    $q->whereYear('tanggal_dibuat', $year_prev_2);
                })
                ->get()
                ->filter(function ($cuti) use ($pegawai) {
                    $formData = $cuti->form_data;
                    return ($formData['pegawai_id'] ?? null) == $pegawai->id && ($formData['jenis_cuti'] ?? '') === 'Cuti Tahunan';
                })
                ->sum(function ($cuti) {
                    return (int) ($cuti->form_data['lama_cuti'] ?? 0);
                });

            $old_n = $pegawai->sisa_cuti_n;
            $old_n1 = $pegawai->sisa_cuti_n1;

            $pegawai->sisa_cuti_n1 = min(6, $old_n);

            if ($usage_prev_1 == 0 && $usage_prev_2 == 0) {
                $pegawai->sisa_cuti_n2 = min(6, $old_n1);
            } else {
                $pegawai->sisa_cuti_n2 = 0;
            }

            $pegawai->sisa_cuti_n = 12;

            $total_akumulasi = $pegawai->sisa_cuti_n + $pegawai->sisa_cuti_n1 + $pegawai->sisa_cuti_n2;
            $pegawai->sisa_cuti_tahunan = min(24, $total_akumulasi);

            $pegawai->save();
            $pnsUpdated++;

            $this->line("✓ {$pegawai->nama} ({$pegawai->nip}) - Usage Y-1: {$usage_prev_1}, Y-2: {$usage_prev_2} | Total: {$pegawai->sisa_cuti_tahunan} hari (N:{$pegawai->sisa_cuti_n}, N-1:{$pegawai->sisa_cuti_n1}, N-2:{$pegawai->sisa_cuti_n2})");
        }

        $this->info("Selesai! {$pnsUpdated} pegawai PNS berhasil direset.");
        $this->newLine();

        $this->info('📋 PEGAWAI PPPK & NON ASN (tanpa akumulasi)');
        $nonPnsPegawais = Pegawai::whereIn('jenis_pegawai', ['PPPK', 'NON ASN'])->get();
        $nonPnsUpdated = 0;

        foreach ($nonPnsPegawais as $pegawai) {
            $pegawai->sisa_cuti_n = 12;
            $pegawai->sisa_cuti_n1 = 0;
            $pegawai->sisa_cuti_n2 = 0;
            $pegawai->sisa_cuti_tahunan = 12;

            $pegawai->save();
            $nonPnsUpdated++;

            $this->line("✓ {$pegawai->nama} ({$pegawai->nip}) - Reset: 12 hari");
        }

        $this->info("Selesai! {$nonPnsUpdated} pegawai PPPK/NON ASN berhasil direset.");
        $this->newLine();

        $this->info("🎉 Total: " . ($pnsUpdated + $nonPnsUpdated) . " pegawai berhasil direset.");

        return Command::SUCCESS;
    }
}
