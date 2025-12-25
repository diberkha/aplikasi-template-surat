<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SKDirektur;
use Exception;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Shared\Converter;

class SKDirekturDocxController extends Controller
{
    public function download($id)
    {
        try {
            $surat = Surat::findOrFail($id);
            $sk = SKDirektur::where('id_surat', $id)->firstOrFail();
            $data = $sk->toArray();
            
            $phpWord = new PhpWord();
            $phpWord->setDefaultFontName('Times New Roman');
            $phpWord->setDefaultFontSize(12);
            $phpWord->setDefaultParagraphStyle(['spaceAfter' => 0, 'lineHeight' => 1.15]);

            $section = $phpWord->addSection([
                'marginTop' => (int) Converter::cmToTwip(8.4 / 10),
                'marginBottom' => (int) Converter::cmToTwip(4.8 / 10),
                'marginLeft' => (int) Converter::cmToTwip(12.4 / 10),
                'marginRight' => (int) Converter::cmToTwip(9.9 / 10),
                'pageSizeW' => (int) Converter::cmToTwip(215.9 / 10),
                'pageSizeH' => (int) Converter::cmToTwip(330.2 / 10),
            ]);

            // Header Table
            $headerTableStyle = ['borderBottomSize' => 18, 'borderBottomColor' => '000000', 'cellMargin' => 0];
            $phpWord->addTableStyle('HeaderTable', $headerTableStyle);
            $table = $section->addTable('HeaderTable');
            $table->addRow();
            
            // Left Logo
            $logoLeftPath = public_path('img/logo-sragen-kop.jpg');
            if (file_exists($logoLeftPath)) {
                $table->addCell((int) Converter::inchToTwip(0.8))->addImage($logoLeftPath, ['width' => (int) Converter::inchToPoint(0.8), 'height' => (int) Converter::inchToPoint(1.0)]);
            } else {
                $table->addCell((int) Converter::inchToTwip(0.8));
            }

            // Center Text
            $centerCell = $table->addCell((int) Converter::inchToTwip(6.0));
            $centerCell->addText('PEMERINTAH KABUPATEN SRAGEN', ['size' => 12], ['alignment' => Jc::CENTER]);
            $centerCell->addText('RSUD dr. SOERATNO GEMOLONG', ['bold' => true, 'size' => 16], ['alignment' => Jc::CENTER]);
            $centerCell->addText('Jalan R. Ngt. Tjitrosantjoko 10, Gemolong, Sragen, Jawa Tengah 57274', ['size' => 10], ['alignment' => Jc::CENTER]);
            $centerCell->addText('Telp. (0271) 6811839, Laman rsudgemolong.sragenkab.go.id, Pos-el rsudgemolong@gmail.com', ['size' => 10], ['alignment' => Jc::CENTER]);

            // Right Logo
            $logoRightPath = public_path('img/logo-rs-kop.png');
            if (file_exists($logoRightPath)) {
                $table->addCell((int) Converter::inchToTwip(0.8))->addImage($logoRightPath, ['width' => (int) Converter::inchToPoint(0.8), 'height' => (int) Converter::inchToPoint(1.0), 'alignment' => Jc::RIGHT]);
            } else {
                $table->addCell((int) Converter::inchToTwip(0.8));
            }

            $section->addTextBreak(1);

            // Title
            $section->addText('KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG', null, ['alignment' => Jc::CENTER]);
            $section->addText('KABUPATEN SRAGEN', null, ['alignment' => Jc::CENTER]);
            $section->addText('NOMOR : ' . ($data['nomor_surat'] ?? '-'), null, ['alignment' => Jc::CENTER]);
            $section->addTextBreak(1);
            $section->addText('TENTANG', null, ['alignment' => Jc::CENTER]);
            $section->addTextBreak(1);
            
            $tentang = strtoupper($data['tentang'] ?? '-');
            $section->addText($tentang, ['bold' => true], ['alignment' => Jc::CENTER]);
            $section->addTextBreak(1);
            $section->addText('DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG', null, ['alignment' => Jc::CENTER]);
            $section->addTextBreak(1);

            // Layout Table for Menimbang/Mengingat
            $phpWord->addTableStyle('LayoutTable', ['borderSize' => 0, 'cellMargin' => 40]);
            
            // Menimbang
            $mt = $section->addTable('LayoutTable');
            $mt->addRow();
            $mt->addCell((int) Converter::inchToTwip(1.2))->addText('Menimbang');
            $mt->addCell((int) Converter::inchToTwip(0.2))->addText(':');
            $contentCell = $mt->addCell((int) Converter::inchToTwip(6.0));
            
            $menimbangLines = preg_split('/\r\n|\r|\n/', trim($data['menimbang'] ?? ''));
            foreach ($menimbangLines as $line) {
                if (trim($line) === '') continue;
                $contentCell->addText(trim($line), null, ['alignment' => Jc::BOTH]);
            }

            // Mengingat
            $mg = $section->addTable('LayoutTable');
            $mg->addRow();
            $mg->addCell((int) Converter::inchToTwip(1.2))->addText('Mengingat');
            $mg->addCell((int) Converter::inchToTwip(0.2))->addText(':');
            $contentCell = $mg->addCell((int) Converter::inchToTwip(6.0));
            
            $mengingatLines = preg_split('/\r\n|\r|\n/', trim($data['mengingat'] ?? ''));
            foreach ($mengingatLines as $line) {
                if (trim($line) === '') continue;
                $contentCell->addText(trim($line), null, ['alignment' => Jc::BOTH]);
            }

            $section->addTextBreak(1);
            $section->addText('MEMUTUSKAN', ['bold' => true], ['alignment' => Jc::CENTER]);
            $section->addTextBreak(1);

            // Menetapkan
            $m = $section->addTable('LayoutTable');
            $m->addRow();
            $m->addCell((int) Converter::inchToTwip(1.2))->addText('Menetapkan');
            $m->addCell((int) Converter::inchToTwip(0.2))->addText(':');
            $m->addCell((int) Converter::inchToTwip(6.0))->addText(trim($data['menetapkan'] ?? ''), ['bold' => true]);

            // Items (KESATU, KEDUA, etc)
            $memutuskanText = $data['memutuskan'] ?? '';
            $lines = explode("\n", $memutuskanText);
            $currentLabel = '';
            $currentText = '';
            $items = [];
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                if (preg_match('/^(KESATU|KEDUA|KETIGA|KEEMPAT|KELIMA|KEENAM|KETUJUH|KEDELAPAN|KESEMBILAN|KESEPULUH)$/i', $line)) {
                    if ($currentLabel) { $items[] = ['label' => $currentLabel, 'text' => trim($currentText)]; }
                    $currentLabel = $line; $currentText = '';
                } else { $currentText .= ' ' . $line; }
            }
            if ($currentLabel) { $items[] = ['label' => $currentLabel, 'text' => trim($currentText)]; }

            foreach ($items as $item) {
                $m = $section->addTable('LayoutTable');
                $m->addRow();
                $m->addCell((int) Converter::inchToTwip(1.2))->addText(strtoupper($item['label']));
                $m->addCell((int) Converter::inchToTwip(0.2))->addText(':');
                $m->addCell((int) Converter::inchToTwip(6.0))->addText($item['text'], null, ['alignment' => Jc::BOTH]);
            }

            $section->addTextBreak(2);

            // Footer / Signature
            $footerTable = $section->addTable('LayoutTable');
            $footerTable->addRow();
            $footerTable->addCell((int) Converter::inchToTwip(4.0));
            $signCell = $footerTable->addCell((int) Converter::inchToTwip(3.5));
            
            $signCell->addText('Ditetapkan di Gemolong', null, ['alignment' => Jc::LEFT]);
            $tanggal = isset($data['tanggal_dibuat']) ? \Carbon\Carbon::parse($data['tanggal_dibuat'])->locale('id')->translatedFormat('j F Y') : '.......................';
            $signCell->addText('pada tanggal ' . $tanggal, null, ['alignment' => Jc::LEFT]);
            $signCell->addTextBreak(1);
            $signCell->addText('DIREKTUR RSUD dr. SOERATNO GEMOLONG', null, ['alignment' => Jc::CENTER]);
            $signCell->addText('KABUPATEN SRAGEN', null, ['alignment' => Jc::CENTER]);
            $signCell->addTextBreak(3);
            
            $pejabatNama = trim($data['pejabat_nama'] ?? '') ?: 'Dr. dr. KINIK DARSONO, M.Pd.Ked.';
            $signCell->addText($pejabatNama, ['underline' => 'single', 'bold' => true], ['alignment' => Jc::CENTER]);
            $signCell->addText('NIP. 19710415 200903 1 001', null, ['alignment' => Jc::CENTER]);

            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
            $tempFile = tempnam(sys_get_temp_dir(), 'phpword');
            $objWriter->save($tempFile);

            $fileName = 'SK Direktur-' . str_replace(['/', '\\', '*', ':', '?', '"', '<', '>', '|'], '-', $surat->nomor_surat) . '.docx';
            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat file: ' . $e->getMessage());
        }
    }
}
