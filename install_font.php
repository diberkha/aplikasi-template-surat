<?php

require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$fontDir = __DIR__ . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'fonts';
if (!is_dir($fontDir)) {
    mkdir($fontDir, 0777, true);
}

$options = new Options();
$options->set('fontDir', $fontDir);
$options->set('fontCache', $fontDir);
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$fontName = 'Cambria';
$fontPath = $fontDir . DIRECTORY_SEPARATOR . 'cambria.ttf';

if (!file_exists($fontPath)) {
    die("File font TIDAK ditemukan di: $fontPath\n");
}

echo "Mendaftarkan font $fontName dari $fontPath...\n";

$fontMetrics = $dompdf->getFontMetrics();

$fontMetrics->getFont($fontName, 'normal');

$html = "<html><head><style>@font-face { font-family: '$fontName'; src: url('$fontPath') format('truetype'); font-weight: normal; font-style: normal; } body { font-family: '$fontName'; }</style></head><body>Test Font</body></html>";

$dompdf->loadHtml($html);
$dompdf->render();

echo "SELESAI. Silakan jalankan 'dir storage\\fonts' untuk melihat apakah ada file baru.\n";
