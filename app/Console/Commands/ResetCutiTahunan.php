<?php

namespace App\Console\Commands;

use App\Models\Pegawai;
use Illuminate\Console\Command;

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

        foreach ($pnsPegawais as $pegawai) {
            $pegawai->sisa_cuti_n2 = $pegawai->sisa_cuti_n1;
            $pegawai->sisa_cuti_n1 = $pegawai->sisa_cuti_n;
            
            $pegawai->sisa_cuti_n = 12;

            $total_akumulasi = $pegawai->sisa_cuti_n + $pegawai->sisa_cuti_n1 + $pegawai->sisa_cuti_n2;
            $pegawai->sisa_cuti_tahunan = min(18, $total_akumulasi);

            $pegawai->save();
            $pnsUpdated++;

            $this->line("✓ {$pegawai->nama} ({$pegawai->nip}) - Total: {$pegawai->sisa_cuti_tahunan} hari (N:{$pegawai->sisa_cuti_n}, N-1:{$pegawai->sisa_cuti_n1}, N-2:{$pegawai->sisa_cuti_n2})");
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
