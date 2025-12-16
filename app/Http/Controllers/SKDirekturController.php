<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;

class SKDirekturController extends Controller
{
    public function downloadWord($id)
    {
        $surat = Surat::with('skDirektur')->findOrFail($id);

        $path = storage_path('app/' . $surat->file_path);
        if (!$surat->file_path || !file_exists($path)) {
            return back()->with('error', 'File surat tidak ditemukan.');
        }

        $outputPath = storage_path('app/temp/' . $surat->nomor_surat . '.docx');
        if (!is_dir(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }

        try {
            $cleanNomor = preg_replace('/\s+/', '_', trim($surat->nomor_surat));
            $cleanNomor = preg_replace('/[^a-zA-Z0-9_]/', '', $cleanNomor);
            $tanggal = \Carbon\Carbon::parse($surat->tanggal_dibuat)->format('d-m-Y');
            $filename = "{$cleanNomor}_{$tanggal}.docx";

            $phpWord = $this->buildPhpWordDocument($surat, 'Word2007');
            $writer = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save($outputPath);

            return response()->download($outputPath, $filename)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            \Log::error('Error converting to Word: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengkonversi file ke format Word.');
        }
    }

    public function downloadRTF($id)
    {
        $surat = Surat::with('skDirektur')->findOrFail($id);

        $path = storage_path('app/' . $surat->file_path);
        if (!$surat->file_path || !file_exists($path)) {
            return back()->with('error', 'File surat tidak ditemukan.');
        }

        $outputPath = storage_path('app/temp/' . $surat->nomor_surat . '.rtf');
        if (!is_dir(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }

        try {
            $cleanNomor = preg_replace('/\s+/', '_', trim($surat->nomor_surat));
            $cleanNomor = preg_replace('/[^a-zA-Z0-9_]/', '', $cleanNomor);
            $tanggal = \Carbon\Carbon::parse($surat->tanggal_dibuat)->format('d-m-Y');
            $filename = "{$cleanNomor}_{$tanggal}.rtf";

            $phpWord = $this->buildPhpWordDocument($surat, 'RTF');
            $writer = IOFactory::createWriter($phpWord, 'RTF');
            $writer->save($outputPath);

            return response()->download($outputPath, $filename)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            \Log::error('Error converting to RTF: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengkonversi file ke format RTF.');
        }
    }

    private function buildPhpWordDocument(Surat $surat, $writerType = 'Word2007'): PhpWord
    {
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(12);

        $section = $phpWord->addSection([
            'marginTop' => Converter::cmToTwip(2.0),
            'marginRight' => Converter::cmToTwip(1.5),
            'marginBottom' => Converter::cmToTwip(2.0),
            'marginLeft' => Converter::cmToTwip(1.5),
        ]);

        $sk = $surat->skDirektur;
        $judul = $sk->judul_surat ?? $surat->nama_surat ?? '';
        $nomor = $sk->nomor_surat ?? $surat->nomor_surat ?? '';
        $tentang = $sk->tentang ?? '';
        $menimbang = $sk->menimbang ?? '';
        $mengingat = $sk->mengingat ?? '';
        $menetapkan = $sk->menetapkan ?? '';
        $memutuskan = $sk->memutuskan ?? '';
        $tempat = $sk->tempat_dibuat ?? $surat->lokasi_surat ?? 'Gemolong';
        $tanggal = $sk->tanggal_dibuat ?? $surat->tanggal_dibuat ?? now();
        $pejabatNama = $surat->pejabat_nama ?? 'KINIK DARSONO';
        $pejabatNip = $surat->pejabat_nip ?? '';

        $logoLeftPath = public_path('img/logo-sragen-kop.jpg');
        $logoRightPath = public_path('img/logo-rs-kop.png');
        if ($writerType === 'Word2007') {
            $headerTable = $section->addTable(['borderSize' => 0, 'borderColor' => 'ffffff']);
            $headerTable->addRow();
            $cellLogoLeft = $headerTable->addCell(1500, ['valign' => 'center']);
            if (file_exists($logoLeftPath)) {
                $cellLogoLeft->addImage($logoLeftPath, ['width' => 65, 'height' => 65, 'alignment' => 'left']);
            }
            $cellText = $headerTable->addCell(7000, ['valign' => 'center']);
            $cellText->addText('PEMERINTAH KABUPATEN SRAGEN', ['name' => 'Arial', 'size' => 12, 'bold' => false], ['alignment' => 'center']);
            $cellText->addText('RSUD dr. SOERATNO GEMOLONG', ['name' => 'Arial', 'size' => 12, 'bold' => true], ['alignment' => 'center', 'spaceAfter' => 40]);
            $cellText->addText('Jalan R. Ngt. Tjitrosantjoko 10, Gemolong, Sragen, Jawa Tengah 57274', ['name' => 'Arial', 'size' => 10], ['alignment' => 'center']);
            $cellText->addText('Telepon (0271) 6811839, Laman rsudgemolong.sragenkab.go.id, Pos-el rsudgemolong@gmail.com', ['name' => 'Arial', 'size' => 10], ['alignment' => 'center', 'spaceAfter' => 120]);
            $cellLogoRight = $headerTable->addCell(1500, ['valign' => 'center']);
            if (file_exists($logoRightPath)) {
                $cellLogoRight->addImage($logoRightPath, ['width' => 65, 'height' => 65, 'alignment' => 'right']);
            }
        } else {
            $section->addText('PEMERINTAH KABUPATEN SRAGEN', ['name' => 'Arial', 'size' => 12, 'bold' => false], ['alignment' => 'center']);
            $section->addText('RSUD dr. SOERATNO GEMOLONG', ['name' => 'Arial', 'size' => 12, 'bold' => true], ['alignment' => 'center', 'spaceAfter' => 40]);
            $section->addText('Jalan R. Ngt. Tjitrosantjoko 10, Gemolong, Sragen, Jawa Tengah 57274', ['name' => 'Arial', 'size' => 10], ['alignment' => 'center']);
            $section->addText('Telepon (0271) 6811839, Laman rsudgemolong.sragenkab.go.id, Pos-el rsudgemolong@gmail.com', ['name' => 'Arial', 'size' => 10], ['alignment' => 'center', 'spaceAfter' => 120]);
        }

        if ($writerType === 'Word2007') {
            $section->addLine(['weight' => 3, 'width' => 450, 'height' => 0]);
        } else {
            $section->addText(str_repeat('_', 80), ['name' => 'Times New Roman', 'size' => 8], ['alignment' => 'center', 'spaceAfter' => 40]);
        }

        $section->addText('KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG', ['name' => 'Times New Roman', 'size' => 11.5], ['alignment' => 'center']);
        $section->addText('NOMOR : ' . ($nomor ?: '-'), ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'center']);
        $section->addText('TENTANG', ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'center']);
        $section->addText(strtoupper($tentang ?: '-'), ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'center', 'spaceAfter' => 200]);

        $section->addText('DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG', ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'center', 'spaceAfter' => 200]);

        $section->addText('Menimbang :', ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'left']);
        $menimbangLines = preg_split('/\r\n|\r|\n/', trim($menimbang));
        $menimbangLines = array_filter($menimbangLines, fn($line) => trim($line) !== '');
        $menimbangLines = array_map(fn($line) => preg_replace('/^[a-z]\.\s*/', '', trim($line)), $menimbangLines);
        $alpha = 'abcdefghijklmnopqrstuvwxyz';
        $i = 0;
        foreach ($menimbangLines as $line) {
            $section->addText('     ' . $alpha[$i] . '. ' . trim($line), ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'both']);
            $i++;
        }

        $section->addText('Mengingat :', ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'left']);
        $rawMengingat = trim($mengingat);
        $mLines = [];
        $lines = preg_split('/\r\n|\r|\n/', $rawMengingat);
        $lines = array_filter($lines, fn($l) => trim($l) !== '');
        $allIds = true;
        $ids = [];
        foreach ($lines as $line) {
            $content = preg_replace('/^\d+\.\s*/', '', trim($line));
            if (preg_match('/^\d+$/', $content)) { $ids[] = (int)$content; } else { $allIds = false; break; }
        }
        if ($allIds && count($ids) > 0) {
            $regs = \App\Models\Regulasi::whereIn('id_regulasi', $ids)
                ->orderByRaw('FIELD(id_regulasi,' . implode(',', $ids) . ')')
                ->get();
            if ($regs->count() > 0) { $mLines = $regs->pluck('isi_regulasi')->toArray(); }
        }
        if (empty($mLines)) {
            foreach ($lines as $line) { $content = preg_replace('/^\d+\.\s*/', '', trim($line)); if ($content !== '') { $mLines[] = $content; } }
        }
        $n = 1;
        foreach ($mLines as $line) {
            $section->addText('     ' . $n . '. ' . trim($line), ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'both']);
            $n++;
        }

        $section->addText('MEMUTUSKAN', ['name' => 'Times New Roman', 'size' => 12.5], ['alignment' => 'center']);
        if (!empty(trim($menetapkan))) { $section->addText('Menetapkan : ' . $menetapkan, ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'both']); }
        else { $section->addText('Menetapkan : ', ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'both']); }

        $memText = $memutuskan; $lines = explode("\n", $memText); $currentLabel = ''; $currentText = ''; $items = [];
        foreach ($lines as $line) { $line = trim($line); if (empty($line)) continue; if (preg_match('/^(MENETAPKAN|KESATU|KEDUA|KETIGA|KEEMPAT|KELIMA|KEENAM|KETUJUH|KEDELAPAN|KESEMBILAN|KESEPULUH)$/i', $line)) { if ($currentLabel) { $items[] = ['label' => $currentLabel, 'text' => trim($currentText)]; } $currentLabel = $line; $currentText = ''; } else { $currentText .= ' ' . $line; } }
        if ($currentLabel) { $items[] = ['label' => $currentLabel, 'text' => trim($currentText)]; }
        usort($items, function ($a, $b) { $order = ['MENETAPKAN' => 0, 'KESATU' => 1, 'KEDUA' => 2, 'KETIGA' => 3, 'KEEMPAT' => 4, 'KELIMA' => 5, 'KEENAM' => 6, 'KETUJUH' => 7, 'KEDELAPAN' => 8, 'KESEMBILAN' => 9, 'KESEPULUH' => 10]; return ($order[strtoupper($a['label'])] ?? 99) <=> ($order[strtoupper($b['label'])] ?? 99); });
        foreach ($items as $item) {
            $labelText = ucfirst(strtolower($item['label']));
            $section->addText($labelText . ' : ' . $item['text'], ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'both']);
        }

        $section->addText('Ditetapkan di ' . $tempat, ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'right']);
        $section->addText('Pada tanggal ' . \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('j F Y'), ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'right']);
        $section->addText('DIREKTUR RSUD dr. SOERATNO GEMOLONG', ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'right']);
        $section->addText('KABUPATEN SRAGEN', ['name' => 'Times New Roman', 'size' => 12], ['alignment' => 'right']);
        $section->addText($pejabatNama, ['name' => 'Times New Roman', 'size' => 12, 'underline' => 'single'], ['alignment' => 'right']);
        if (!empty($pejabatNip)) { $section->addText('NIP. ' . $pejabatNip, ['name' => 'Times New Roman', 'size' => 12.5], ['alignment' => 'right']); }

        return $phpWord;
    }
}
