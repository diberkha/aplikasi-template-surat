<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SOP;
use Exception;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Shared\Converter;

class SOPDocxController extends Controller
{
    public function download($id)
    {
        try {
            $surat = Surat::findOrFail($id);
            $sop = SOP::where('id_surat', $id)->firstOrFail();
            $data = $sop->toArray();
            
            $phpWord = new PhpWord();
            $phpWord->setDefaultFontName('Times New Roman');
            $phpWord->setDefaultFontSize(12);
            $phpWord->setDefaultParagraphStyle(['spaceAfter' => 0, 'lineHeight' => 1.0]);

            $section = $phpWord->addSection([
                'marginTop' => (int) Converter::inchToTwip(0.39),
                'marginBottom' => (int) Converter::inchToTwip(0.79),
                'marginLeft' => (int) Converter::inchToTwip(1.18),
                'marginRight' => (int) Converter::inchToTwip(0.98),
            ]);

            $sopTableStyle = ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80];
            $phpWord->addTableStyle('SOPTable', $sopTableStyle);
            $table = $section->addTable('SOPTable');

            // Logo & Title
            $table->addRow((int) Converter::inchToTwip(1.0));
            $logoCell = $table->addCell((int) Converter::inchToTwip(1.87), ['vMerge' => 'restart', 'valign' => 'center']);
            $logoPath = public_path('img/logo-sragen.png');
            if (file_exists($logoPath)) {
                $logoCell->addImage($logoPath, ['width' => (int) Converter::inchToPoint(0.8), 'alignment' => Jc::CENTER]);
            }
            $logoCell->addText('RSUD dr. SOERATNO', ['bold' => true, 'size' => 10], ['alignment' => Jc::CENTER]);
            $logoCell->addText('GEMOLONG', ['bold' => true, 'size' => 10], ['alignment' => Jc::CENTER]);

            $titleCell = $table->addCell((int) Converter::inchToTwip(4.0), ['gridSpan' => 3, 'valign' => 'center']);
            $titleCell->addText($data['judul_sop'] ?? '', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);

            // Info
            $table->addRow();
            $table->addCell(null, ['vMerge' => 'continue']); 
            
            $docNoCell = $table->addCell((int) Converter::inchToTwip(2.1), ['valign' => 'center']);
            $docNoCell->addText('No. Dokumen', null, ['alignment' => Jc::CENTER]);
            $docNoCell->addText($data['nomor_dokumen'] ?? '', null, ['alignment' => Jc::CENTER]);

            $revNoCell = $table->addCell((int) Converter::inchToTwip(1.1), ['valign' => 'center']);
            $revNoCell->addText('No. Revisi', null, ['alignment' => Jc::CENTER]);
            $revNoCell->addText($data['nomor_revisi'] ?? '', null, ['alignment' => Jc::CENTER]);

            $pageCell = $table->addCell((int) Converter::inchToTwip(0.8), ['valign' => 'center']);
            $pageCell->addText('Halaman', null, ['alignment' => Jc::CENTER]);
            $pageCell->addText($data['halaman'] ?? '1/1', null, ['alignment' => Jc::CENTER]);

            // SOP Header
            $table->addRow((int) Converter::inchToTwip(0.8));
            $spoCell = $table->addCell((int) Converter::inchToTwip(1.87), ['valign' => 'center']);
            $spoCell->addText('STANDAR', ['bold' => true], ['alignment' => Jc::CENTER]);
            $spoCell->addText('PROSEDUR', ['bold' => true], ['alignment' => Jc::CENTER]);
            $spoCell->addText('OPERASIONAL', ['bold' => true], ['alignment' => Jc::CENTER]);

            $dateCell = $table->addCell((int) Converter::inchToTwip(1.5), ['valign' => 'center']);
            $dateCell->addText('Tanggal Terbit', null, ['alignment' => Jc::CENTER]);
            $tanggal = isset($data['tanggal_terbit']) ? \Carbon\Carbon::parse($data['tanggal_terbit'])->locale('id')->translatedFormat('j F Y') : '.......................';
            $dateCell->addText($tanggal, null, ['alignment' => Jc::CENTER]);

            $signCell = $table->addCell((int) Converter::inchToTwip(2.5), ['gridSpan' => 2, 'valign' => 'center']);
            $signCell->addText('Ditetapkan,', null, ['alignment' => Jc::CENTER]);
            $signCell->addText('Direktur RSUD dr. Soeratno', null, ['alignment' => Jc::CENTER]);
            $signCell->addText('Gemolong Kabupaten Sragen', null, ['alignment' => Jc::CENTER]);
            $signCell->addTextBreak(2);
            $signCell->addText('Dr. dr. Kinik Darsono, M.Pd.Ked.', ['underline' => 'single'], ['alignment' => Jc::CENTER]);
            $signCell->addText('NIP. 19710415 200903 1 001', null, ['alignment' => Jc::CENTER]);

            // Content
            $contentRows = [
                'Pengertian' => $data['pengertian'] ?? '',
                'Tujuan' => $data['tujuan'] ?? '',
                'Kebijakan' => $data['kebijakan'] ?? [],
                'Prosedur' => $data['prosedur'] ?? [],
                'Unit Terkait' => $data['unit_terkait'] ?? '',
            ];

            foreach ($contentRows as $label => $content) {
                $table->addRow();
                $table->addCell((int) Converter::inchToTwip(1.87))->addText($label);
                $cell = $table->addCell((int) Converter::inchToTwip(5.4), ['gridSpan' => 3]);

                if (in_array($label, ['Kebijakan', 'Prosedur'])) {
                    $items = is_array($content) ? $content : preg_split('/\r?\n|\r|\•|\d+\./', $content, -1, PREG_SPLIT_NO_EMPTY);
                    $listStyle = $label . 'Numbering';
                    $phpWord->addNumberingStyle($listStyle, [
                        'type' => 'singleLevel',
                        'levels' => [
                            ['format' => 'decimal', 'text' => '%1.', 'left' => 360, 'hanging' => 360, 'tabPos' => 360]
                        ]
                    ]);
                    foreach ($items as $item) {
                        $text = trim(strip_tags($item));
                        if ($text !== '') {
                            $cell->addListItem($text, 0, null, ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER, 'numStyle' => $listStyle]);
                        }
                    }
                } else {
                    $cell->addText($content, null, ['alignment' => Jc::BOTH]);
                }
            }

            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
            $tempFile = tempnam(sys_get_temp_dir(), 'phpword');
            $objWriter->save($tempFile);

            $fileName = 'SOP-' . str_replace(['/', '\\', '*', ':', '?', '"', '<', '>', '|'], '-', $data['nomor_dokumen'] ?? $surat->nomor_surat) . '.docx';
            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat file: ' . $e->getMessage());
        }
    }
}
