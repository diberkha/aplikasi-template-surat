<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SKDirektur;
use App\Models\Regulasi;
use App\Models\Pegawai;
use App\Helpers\StringHelper;
use Exception;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Element\Table;

class SKDirekturDocxController extends Controller
{
    public function download($id)
    {
        try {
            $surat = Surat::findOrFail($id);
            $sk = SKDirektur::where('id_surat', $id)->firstOrFail();
            $data = $sk->toArray();

            $phpWord = new PhpWord();
            $phpWord->setDefaultFontName('Cambria');
            $phpWord->setDefaultFontSize(12);
            $phpWord->setDefaultParagraphStyle(['spaceAfter' => 0, 'lineHeight' => 1.0]);

            $section = $phpWord->addSection([
                'marginTop' => (int) Converter::inchToTwip(0.33),
                'marginBottom' => (int) Converter::inchToTwip(0.19),
                'marginLeft' => (int) Converter::inchToTwip(0.7),
                'marginRight' => (int) Converter::inchToTwip(0.7),
                'pageSizeW' => (int) Converter::inchToTwip(8.27),
                'pageSizeH' => (int) Converter::inchToTwip(13),
            ]);

            // Header
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
                'borderBottomSize' => 18,
                'borderBottomColor' => '000000',
                'borderBottomStyle' => 'single'
            ])->addText('', null, ['lineHeight' => 0.5]);

            $section->addTextBreak(1);

            // Title
            $section->addText('KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG', null, ['alignment' => Jc::CENTER]);
            $section->addText('KABUPATEN SRAGEN', null, ['alignment' => Jc::CENTER]);
            $section->addTextBreak(1);
            $section->addText('NOMOR : ' . ($data['nomor_surat'] ?? '-'), null, ['alignment' => Jc::CENTER]);
            $section->addTextBreak(1);
            $section->addText('TENTANG', null, ['alignment' => Jc::CENTER]);
            $section->addTextBreak(1);

            // Tentang
            $tentang = strtoupper($data['tentang'] ?? '-');
            $section->addText($tentang, null, ['alignment' => Jc::CENTER, 'indentation' => ['left' => 1332, 'right' => 1332], 'lineHeight' => 1.0]);
            $section->addTextBreak(1);
            $section->addText('DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG', null, ['alignment' => Jc::CENTER]);
            $section->addTextBreak(1);

            // Menimbang
            $phpWord->addTableStyle('LayoutTable', [
                'borderSize' => 0,
                'cellMargin' => 40,
                'borderColor' => 'FFFFFF',
                'borderTopSize' => 0,
                'borderBottomSize' => 0,
                'borderLeftSize' => 0,
                'borderRightSize' => 0,
                'borderInsideHSize' => 0,
                'borderInsideVSize' => 0
            ]);

            $mt = $section->addTable('LayoutTable');
            $mt->addRow();
            $mt->addCell((int) Converter::inchToTwip(1.2))->addText('Menimbang');
            $mt->addCell((int) Converter::inchToTwip(0.2))->addText(':');
            $contentCell = $mt->addCell((int) Converter::inchToTwip(6.0));

            $menimbangLines = is_array($data['menimbang'] ?? '')
                ? $data['menimbang']
                : preg_split('/\r\n|\r|\n/', trim($data['menimbang'] ?? ''));

            $menimbangLines = array_map(function ($line) {
                return preg_replace('/^[a-z]\.\s*/', '', trim($line));
            }, $menimbangLines);
            $menimbangLines = array_values(array_filter($menimbangLines));

            if (count($menimbangLines) > 1) {
                $phpWord->addNumberingStyle(
                    'menimbangList',
                    [
                        'type' => 'multilevel',
                        'levels' => [
                            [
                                'format' => 'lowerLetter',
                                'text' => '%1.',
                                'alignment' => 'left',
                                'tabPos' => 420,
                                'left' => 420,
                                'hanging' => 420
                            ]
                        ]
                    ]
                );

                foreach ($menimbangLines as $line) {
                    $contentCell->addListItem($line, 0, null, 'menimbangList', ['alignment' => Jc::BOTH, 'lineHeight' => 1.0]);
                }
            } else {
                $contentCell->addText($menimbangLines[0] ?? '', null, ['alignment' => Jc::BOTH, 'lineHeight' => 1.0]);
            }

            $section->addTextBreak(1);

            // Mengingat
            $mg = $section->addTable('LayoutTable');
            $mg->addRow();
            $mg->addCell((int) Converter::inchToTwip(1.2))->addText('Mengingat');
            $mg->addCell((int) Converter::inchToTwip(0.2))->addText(':');
            $contentCell = $mg->addCell((int) Converter::inchToTwip(6.0));

            $rawMengingat = trim($data['mengingat'] ?? '');
            $mengingatLines = [];

            $lines = preg_split('/\r\n|\r|\n/', $rawMengingat);
            $lines = array_filter($lines, function ($line) {
                return trim($line) !== '';
            });

            $allAreIds = true;
            $ids = [];

            foreach ($lines as $line) {
                $cleaned = preg_replace('/^\d+\.\s*/', '', trim($line));

                if (preg_match('/^\d+$/', $cleaned)) {
                    $ids[] = (int) $cleaned;
                } else {
                    $allAreIds = false;
                    break;
                }
            }

            if ($allAreIds && count($ids) > 0) {
                $regulasis = Regulasi::whereIn('id_regulasi', $ids)
                    ->orderByRaw('FIELD(id_regulasi, ' . implode(',', $ids) . ')')
                    ->get();

                if ($regulasis->count() > 0) {
                    $mengingatLines = $regulasis->pluck('isi_regulasi')->toArray();
                } else {
                    $mengingatLines = ['Data regulasi tidak ditemukan'];
                }
            } else {
                foreach ($lines as $line) {
                    $cleaned = preg_replace('/^\d+\.\s*/', '', trim($line));
                    if ($cleaned !== '') {
                        $mengingatLines[] = $cleaned;
                    }
                }
            }

            $phpWord->addNumberingStyle(
                'mengingatList',
                [
                    'type' => 'multilevel',
                    'levels' => [
                        [
                            'format' => 'decimal',
                            'text' => '%1.',
                            'alignment' => 'left',
                            'tabPos' => 420,
                            'left' => 420,
                            'hanging' => 420
                        ]
                    ]
                ]
            );

            foreach ($mengingatLines as $line) {
                if (trim($line) === '') {
                    continue;
                }
                $contentCell->addListItem(trim($line), 0, null, 'mengingatList', ['alignment' => Jc::BOTH, 'lineHeight' => 1.0]);
            }

            $section->addTextBreak(1);

            // Memutuskan
            $section->addText('MEMUTUSKAN', null, ['alignment' => Jc::CENTER]);
            $section->addTextBreak(1);

            // Menetapkan
            $m = $section->addTable('LayoutTable');
            $m->addRow();
            $m->addCell((int) Converter::inchToTwip(1.2))->addText('Menetapkan');
            $m->addCell((int) Converter::inchToTwip(0.2))->addText(':');
            $m->addCell((int) Converter::inchToTwip(6.0))->addText(trim($data['menetapkan'] ?? ''), null, ['alignment' => Jc::BOTH, 'lineHeight' => 1.0]);

            $memutuskanText = $data['memutuskan'] ?? '';
            $lines = explode("\n", $memutuskanText);
            $currentLabel = '';
            $currentText = '';
            $items = [];
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) {
                    continue;
                }
                if (preg_match('/^(KESATU|KEDUA|KETIGA|KEEMPAT|KELIMA|KEENAM|KETUJUH|KEDELAPAN|KESEMBILAN|KESEPULUH)$/i', $line)) {
                    if ($currentLabel) {
                        $items[] = ['label' => $currentLabel, 'text' => trim($currentText)];
                    }
                    $currentLabel = $line;
                    $currentText = '';
                } else {
                    $currentText .= ' ' . $line;
                }
            }
            if ($currentLabel) {
                $items[] = ['label' => $currentLabel, 'text' => trim($currentText)];
            }

            $actualIdx = 0;
            foreach ($items as $item) {
                $m = $section->addTable('LayoutTable');
                $m->addRow();
                $m->addCell((int) Converter::inchToTwip(1.2))->addText($labels[$actualIdx] ?? strtoupper($item['label']));
                $m->addCell((int) Converter::inchToTwip(0.2))->addText(':');
                $m->addCell((int) Converter::inchToTwip(6.0))->addText($item['text'], null, ['alignment' => Jc::BOTH, 'lineHeight' => 1.0]);
                $actualIdx++;
            }

            $section->addTextBreak(2);

            $footerTable = $section->addTable('LayoutTable');
            $footerTable->addRow();
            $footerTable->addCell((int) Converter::inchToTwip(3.5));
            $signCell = $footerTable->addCell((int) Converter::inchToTwip(4.0));

            $signCell->addText('Ditetapkan di Gemolong', null, ['alignment' => Jc::LEFT, 'indentation' => ['left' => 630]]);
            $tanggal = '.......................';
            if (!empty($sk->tanggal_dibuat)) {
                $tanggalDate = \Carbon\Carbon::parse($sk->tanggal_dibuat, config('app.timezone'));
                $tanggal = $tanggalDate->locale('id')->translatedFormat('j F Y');
            }
            $signCell->addText('pada tanggal ' . $tanggal, null, ['alignment' => Jc::LEFT, 'indentation' => ['left' => 630]]);
            $signCell->addTextBreak(1);
            $signCell->addText('DIREKTUR RSUD dr. SOERATNO GEMOLONG', null, ['alignment' => Jc::CENTER]);
            $signCell->addText('KABUPATEN SRAGEN', null, ['alignment' => Jc::CENTER]);
            $signCell->addTextBreak(3);

            $direktur = Pegawai::getDirektur();
            $direkturNama = $direktur ? $direktur->nama : 'KINIK DARSONO';
            $direkturNama = StringHelper::removeAcademicTitles($direkturNama);
            $direkturNip = $direktur ? $direktur->nip : null;

            $signCell->addText($direkturNama, null, ['alignment' => Jc::CENTER]);

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
