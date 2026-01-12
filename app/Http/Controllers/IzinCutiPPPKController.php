<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratIzinCuti;
use App\Models\Pegawai;
use Exception;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Shared\Converter;

class IzinCutiPPPKController extends Controller
{
    public function download($id)
    {
        try {
            $surat = Surat::findOrFail($id);
            $cuti = SuratIzinCuti::where('id_surat', $id)->firstOrFail();
            $data = $cuti->form_data['form'] ?? $cuti->form_data;

            $phpWord = new PhpWord();
            $phpWord->setDefaultFontName('Times New Roman');
            $phpWord->setDefaultFontSize(10);
            $phpWord->setDefaultParagraphStyle(['spaceAfter' => 0, 'lineHeight' => 1.0]);

            $section = $phpWord->addSection([
                'marginTop' => (int) Converter::inchToTwip(0.35),
                'marginBottom' => (int) Converter::inchToTwip(0.35),
                'marginLeft' => (int) Converter::inchToTwip(0.5),
                'marginRight' => (int) Converter::inchToTwip(0.5),
            ]);

            $formatTanggalIndonesia = function ($tanggal) {
                if (empty($tanggal))
                    return '';
                $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
                $timestamp = strtotime($tanggal);
                $hari = date('d', $timestamp);
                $bulanAngka = date('n', $timestamp);
                $tahun = date('Y', $timestamp);
                return $hari . ' ' . $bulan[$bulanAngka] . ' ' . $tahun;
            };

            $phpWord->addTableStyle('CutiTable', ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 20]);
            $phpWord->addTableStyle('NoBorderTable', ['borderSize' => 0, 'borderColor' => 'FFFFFF', 'cellMargin' => 20]);

            $table = $section->addTable('NoBorderTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(3.2));
            $rightCell = $table->addCell((int) Converter::inchToTwip(4.07));
            $rightCell->addText('PERATURAN BADAN KEPEGAWAIAN NEGARA REPUBLIK INDONESIA NOMOR 7 TAHUN 2022');
            $rightCell->addText('TENTANG');
            $rightCell->addText('TATA CARA PEMBERIAN CUTI PEGAWAI PEMERINTAH DENGAN PERJANJIAN KERJA');

            $section->addTextBreak(1, ['spaceAfter' => (int) Converter::inchToTwip(0.1)]);
            $section->addText('Formulir Permintaan dan Pemberian Cuti Pegawai Pemerintah Dengan Perjanjian Kerja', null, ['alignment' => Jc::CENTER]);
            $section->addTextBreak(1, ['spaceAfter' => (int) Converter::inchToTwip(0.1)]);

            $table = $section->addTable('NoBorderTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(3.5));
            $rightCell = $table->addCell((int) Converter::inchToTwip(3.77));
            $rightCell->addText(($data['tempat_surat'] ?? 'Sragen') . ', ' . (isset($data['tanggal_surat']) ? $formatTanggalIndonesia($data['tanggal_surat']) : '.......................'));
            $rightCell->addText('kepada :');
            $rightCell->addText('Yth. Direktur RSUD dr. Soeratno Gemolong');
            $rightCell->addText('      Kabupaten Sragen');
            $rightCell->addText('         di-');
            $rightCell->addText('            SRAGEN');

            $section->addTextBreak(1, ['spaceAfter' => (int) Converter::inchToTwip(0.1)]);
            $section->addText('FORMULIR PERMINTAAN DAN PEMBERIAN CUTI', null, ['alignment' => Jc::CENTER]);
            $section->addTextBreak(1, ['spaceAfter' => (int) Converter::inchToTwip(0.1)]);

            // I. DATA PEGAWAI
            $table = $section->addTable('CutiTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(7.27), ['gridSpan' => 4])->addText('I. DATA PEGAWAI');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(1.09))->addText('Nama');
            $table->addCell((int) Converter::inchToTwip(2.91))->addText($data['nama'] ?? '');
            $table->addCell((int) Converter::inchToTwip(1.09))->addText('NIP');
            $table->addCell((int) Converter::inchToTwip(2.18))->addText($data['nip'] ?? '');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(1.09))->addText('Jabatan');
            $table->addCell((int) Converter::inchToTwip(2.91))->addText($data['jabatan'] ?? '');
            $table->addCell((int) Converter::inchToTwip(1.09))->addText('Masa Kerja');
            $tahun = isset($data['masa_kerja_tahun']) && $data['masa_kerja_tahun'] !== '' ? $data['masa_kerja_tahun'] : 0;
            $bulan = isset($data['masa_kerja_bulan']) && $data['masa_kerja_bulan'] !== '' ? $data['masa_kerja_bulan'] : 0;
            $mk = $tahun . ' th ' . $bulan . ' bln';
            $table->addCell((int) Converter::inchToTwip(2.18))->addText($mk);
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(1.09))->addText('Unit Kerja');
            $table->addCell(null, ['gridSpan' => 3])->addText($data['unit'] ?? 'RSUD dr. Soeratno Gemolong');

            $section->addTextBreak(1, ['spaceAfter' => (int) Converter::inchToTwip(1.5)]);

            // II. JENIS CUTI YANG DIAMBIL 
            $table = $section->addTable('CutiTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(7.27), ['gridSpan' => 2])->addText('II. JENIS CUTI YANG DIAMBIL**');

            $jenisCuti = $data['jenis_cuti'] ?? '';
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(4.00))->addText('1. Cuti Tahunan');
            $table->addCell((int) Converter::inchToTwip(3.27))->addText($jenisCuti == 'Cuti Tahunan' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(4.00))->addText('2. Cuti Sakit');
            $table->addCell((int) Converter::inchToTwip(3.27))->addText($jenisCuti == 'Cuti Sakit' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(4.00))->addText('3. Cuti Melahirkan');
            $table->addCell((int) Converter::inchToTwip(3.27))->addText($jenisCuti == 'Cuti Melahirkan' ? 'V' : '', null, ['alignment' => Jc::CENTER]);

            $section->addTextBreak(1, ['spaceAfter' => (int) Converter::inchToTwip(1.5)]);

            // III. ALASAN CUTI
            $table = $section->addTable('CutiTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(7.27))->addText('III. ALASAN CUTI');
            $table->addRow();
            $table->addCell()->addText($data['alasan'] ?? '', null, ['alignment' => Jc::LEFT]);

            $section->addTextBreak(1, ['spaceAfter' => (int) Converter::inchToTwip(1.5)]);

            // IV. LAMANYA CUTI
            $table = $section->addTable('CutiTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(7.27), ['gridSpan' => 6])->addText('IV. LAMANYA CUTI');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(0.7))->addText('Selama');
            $table->addCell((int) Converter::inchToTwip(1.0))->addText(($data['lama_cuti'] ?? '') . ' hari');
            $table->addCell((int) Converter::inchToTwip(1.3))->addText('mulai tanggal');
            $table->addCell((int) Converter::inchToTwip(1.5))->addText(isset($data['mulai']) ? $formatTanggalIndonesia($data['mulai']) : '');
            $table->addCell((int) Converter::inchToTwip(0.5))->addText('s/d');
            $table->addCell((int) Converter::inchToTwip(1.27))->addText(isset($data['sampai']) ? $formatTanggalIndonesia($data['sampai']) : '');

            $section->addTextBreak(1, ['spaceAfter' => (int) Converter::inchToTwip(1.5)]);

            // V. CATATAN CUTI 
            $table = $section->addTable('CutiTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(7.27), ['gridSpan' => 2])->addText('V. CATATAN CUTI***');

            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(4.00))->addText('1. CUTI TAHUNAN');
            $table->addCell((int) Converter::inchToTwip(3.27))->addText($jenisCuti == 'Cuti Tahunan' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(4.00))->addText('2. CUTI SAKIT');
            $table->addCell((int) Converter::inchToTwip(3.27))->addText($jenisCuti == 'Cuti Sakit' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(4.00))->addText('3. CUTI MELAHIRKAN');
            $table->addCell((int) Converter::inchToTwip(3.27))->addText($jenisCuti == 'Cuti Melahirkan' ? 'V' : '', null, ['alignment' => Jc::CENTER]);

            $section->addTextBreak(1, ['spaceAfter' => (int) Converter::inchToTwip(1.5)]);

            // VI. ALAMAT SELAMA MENJALANKAN CUTI
            $table = $section->addTable('CutiTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(7.27), ['gridSpan' => 3])->addText('VI. ALAMAT SELAMA MENJALANKAN CUTI');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(4.0))->addText($data['alamat'] ?? '');
            $table->addCell((int) Converter::inchToTwip(1.0))->addText('TELP');
            $table->addCell((int) Converter::inchToTwip(2.27))->addText($data['telp'] ?? '');

            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(4.0));
            $signCell = $table->addCell((int) Converter::inchToTwip(3.27), ['gridSpan' => 2]);
            $signCell->addText('Hormat saya,', null, ['alignment' => Jc::CENTER]);
            $signCell->addTextBreak(3);
            $signCell->addText($data['nama'] ?? '', ['underline' => 'single'], ['alignment' => Jc::CENTER]);
            $signCell->addText('NIP. ' . ($data['nip'] ?? ''), null, ['alignment' => Jc::CENTER]);

            $section->addTextBreak(1, ['spaceAfter' => (int) Converter::inchToTwip(1.5)]);

            $phpWord->addTableStyle('ApprovalTable', ['borderSize' => 0, 'borderColor' => 'FFFFFF', 'cellMargin' => 20]);
            $defaultBorder = ['borderSize' => 6, 'borderColor' => '000000'];
            $noBottom = ['borderTopSize' => 6, 'borderLeftSize' => 6, 'borderRightSize' => 6, 'borderBottomSize' => 0, 'borderColor' => '000000'];
            $fullBorder = ['borderSize' => 6, 'borderColor' => '000000'];

            // VII. PERTIMBANGAN ATASAN LANGSUNG
            $table = $section->addTable('ApprovalTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(7.27), array_merge(['gridSpan' => 4], $fullBorder))->addText('VII. PERTIMBANGAN ATASAN LANGSUNG**');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(1.1), $fullBorder)->addText('DISETUJUI');
            $table->addCell((int) Converter::inchToTwip(1.3), $fullBorder)->addText('PERUBAHAN****');
            $table->addCell((int) Converter::inchToTwip(1.5), $fullBorder)->addText('DITANGGUHKAN****');
            $table->addCell((int) Converter::inchToTwip(3.37), $fullBorder)->addText('TIDAK DISETUJUI****');

            $table->addRow();
            $atasan = $data['atasan_setuju'] ?? '';
            $table->addCell((int) Converter::inchToTwip(1.1), $noBottom)->addText($atasan == 'DISETUJUI' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addCell((int) Converter::inchToTwip(1.3), $noBottom)->addText($atasan == 'PERUBAHAN' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addCell((int) Converter::inchToTwip(1.5), $noBottom)->addText($atasan == 'DITANGGUHKAN' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addCell((int) Converter::inchToTwip(3.37), $fullBorder)->addText($atasan == 'TIDAK DISETUJUI' ? 'V' : '', null, ['alignment' => Jc::CENTER]);

            $table->addRow();
            $emptyCell = $table->addCell((int) Converter::inchToTwip(3.9), [
                'gridSpan' => 3,
                'borderTopSize' => 0,
                'borderLeftSize' => 0,
                'borderRightSize' => 0,
                'borderBottomSize' => 0,
                'borderColor' => 'FFFFFF'
            ]);

            $signCell = $table->addCell((int) Converter::inchToTwip(3.37), [
                'gridSpan' => 1,
                'borderSize' => 6,
                'borderColor' => '000000'
            ]);
            $signCell->addText(strtoupper($data['jabatan_atasan'] ?? 'Atasan'), null, ['alignment' => Jc::CENTER]);
            $signCell->addTextBreak(3);
            $signCell->addText(strtoupper($data['nama_atasan'] ?? ''), ['underline' => 'single'], ['alignment' => Jc::CENTER]);
            $signCell->addText('NIP. ' . ($data['nip_atasan'] ?? ''), null, ['alignment' => Jc::CENTER]);

            $section->addTextBreak(1, ['spaceAfter' => (int) Converter::inchToTwip(1.5)]);

            // VIII. KEPUTUSAN PEJABAT
            $table = $section->addTable('ApprovalTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(7.27), array_merge(['gridSpan' => 4], $fullBorder))->addText('VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI**');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(1.1), $fullBorder)->addText('DISETUJUI');
            $table->addCell((int) Converter::inchToTwip(1.3), $fullBorder)->addText('PERUBAHAN****');
            $table->addCell((int) Converter::inchToTwip(1.5), $fullBorder)->addText('DITANGGUHKAN****');
            $table->addCell((int) Converter::inchToTwip(3.37), $fullBorder)->addText('TIDAK DISETUJUI****');

            $table->addRow();
            $pejabat = $data['pejabat_keputusan'] ?? '';
            $table->addCell((int) Converter::inchToTwip(1.1), $noBottom)->addText($pejabat == 'DISETUJUI' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addCell((int) Converter::inchToTwip(1.3), $noBottom)->addText($pejabat == 'PERUBAHAN' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addCell((int) Converter::inchToTwip(1.5), $noBottom)->addText($pejabat == 'DITANGGUHKAN' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addCell((int) Converter::inchToTwip(3.37), $fullBorder)->addText($pejabat == 'TIDAK DISETUJUI' ? 'V' : '', null, ['alignment' => Jc::CENTER]);

            $table->addRow();
            $catatanCell = $table->addCell((int) Converter::inchToTwip(3.9), [
                'gridSpan' => 3,
                'borderTopSize' => 0,
                'borderLeftSize' => 0,
                'borderRightSize' => 0,
                'borderBottomSize' => 0,
                'borderColor' => 'FFFFFF'
            ]);
            $catatanText = ['size' => 10];
            $catatanCell->addText('Catatan:', $catatanText);
            $catatanCell->addText('* Coret yang tidak perlu', $catatanText);
            $catatanCell->addText('** Pilih salah satu dengan memberi tanda centang (V)', $catatanText);
            $catatanCell->addText('*** diisi oleh pejabat yang menangani bidang kepegawaian', $catatanText);
            $catatanCell->addText('     sebelum PPPK mengajukan cuti', $catatanText);
            $catatanCell->addText('**** diberi tanda centang dan alasannya', $catatanText);

            $signCell = $table->addCell((int) Converter::inchToTwip(3.37), [
                'gridSpan' => 1,
                'borderSize' => 6,
                'borderColor' => '000000'
            ]);
            $signCell->addText('KEPUTUSAN PEJABAT YANG', null, ['alignment' => Jc::CENTER]);
            $signCell->addText('BERWENANG MEMBERIKAN CUTI', null, ['alignment' => Jc::CENTER]);
            $signCell->addText('DIREKTUR RSUD dr. SOERATNO GEMOLONG', null, ['alignment' => Jc::CENTER]);
            $signCell->addText('KABUPATEN SRAGEN', null, ['alignment' => Jc::CENTER]);
            $signCell->addTextBreak(3);
            
            $direktur = Pegawai::getDirektur();
            $direkturNama = $direktur ? $direktur->nama : 'Dr. dr. KINIK DARSONO, M.Pd.Ked.';
            $direkturNip = $direktur ? $direktur->nip : '19710415 200903 1 001';
            
            $signCell->addText($direkturNama, ['underline' => 'single'], ['alignment' => Jc::CENTER]);
            $signCell->addText('NIP. ' . $direkturNip, null, ['alignment' => Jc::CENTER]);

            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
            $fileName = "{$surat->nomor_surat}.docx";
            $tempFile = tempnam(sys_get_temp_dir(), 'phpword');
            $objWriter->save($tempFile);

            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat file: ' . $e->getMessage());
        }
    }
}