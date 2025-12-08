<?php
// Direct test submission
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Surat;
use App\Models\SKDirektur;

echo "=== Database Connection Test ===\n";
try {
    $count = DB::table('surat')->count();
    echo "✓ Database connected. Total surat: " . $count . "\n";
} catch (Exception $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n";
    exit;
}

echo "\n=== Latest Surat Records ===\n";
$latest = Surat::latest()->take(3)->get();
foreach ($latest as $surat) {
    echo "ID: {$surat->id_surat}, Nomor: {$surat->nomor_surat}, Created: {$surat->created_at}\n";
}

echo "\n=== Latest SKDirektur Records ===\n";
$latestSK = SKDirektur::latest()->take(3)->get();
foreach ($latestSK as $sk) {
    echo "ID: {$sk->id_sk_direktur}, Nomor: {$sk->nomor_surat}, Created: {$sk->created_at}\n";
}

echo "\n=== Testing Surat Creation ===\n";
try {
    $surat = Surat::create([
        'nama_surat' => 'TEST DIREKTUR DEBUG',
        'nomor_surat' => 'DEBUG/' . date('Y/m/d') . '/' . time(),
        'tanggal_dibuat' => now(),
        'id_template_surat' => 1,
        'id_regulasi' => 1,
        'created_by' => 1,
    ]);
    echo "✓ Surat created: ID {$surat->id_surat}, Nomor: {$surat->nomor_surat}\n";
    
    $sk = SKDirektur::create([
        'judul_surat' => 'TEST',
        'nomor_surat' => $surat->nomor_surat,
        'tentang' => 'TEST',
        'identitas_penetap' => 'TEST',
        'menimbang' => 'TEST MENIMBANG',
        'mengingat' => 'TEST MENGINGAT',
        'memutuskan' => 'TEST MEMUTUSKAN',
        'menetapkan' => null,
        'tempat_dibuat' => 'TEST',
        'tanggal_dibuat' => now(),
        'jabatan_pembuat' => 'TEST',
        'nama_pembuat' => 'TEST',
        'id_surat' => $surat->id_surat,
    ]);
    echo "✓ SKDirektur created: ID {$sk->id_sk_direktur}\n";
    
} catch (Exception $e) {
    echo "✗ Error creating records: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}

echo "\nDone!\n";
?>
