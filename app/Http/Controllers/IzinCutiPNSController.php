<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratIzinCuti;
use Exception;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Shared\Converter;

class IzinCutiPNSController extends Controller
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

            $formatTanggalIndonesia = function($tanggal) {
                if (empty($tanggal)) return '';
                $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
                $timestamp = strtotime($tanggal);
                $hari = date('d', $timestamp);
                $bulanAngka = date('n', $timestamp);
                $tahun = date('Y', $timestamp);
                return $hari . ' ' . $bulan[$bulanAngka] . ' ' . $tahun;
            };

            // Table Styles
            $phpWord->addTableStyle('CutiTable', ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 20]);
            $phpWord->addTableStyle('NoBorderTable', ['borderSize' => 0, 'borderColor' => 'FFFFFF', 'cellMargin' => 20]);

            // Header - PNS Specific (Regulation 24/2017)
            $table = $section->addTable('NoBorderTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(3.5));
            $rightCell = $table->addCell((int) Converter::inchToTwip(3.77));
            $rightCell->addText('PERATURAN BADAN KEPEGAWAIAN NEGARA REPUBLIK INDONESIA NOMOR 24 TAHUN 2017');
            $rightCell->addText('TENTANG');
            $rightCell->addText('TATA CARA PEMBERIAN CUTI PEGAWAI NEGERI SIPIL');
            $rightCell->addTextBreak(1);
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
            $table->addCell((int) Converter::inchToTwip(2.54))->addText($data['nama'] ?? '');
            $table->addCell((int) Converter::inchToTwip(1.09))->addText('NIP');
            $table->addCell((int) Converter::inchToTwip(2.55))->addText($data['nip'] ?? '');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(1.09))->addText('Jabatan');
            $table->addCell((int) Converter::inchToTwip(2.54))->addText($data['jabatan'] ?? '');
            $table->addCell((int) Converter::inchToTwip(1.09))->addText('Masa Kerja');
            $mk = ($data['masa_kerja_tahun'] ?? '') . ' th ' . ($data['masa_kerja_bulan'] ?? '') . ' bln';
            $table->addCell((int) Converter::inchToTwip(2.55))->addText($mk);
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(1.09))->addText('Unit Kerja');
            $table->addCell(null, ['gridSpan' => 3])->addText($data['unit'] ?? 'RSUD dr. Soeratno Gemolong');

            $section->addTextBreak(1, ['spaceAfter' => (int) Converter::inchToTwip(1.5)]);

            // II. JENIS CUTI YANG DIAMBIL (PNS: 6 items in 2 columns)
            $table = $section->addTable('CutiTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(7.27), ['gridSpan' => 4])->addText('II. JENIS CUTI YANG DIAMBIL**');
            
            $jenisCuti = $data['jenis_cuti'] ?? '';
            $types = ['1. Cuti Tahunan' => 'Cuti Tahunan', '2. Cuti Besar' => 'Cuti Besar', '3. Cuti Sakit' => 'Cuti Sakit', '4. Cuti Melahirkan' => 'Cuti Melahirkan', '5. Cuti Karena Alasan Penting' => 'Cuti Karena Alasan Penting', '6. Cuti di Luar Tanggungan Negara' => 'Cuti di Luar Tanggungan Negara'];
            $items = array_keys($types);
            for ($i = 0; $i < count($items); $i += 2) {
                $table->addRow();
                $lbl1 = $items[$i];
                $table->addCell((int) Converter::inchToTwip(2.74))->addText($lbl1);
                $table->addCell((int) Converter::inchToTwip(0.89))->addText($jenisCuti == $types[$lbl1] ? 'V' : '', null, ['alignment' => Jc::CENTER]);
                
                if (isset($items[$i+1])) {
                    $lbl2 = $items[$i+1];
                    $table->addCell((int) Converter::inchToTwip(2.74))->addText($lbl2);
                    $table->addCell((int) Converter::inchToTwip(0.89))->addText($jenisCuti == $types[$lbl2] ? 'V' : '', null, ['alignment' => Jc::CENTER]);
                }
            }

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
            $table->addCell((int) Converter::inchToTwip(1.3))->addText('mulai tgl');
            $table->addCell((int) Converter::inchToTwip(1.5))->addText(isset($data['mulai']) ? $formatTanggalIndonesia($data['mulai']) : '');
            $table->addCell((int) Converter::inchToTwip(0.5))->addText('s/d');
            $table->addCell((int) Converter::inchToTwip(1.27))->addText(isset($data['sampai']) ? $formatTanggalIndonesia($data['sampai']) : '');

            $section->addTextBreak(1, ['spaceAfter' => (int) Converter::inchToTwip(1.5)]);

            // V. CATATAN CUTI (Full PNS structure)
            $table = $section->addTable('CutiTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(7.27), ['gridSpan' => 5])->addText('V. CATATAN CUTI***');
            
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(2.35), ['gridSpan' => 3])->addText('1. CUTI TAHUNAN');
            $table->addCell((int) Converter::inchToTwip(2.35))->addText('2. CUTI BESAR');
            $table->addCell((int) Converter::inchToTwip(0.89))->addText($jenisCuti == 'Cuti Besar' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(0.5))->addText('Thn');
            $table->addCell((int) Converter::inchToTwip(0.5))->addText('Sisa');
            $table->addCell((int) Converter::inchToTwip(1.35))->addText('Ket');
            $table->addCell((int) Converter::inchToTwip(2.35))->addText('3. CUTI SAKIT');
            $table->addCell((int) Converter::inchToTwip(0.89))->addText($jenisCuti == 'Cuti Sakit' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            
            // N-2 row
            $table->addRow();
            $table->addCell()->addText('N-2');
            $table->addCell()->addText($data['catatan_n2'] ?? '');
            $table->addCell()->addText($data['catatan_n2_keterangan'] ?? '');
            $table->addCell()->addText('4. CUTI MELAHIRKAN');
            $table->addCell()->addText($jenisCuti == 'Cuti Melahirkan' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            
            // N-1 row
            $table->addRow();
            $table->addCell()->addText('N-1');
            $table->addCell()->addText($data['catatan_n1'] ?? '');
            $table->addCell()->addText($data['catatan_n1_keterangan'] ?? '');
            $table->addCell()->addText('5. CUTI ALASAN PENTING');
            $table->addCell()->addText($jenisCuti == 'Cuti Karena Alasan Penting' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            
            // N row
            $table->addRow();
            $table->addCell()->addText('N');
            $table->addCell()->addText($data['catatan_n'] ?? '');
            $table->addCell()->addText($data['catatan_n_keterangan'] ?? '');
            $table->addCell()->addText('6. CLTN');
            $table->addCell()->addText($jenisCuti == 'Cuti di Luar Tanggungan Negara' ? 'V' : '', null, ['alignment' => Jc::CENTER]);

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

            // VII. PERTIMBANGAN ATASAN LANGSUNG
            $table = $section->addTable('CutiTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(7.27), ['gridSpan' => 4])->addText('VII. PERTIMBANGAN ATASAN LANGSUNG**');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(1.3))->addText('DISETUJUI', null, ['alignment' => Jc::CENTER]);
            $table->addCell((int) Converter::inchToTwip(1.3))->addText('PERUBAHAN****', null, ['alignment' => Jc::CENTER]);
            $table->addCell((int) Converter::inchToTwip(1.3))->addText('DITANGGUHKAN****', null, ['alignment' => Jc::CENTER]);
            $table->addCell((int) Converter::inchToTwip(3.37))->addText('TIDAK DISETUJUI****', null, ['alignment' => Jc::CENTER]);
            
            $table->addRow();
            $atasan = $data['atasan_setuju'] ?? '';
            $table->addCell()->addText($atasan == 'DISETUJUI' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addCell()->addText($atasan == 'PERUBAHAN' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addCell()->addText($atasan == 'DITANGGUHKAN' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addCell()->addText($atasan == 'TIDAK DISETUJUI' ? 'V' : '', null, ['alignment' => Jc::CENTER]);

            $table->addRow();
            $table->addCell(null, ['gridSpan' => 2]);
            $signCell = $table->addCell(null, ['gridSpan' => 2]);
            $signCell->addText(strtoupper($data['jabatan_atasan'] ?? 'Atasan'), null, ['alignment' => Jc::CENTER]);
            $signCell->addTextBreak(3);
            $signCell->addText(strtoupper($data['nama_atasan'] ?? ''), ['underline' => 'single'], ['alignment' => Jc::CENTER]);
            $signCell->addText('NIP. ' . ($data['nip_atasan'] ?? ''), null, ['alignment' => Jc::CENTER]);

            $section->addTextBreak(1, ['spaceAfter' => (int) Converter::inchToTwip(1.5)]);

            // VIII. KEPUTUSAN PEJABAT
            $table = $section->addTable('CutiTable');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(7.27), ['gridSpan' => 4])->addText('VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI**');
            $table->addRow();
            $table->addCell((int) Converter::inchToTwip(1.3))->addText('DISETUJUI', null, ['alignment' => Jc::CENTER]);
            $table->addCell((int) Converter::inchToTwip(1.3))->addText('PERUBAHAN****', null, ['alignment' => Jc::CENTER]);
            $table->addCell((int) Converter::inchToTwip(1.3))->addText('DITANGGUHKAN****', null, ['alignment' => Jc::CENTER]);
            $table->addCell((int) Converter::inchToTwip(3.37))->addText('TIDAK DISETUJUI****', null, ['alignment' => Jc::CENTER]);
            
            $table->addRow();
            $pejabat = $data['pejabat_keputusan'] ?? '';
            $table->addCell()->addText($pejabat == 'DISETUJUI' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addCell()->addText($pejabat == 'PERUBAHAN' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addCell()->addText($pejabat == 'DITANGGUHKAN' ? 'V' : '', null, ['alignment' => Jc::CENTER]);
            $table->addCell()->addText($pejabat == 'TIDAK DISETUJUI' ? 'V' : '', null, ['alignment' => Jc::CENTER]);

            $table->addRow();
            $catatanCell = $table->addCell((int) Converter::inchToTwip(3.6), ['gridSpan' => 2]);
            $catatanText = ['size' => 8];
            $catatanCell->addText('Catatan:', $catatanText);
            $catatanCell->addText('* Coret yang tidak perlu', $catatanText);
            $catatanCell->addText('** Pilih salah satu dengan memberi tanda centang (V)', $catatanText);
            $catatanCell->addText('*** diisi oleh pejabat yang menangani bidang kepegawaian', $catatanText);
            $catatanCell->addText('**** diberi tanda centang dan alasannya', $catatanText);
            
            $signCell = $table->addCell((int) Converter::inchToTwip(3.67), ['gridSpan' => 2]);
            $signCell->addText('DIREKTUR RSUD dr. SOERATNO GEMOLONG', null, ['alignment' => Jc::CENTER]);
            $signCell->addText('KABUPATEN SRAGEN', null, ['alignment' => Jc::CENTER]);
            $signCell->addTextBreak(3);
            $signCell->addText('Dr. dr. KINIK DARSONO, M.Pd.Ked.', ['underline' => 'single'], ['alignment' => Jc::CENTER]);
            $signCell->addText('NIP. 19710415 200903 1 001', null, ['alignment' => Jc::CENTER]);

            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
            $fileName = 'Surat Izin Cuti-PNS-' . ($data['nama'] ?? 'Unknown') . '.docx';
            $tempFile = tempnam(sys_get_temp_dir(), 'phpword');
            $objWriter->save($tempFile);

            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat file: ' . $e->getMessage());
        }
    }
}
