<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratUndangan;
use Exception;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Shared\Converter;

class SuratUndanganDocxController extends Controller
{
    public function download($id)
    {
        try {
            $surat = Surat::with('suratUndangan')->findOrFail($id);
            
            if (!$surat->suratUndangan) {
                return redirect()->back()->with('error', 'Data Surat Undangan tidak ditemukan');
            }
            
            $undangan = $surat->suratUndangan;
            
            $data = [
                'nomor_surat' => (string)($undangan->nomor_surat ?? '-'),
                'lampiran' => (string)($undangan->lampiran ?? '-'),
                'hal' => (string)($undangan->hal ?? '-'),
                'kepada' => (string)($undangan->kepada ?? '-'),
                'tempat_dibuat' => (string)($undangan->tempat_dibuat ?? 'Gemolong'),
                'tanggal_dibuat' => (string)($undangan->tanggal_dibuat ?? now()->format('Y-m-d')),
                'hari_acara' => (string)($undangan->hari_acara ?? '-'),
                'tanggal_acara' => (string)($undangan->tanggal_acara ?? now()->format('Y-m-d')),
                'nama_kegiatan' => (string)($undangan->nama_kegiatan ?? '-'),
                'jam_mulai' => (string)($undangan->jam_mulai ?? '-'),
                'jam_selesai' => (string)($undangan->jam_selesai ?? ''),
                'keterangan_waktu' => (string)($undangan->keterangan_waktu ?? ''),
                'tempat_acara' => (string)($undangan->tempat_acara ?? '-'),
                'keperluan' => (string)($undangan->keperluan ?? ''),
                'jabatan_tertanda' => (string)($undangan->jabatan_tertanda ?? 'Direktur RSUD dr. Soeratno Gemolong'),
                'nama_tertanda' => (string)($undangan->nama_tertanda ?? 'Dr. dr. Kinik Darsono, M.Pd.Ked.'),
                'nip_tertanda' => (string)($undangan->nip_tertanda ?? '19710415 200903 1 001'),
            ];

            $phpWord = new PhpWord();
            $phpWord->setDefaultFontName('Times New Roman');
            $phpWord->setDefaultFontSize(12);
            $phpWord->setDefaultParagraphStyle(['spaceAfter' => 0, 'lineHeight' => 1.15]);

            $section = $phpWord->addSection([
                'marginTop' => (int) Converter::inchToTwip(0.33),
                'marginBottom' => (int) Converter::inchToTwip(0.19),
                'marginLeft' => (int) Converter::inchToTwip(0.7),
                'marginRight' => (int) Converter::inchToTwip(0.7),
                'pageSizeW' => (int) Converter::inchToTwip(8.27),
                'pageSizeH' => (int) Converter::inchToTwip(13),
            ]);

            $phpWord->addTableStyle('HeaderTable', [
                'borderSize' => 0,
                'cellMargin' => 0,
                'borderColor' => 'FFFFFF'
            ]);
            $table = $section->addTable('HeaderTable');
            $table->addRow();

            $logoLeftPath = public_path('img/logo-sragen-kop.jpg');
            if (file_exists($logoLeftPath)) {
                $table->addCell((int) Converter::inchToTwip(0.8), ['valign' => 'center'])->addImage($logoLeftPath, [
                    'height' => (int) Converter::inchToPoint(0.82),
                    'width' => (int) Converter::inchToPoint(0.65),
                    'wrappingStyle' => 'inline'
                ]);
            } else {
                $table->addCell((int) Converter::inchToTwip(0.8), ['valign' => 'center']);
            }

            $centerCell = $table->addCell((int) Converter::inchToTwip(5.27), ['valign' => 'center']);
            $centerCell->addText('PEMERINTAH KABUPATEN SRAGEN', ['name' => 'Arial', 'size' => 13], ['alignment' => Jc::CENTER]);
            $centerCell->addText('RSUD dr. SOERATNO GEMOLONG', ['name' => 'Arial', 'bold' => true, 'size' => 17], ['alignment' => Jc::CENTER]);
            $centerCell->addTextBreak(1, ['size' => 12]);
            $centerCell->addText('Jalan R. Ngt. Tjitrosantjoko 10, Gemolong, Sragen, Jawa Tengah 57274', ['name' => 'Arial', 'size' => 9], ['alignment' => Jc::CENTER]);

            $contactRun = $centerCell->addTextRun(['alignment' => Jc::CENTER, 'lineHeight' => 1.2]);
            $contactRun->addText('Telepon (0271) 6811839, Laman ', ['name' => 'Arial', 'size' => 8]);
            $contactRun->addLink('https://rsudgemolong.sragenkab.go.id', 'https://rsudgemolong.sragenkab.go.id', ['name' => 'Arial', 'size' => 8, 'color' => '0000FF']);
            $contactRun->addText(', Pos-el rsudgemolong@gmail.com', ['name' => 'Arial', 'size' => 8]);

            $logoRightPath = public_path('img/logo-rs-kop.png');
            if (file_exists($logoRightPath)) {
                $table->addCell((int) Converter::inchToTwip(0.8), ['valign' => 'center'])->addImage($logoRightPath, [
                    'height' => (int) Converter::inchToPoint(0.8),
                    'width' => (int) Converter::inchToPoint(0.75),
                    'wrappingStyle' => 'inline',
                    'alignment' => Jc::RIGHT
                ]);
            } else {
                $table->addCell((int) Converter::inchToTwip(0.8), ['valign' => 'center']);
            }

            $borderTable = $section->addTable(['cellMargin' => 0]);
            $borderTable->addRow(null, ['cantSplit' => true]);
            $borderTable->addCell((int) Converter::inchToTwip(6.87), [
                'borderBottomSize' => 12,
                'borderBottomColor' => '000000',
                'borderBottomStyle' => 'single'
            ])->addText('', null, ['lineHeight' => 0.5]);

            $section->addTextBreak(1);

            $tanggalDibuat = $data['tanggal_dibuat'] ?? now()->format('Y-m-d');
            if ($tanggalDibuat instanceof \Carbon\Carbon) {
                $tanggalDate = $tanggalDibuat;
            } else {
                try {
                    $tanggalDate = \Carbon\Carbon::createFromFormat('Y-m-d', $tanggalDibuat);
                } catch (\Exception $e) {
                    $tanggalDate = \Carbon\Carbon::now();
                }
            }
            
            $tanggalStr = ($data['tempat_dibuat'] ?? 'Gemolong') . ', ' . $tanggalDate->locale('id')->translatedFormat('j F Y');
            $section->addText($tanggalStr, ['name' => 'Times New Roman', 'size' => 12], ['alignment' => Jc::RIGHT]);

            $section->addTextBreak(2);

            $phpWord->addTableStyle('InfoTable', [
                'borderSize' => 0,
                'cellMargin' => 0,
                'borderColor' => 'FFFFFF'
            ]);

            $infoTable = $section->addTable('InfoTable');
            
            $infoTable->addRow();
            $infoTable->addCell((int) Converter::inchToTwip(1.2))->addText('Nomor', ['name' => 'Times New Roman', 'size' => 12]);
            $infoTable->addCell((int) Converter::inchToTwip(0.2))->addText(':', ['name' => 'Times New Roman', 'size' => 12]);
            $infoTable->addCell((int) Converter::inchToTwip(5.47))->addText($data['nomor_surat'] ?? '-', ['name' => 'Times New Roman', 'size' => 12]);

            $infoTable->addRow();
            $infoTable->addCell((int) Converter::inchToTwip(1.2))->addText('Lampiran', ['name' => 'Times New Roman', 'size' => 12]);
            $infoTable->addCell((int) Converter::inchToTwip(0.2))->addText(':', ['name' => 'Times New Roman', 'size' => 12]);
            $infoTable->addCell((int) Converter::inchToTwip(5.47))->addText($data['lampiran'] ?? '-', ['name' => 'Times New Roman', 'size' => 12]);

            $infoTable->addRow();
            $infoTable->addCell((int) Converter::inchToTwip(1.2))->addText('Hal', ['name' => 'Times New Roman', 'size' => 12]);
            $infoTable->addCell((int) Converter::inchToTwip(0.2))->addText(':', ['name' => 'Times New Roman', 'size' => 12]);
            $infoTable->addCell((int) Converter::inchToTwip(5.47))->addText($data['hal'] ?? 'Undangan', ['name' => 'Times New Roman', 'size' => 12]);

            $section->addText('', null, []);

            $section->addText('Yth. ' . ($data['kepada'] ?? 'Terlampir'), ['name' => 'Times New Roman', 'size' => 12]);
            $section->addText('di -', ['name' => 'Times New Roman', 'size' => 12], ['indentation' => ['left' => 360]]);
            $section->addText('T E M P A T', ['name' => 'Times New Roman', 'size' => 12], ['indentation' => ['left' => 720]]);

            $section->addTextBreak(1);

            $section->addText('Dengan hormat,', ['name' => 'Times New Roman', 'size' => 12], ['alignment' => Jc::BOTH]);
            $namaKegiatan = trim($data['nama_kegiatan'] ?? 'kegiatan');
            $section->addText('Sehubungan dengan pelaksanaan kegiatan ' . $namaKegiatan . ', kami mengundang Bapak/Ibu untuk menghadiri kegiatan dimaksud yang akan dilaksanakan pada:', ['name' => 'Times New Roman', 'size' => 12], ['alignment' => Jc::BOTH]);

            $section->addTextBreak(1);

            $acaraTable = $section->addTable('InfoTable');
            
            $tanggalAcara = $data['tanggal_acara'] ?? now()->format('Y-m-d');
            if ($tanggalAcara instanceof \Carbon\Carbon) {
                $tanggalAcaraDate = $tanggalAcara;
            } else {
                try {
                    $tanggalAcaraDate = \Carbon\Carbon::createFromFormat('Y-m-d', $tanggalAcara);
                } catch (\Exception $e) {
                    $tanggalAcaraDate = \Carbon\Carbon::now();
                }
            }
            
            $hariAcara = trim($data['hari_acara'] ?? '-');
            $tanggalAcaraStr = $hariAcara . ', ' . $tanggalAcaraDate->locale('id')->translatedFormat('j F Y');
            
            $acaraTable->addRow();
            $acaraTable->addCell((int) Converter::inchToTwip(1.5))->addText('Hari/ Tanggal', ['name' => 'Times New Roman', 'size' => 12]);
            $acaraTable->addCell((int) Converter::inchToTwip(0.2))->addText(':', ['name' => 'Times New Roman', 'size' => 12]);
            $acaraTable->addCell((int) Converter::inchToTwip(5.17))->addText($tanggalAcaraStr, ['name' => 'Times New Roman', 'size' => 12]);

            $jamMulai = trim($data['jam_mulai'] ?? '');
            $jamSelesai = trim($data['jam_selesai'] ?? '');
            $keteranganWaktu = trim($data['keterangan_waktu'] ?? '');
            $jamText = $jamMulai;

            if (!empty($jamSelesai)) {
                $jamText = trim($jamText . ' s.d. ' . $jamSelesai);
            }

            if (!empty($keteranganWaktu)) {
                $jamText = trim($jamText . ' ' . $keteranganWaktu);
            }

            if (empty($jamText)) {
                $jamText = '-';
            }
            
            $acaraTable->addRow();
            $acaraTable->addCell((int) Converter::inchToTwip(1.5))->addText('Jam', ['name' => 'Times New Roman', 'size' => 12]);
            $acaraTable->addCell((int) Converter::inchToTwip(0.2))->addText(':', ['name' => 'Times New Roman', 'size' => 12]);
            $acaraTable->addCell((int) Converter::inchToTwip(5.17))->addText($jamText, ['name' => 'Times New Roman', 'size' => 12]);

            $acaraTable->addRow();
            $acaraTable->addCell((int) Converter::inchToTwip(1.5))->addText('Tempat', ['name' => 'Times New Roman', 'size' => 12]);
            $acaraTable->addCell((int) Converter::inchToTwip(0.2))->addText(':', ['name' => 'Times New Roman', 'size' => 12]);
            $acaraTable->addCell((int) Converter::inchToTwip(5.17))->addText($data['tempat_acara'] ?? '-', ['name' => 'Times New Roman', 'size' => 12]);

            if (!empty($data['keperluan'])) {
                $acaraTable->addRow();
                $acaraTable->addCell((int) Converter::inchToTwip(1.5))->addText('Keperluan', ['name' => 'Times New Roman', 'size' => 12]);
                $acaraTable->addCell((int) Converter::inchToTwip(0.2))->addText(':', ['name' => 'Times New Roman', 'size' => 12]);
                $acaraTable->addCell((int) Converter::inchToTwip(5.17))->addText($data['keperluan'], ['name' => 'Times New Roman', 'size' => 12]);
            }

            $section->addText('', null, []);

            $section->addText('Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Bapak/Ibu, kami ucapkan terima kasih.', ['name' => 'Times New Roman', 'size' => 12], ['alignment' => Jc::BOTH]);

            $section->addTextBreak(3);

            $signTable = $section->addTable('InfoTable');
            $signTable->addRow();
            $signTable->addCell((int) Converter::inchToTwip(3.5));
            $signCell = $signTable->addCell((int) Converter::inchToTwip(3.37));

            $signCell->addText($data['jabatan_tertanda'] ?? 'Direktur RSUD dr. Soeratno Gemolong', ['name' => 'Times New Roman', 'size' => 12], ['alignment' => Jc::CENTER]);
            
            $signCell->addText('', null, ['lineHeight' => 1.0]);
            $signCell->addTextBreak(2);

            $signCell->addText($data['nama_tertanda'] ?? 'Dr. dr. Kinik Darsono, M.Pd.Ked.', ['name' => 'Times New Roman', 'size' => 12], ['alignment' => Jc::CENTER]);
            $signCell->addText('NIP. ' . ($data['nip_tertanda'] ?? '19710415 200903 1 001'), ['name' => 'Times New Roman', 'size' => 12], ['alignment' => Jc::CENTER]);

            try {
                $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
            } catch (Exception $e) {
                \Illuminate\Support\Facades\Log::error('PhpWord IOFactory error: ' . $e->getMessage());
                throw new Exception('Gagal membuat DOCX writer: ' . $e->getMessage());
            }

            try {
                $tempFile = tempnam(sys_get_temp_dir(), 'phpword_');
                if (!$tempFile) {
                    throw new Exception('Gagal membuat temporary file');
                }
                $objWriter->save($tempFile);
            } catch (Exception $e) {
                \Illuminate\Support\Facades\Log::error('PhpWord save error: ' . $e->getMessage());
                throw new Exception('Gagal menyimpan DOCX: ' . $e->getMessage());
            }

            $fileName = 'Surat Undangan-' . str_replace(['/', '\\', '*', ':', '?', '"', '<', '>', '|'], '-', $surat->nomor_surat) . '.docx';
            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error('SuratUndangan DOCX download error: ' . $e->getMessage(), ['surat_id' => $id]);
            return redirect()->back()->with('error', 'Gagal membuat file: ' . $e->getMessage());
        }
    }
}
