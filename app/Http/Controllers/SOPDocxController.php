<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SOP;
use App\Models\Pegawai;
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
            $surat = Surat::with('sop.contents')->findOrFail($id);
            $sop = $surat->sop;

            if (!$sop) {
                return redirect()->back()->with('error', 'Data SOP tidak ditemukan');
            }

            $phpWord = new PhpWord();
            $phpWord->setDefaultFontName('Times New Roman');
            $phpWord->setDefaultFontSize(12);
            $phpWord->setDefaultParagraphStyle(['spaceAfter' => 0, 'lineHeight' => 1.0]);

            $section = $phpWord->addSection([
                'marginTop' => (int) Converter::inchToTwip(0.39),
                'marginBottom' => (int) Converter::inchToTwip(0.79),
                'marginLeft' => (int) Converter::inchToTwip(1.18),
                'marginRight' => (int) Converter::inchToTwip(0.98),
                'pageSizeW' => (int) Converter::inchToTwip(8.5),
                'pageSizeH' => (int) Converter::inchToTwip(13)
            ]);

            $sopTableStyle = ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80];
            $phpWord->addTableStyle('SOPTable', $sopTableStyle);

            foreach ($sop->contents as $pageIndex => $page) {
                if ($pageIndex > 0) {
                    $section->addPageBreak();
                }

                $data = $page->toArray();
                $table = $section->addTable('SOPTable');

                // Logo & Title
                $table->addRow();
                $logoCell = $table->addCell((int) Converter::inchToTwip(2.3), ['vMerge' => 'restart', 'valign' => 'center']);
                $logoPath = public_path('img/logo-sragen.png');
                if (file_exists($logoPath)) {
                    $logoCell->addImage($logoPath, [
                        'width' => (int) Converter::inchToPoint(0.8),
                        'height' => (int) Converter::inchToPoint(1.0),
                        'alignment' => Jc::CENTER
                    ]);
                }
                $logoCell->addText('RSUD dr. SOERATNO', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);
                $logoCell->addText('GEMOLONG', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);

                $titleCell = $table->addCell((int) Converter::inchToTwip(5.17), ['gridSpan' => 3, 'valign' => 'center']);
                $titleCell->addText($data['judul_sop'] ?? '', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER, 'spaceBefore' => 120, 'spaceAfter' => 120]);

                // Info
                $table->addRow();
                $table->addCell(null, ['vMerge' => 'continue']);

                $docNoCell = $table->addCell((int) Converter::inchToTwip(2.0), ['valign' => 'top']);
                $docNoCell->addText('No. Dokumen', null, ['alignment' => Jc::CENTER]);
                $docNoCell->addText($data['nomor_dokumen'] ?? '', null, ['alignment' => Jc::CENTER]);

                $revNoCell = $table->addCell((int) Converter::inchToTwip(1.17), ['valign' => 'top']);
                $revNoCell->addText('No. Revisi', null, ['alignment' => Jc::CENTER]);
                $revNoCell->addText($data['nomor_revisi'] ?? '', null, ['alignment' => Jc::CENTER]);

                $pageCell = $table->addCell((int) Converter::inchToTwip(2.0), ['valign' => 'top']);
                $pageCell->addText('Halaman', null, ['alignment' => Jc::CENTER]);
                $pageCell->addText($data['halaman'] ?? '1/1', null, ['alignment' => Jc::CENTER]);

                // Header
                $table->addRow((int) Converter::inchToTwip(0.8));
                $spoCell = $table->addCell((int) Converter::inchToTwip(2.3), ['valign' => 'center']);
                $spoCell->addText('STANDAR', ['bold' => true], ['alignment' => Jc::CENTER]);
                $spoCell->addText('PROSEDUR', ['bold' => true], ['alignment' => Jc::CENTER]);
                $spoCell->addText('OPERASIONAL', ['bold' => true], ['alignment' => Jc::CENTER]);

                $dateCell = $table->addCell((int) Converter::inchToTwip(2.3), ['valign' => 'center']);
                $dateCell->addText('Tanggal Terbit', null, ['alignment' => Jc::CENTER]);
                $tanggalFormatted = '.......................';
                if (!empty($page->tanggal_terbit)) {
                    $tanggal = \Carbon\Carbon::parse($page->tanggal_terbit, config('app.timezone'));
                    $tanggalFormatted = $tanggal->locale('id')->translatedFormat('j F Y');
                }
                $dateCell->addText($tanggalFormatted, null, ['alignment' => Jc::CENTER]);

                $signCell = $table->addCell((int) Converter::inchToTwip(2.87), ['gridSpan' => 2, 'valign' => 'center']);
                $signCell->addText('Ditetapkan,', null, ['alignment' => Jc::CENTER]);
                $signCell->addText('Direktur RSUD dr. Soeratno', null, ['alignment' => Jc::CENTER]);
                $signCell->addText('Gemolong Kabupaten Sragen', null, ['alignment' => Jc::CENTER]);
                $signCell->addTextBreak(3);

                $direktur = Pegawai::getDirektur();
                $direkturNama = $direktur ? $direktur->nama : 'Dr. dr. Kinik Darsono, M.Pd.Ked.';
                $direkturNip = $direktur ? $direktur->nip : '19710415 200903 1 001';

                $namaLength = mb_strlen($direkturNama);
                $fontSize = 12;
                if ($namaLength > 50) {
                    $fontSize = 7;
                } elseif ($namaLength > 42) {
                    $fontSize = 8;
                } elseif ($namaLength > 36) {
                    $fontSize = 9;
                } elseif ($namaLength > 31) {
                    $fontSize = 10;
                } elseif ($namaLength > 27) {
                    $fontSize = 11;
                }

                $signCell->addText($direkturNama, ['underline' => 'single', 'size' => $fontSize], ['alignment' => Jc::CENTER]);
                $signCell->addText('NIP. ' . $direkturNip, null, ['alignment' => Jc::CENTER]);

                // Content
                $rawKebijakan = trim($data['kebijakan'] ?? '');
                $resolvedKebijakan = [];
                $lines = preg_split('/\r\n|\r|\n/', $rawKebijakan);
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
                    $regs = \App\Models\Regulasi::whereIn('id_regulasi', $ids)
                        ->orderByRaw('FIELD(id_regulasi, ' . implode(',', $ids) . ')')
                        ->get();
                    $resolvedKebijakan = $regs->pluck('isi_regulasi')->toArray();
                } else {
                    $resolvedKebijakan = array_map(function ($line) {
                        return preg_replace('/^\d+\.\s*/', '', trim($line));
                    }, array_values(array_filter(array_map('trim', $lines))));
                }

                $rawUnit = trim($data['unit_terkait'] ?? '');
                $resolvedUnit = $rawUnit;
                $unitLines = preg_split('/\r\n|\r|\n/', $rawUnit);
                $unitLines = array_filter($unitLines, function ($line) {
                    return trim($line) !== '';
                });

                $allUnitIds = true;
                $uIds = [];
                foreach ($unitLines as $line) {
                    $cleaned = preg_replace('/^\d+\.\s*/', '', trim($line));
                    if (preg_match('/^\d+$/', $cleaned)) {
                        $uIds[] = (int) $cleaned;
                    } else {
                        $allUnitIds = false;
                        break;
                    }
                }

                if ($allUnitIds && count($uIds) > 0) {
                    $units = \App\Models\Unit::whereIn('id_unit', $uIds)
                        ->orderByRaw('FIELD(id_unit, ' . implode(',', $uIds) . ')')
                        ->get();
                    $resolvedUnit = implode(', ', $units->pluck('nama_unit')->toArray());
                }

                $contentRows = [
                    'Pengertian' => $data['pengertian'] ?? '',
                    'Tujuan' => $data['tujuan'] ?? '',
                    'Kebijakan' => $resolvedKebijakan,
                    'Prosedur' => $data['prosedur'] ?? [],
                    'Unit Terkait' => $resolvedUnit,
                ];

                foreach ($contentRows as $label => $content) {
                    $table->addRow();
                    $table->addCell((int) Converter::inchToTwip(2.3))->addText($label);
                    $cell = $table->addCell((int) Converter::inchToTwip(5.17), ['gridSpan' => 3]);

                    if (in_array($label, ['Tujuan', 'Kebijakan', 'Prosedur'])) {
                        $items = is_array($content) ? $content : preg_split('/\r?\n|\r|\•|\d+\./', $content, -1, PREG_SPLIT_NO_EMPTY);
                        $items = array_values(array_filter(array_map('trim', $items)));

                        if (count($items) > 1 || in_array($label, ['Kebijakan', 'Prosedur'])) {
                            $listStyle = $label . 'Numbering' . uniqid();
                            $phpWord->addNumberingStyle($listStyle, [
                                'type' => 'singleLevel',
                                'levels' => [
                                    ['format' => 'decimal', 'text' => '%1.', 'left' => 450, 'hanging' => 450, 'tabPos' => 450]
                                ]
                            ]);
                            foreach ($items as $item) {
                                $text = trim(strip_tags($item));
                                $text = preg_replace('/^\d+\.\s*/', '', $text);
                                if ($text !== '') {
                                    $cell->addListItem($text, 0, null, ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER, 'numStyle' => $listStyle], ['alignment' => Jc::BOTH]);
                                }
                            }
                        } else {
                            $cell->addText($items[0] ?? $content, null, ['alignment' => Jc::BOTH]);
                        }
                    } else {
                        $cell->addText($content, null, ['alignment' => Jc::BOTH]);
                    }
                }
            }

            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
            $tempFile = tempnam(sys_get_temp_dir(), 'phpword');
            $objWriter->save($tempFile);

            $firstPageData = $sop->contents->first() ? $sop->contents->first()->toArray() : [];
            $docNumber = $firstPageData['nomor_dokumen'] ?? $surat->nomor_surat;
            $fileName = 'SOP-' . str_replace(['/', '\\', '*', ':', '?', '"', '<', '>', '|'], '-', $docNumber) . '.docx';
            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat file: ' . $e->getMessage());
        }
    }
}
