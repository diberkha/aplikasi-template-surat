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
use Illuminate\Support\Facades\Log;

class SOPDocxController extends Controller
{
    public function download($id)
    {
        try {
            $surat = Surat::with('sop.contents')->findOrFail($id);
            $sop = $surat->sop;

            if (!$sop) {
                Log::warning('SOP not found for surat ID: ' . $id);
                return redirect()->back()->with('error', 'Data SOP tidak ditemukan');
            }

            if ($sop->contents->isEmpty()) {
                Log::warning('SOP contents empty for surat ID: ' . $id);
                return redirect()->back()->with('error', 'Konten SOP kosong');
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

                $table->addRow((int) Converter::inchToTwip(0.8));
                $spoCell = $table->addCell((int) Converter::inchToTwip(2.3), ['valign' => 'center']);
                $spoCell->addText('STANDAR', ['bold' => true], ['alignment' => Jc::CENTER]);
                $spoCell->addText('PROSEDUR', ['bold' => true], ['alignment' => Jc::CENTER]);
                $spoCell->addText('OPERASIONAL', ['bold' => true], ['alignment' => Jc::CENTER]);

                $dateCell = $table->addCell((int) Converter::inchToTwip(2.3), ['valign' => 'center']);
                $dateCell->addText('Tanggal Terbit', null, ['alignment' => Jc::CENTER]);
                $tanggalFormatted = '...........................';
                if (!empty($page->tanggal_terbit)) {
                    try {
                        $dateValue = $page->tanggal_terbit;
                        if (is_string($dateValue)) {
                            $tanggal = \Carbon\Carbon::createFromFormat('Y-m-d', $dateValue);
                        } else {
                            $tanggal = \Carbon\Carbon::parse($dateValue);
                        }
                        $tanggalFormatted = $tanggal->locale('id')->translatedFormat('j F Y');
                    } catch (\Exception $e) {
                        Log::warning('Failed to parse tanggal_terbit for SOP: ' . $e->getMessage(), ['value' => $page->tanggal_terbit]);
                        $tanggalFormatted = '...........................';
                    }
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
                    try {
                        $table->addRow();
                        $table->addCell((int) Converter::inchToTwip(2.3))->addText($label);
                        $cell = $table->addCell((int) Converter::inchToTwip(5.17), ['gridSpan' => 3]);

                        if (is_array($content)) {
                            $items = array_values(array_filter($content, function ($item) {
                                return !empty(trim((string) $item));
                            }));
                        } else {
                            $contentStr = (string) $content;
                            if (empty(trim($contentStr))) {
                                $items = [];
                            } else {
                                $items = array_values(array_filter(
                                    preg_split('/\r?\n|\r/', $contentStr, -1, PREG_SPLIT_NO_EMPTY),
                                    function ($item) {
                                        return !empty(trim($item));
                                    }
                                ));
                            }
                        }

                        if (in_array($label, ['Tujuan', 'Kebijakan', 'Prosedur']) && !empty($items)) {
                            if (count($items) > 1 || in_array($label, ['Kebijakan', 'Prosedur'])) {
                                $listStyle = $label . 'Numbering' . uniqid();
                                $phpWord->addNumberingStyle($listStyle, [
                                    'type' => 'singleLevel',
                                    'levels' => [
                                        ['format' => 'decimal', 'text' => '%1.', 'left' => 450, 'hanging' => 450, 'tabPos' => 450]
                                    ]
                                ]);
                                foreach ($items as $item) {
                                    $text = trim(strip_tags((string) $item));
                                    $text = preg_replace('/^\d+\.\s*/', '', $text);
                                    if (!empty($text)) {
                                        $cell->addListItem($text, 0, null, $listStyle);
                                    }
                                }
                            } else {
                                $cell->addText(trim((string) $items[0]), null, ['alignment' => Jc::BOTH]);
                            }
                        } else {
                            $text = is_array($content) ? implode(', ', $content) : (string) $content;
                            $cell->addText(trim($text), null, ['alignment' => Jc::BOTH]);
                        }
                    } catch (Exception $e) {
                        Log::warning('Failed to add content row for label: ' . $label . ' - ' . $e->getMessage());
                        try {
                            $table->addRow();
                            $table->addCell((int) Converter::inchToTwip(2.3))->addText($label);
                            $table->addCell((int) Converter::inchToTwip(5.17), ['gridSpan' => 3])->addText('[Error processing content]');
                        } catch (Exception $fallbackErr) {
                            Log::error('Fallback content row also failed: ' . $fallbackErr->getMessage());
                        }
                    }
                }
            }

            try {
                $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
            } catch (Exception $e) {
                Log::error('Failed to create Word2007 writer for SOP: ' . $e->getMessage());
                throw new Exception('Gagal membuat dokumen Word: ' . $e->getMessage());
            }

            $tempDir = sys_get_temp_dir();
            $tempFile = tempnam($tempDir, 'sop_');
            if (!$tempFile) {
                throw new Exception('Gagal membuat file temporary');
            }

            try {
                $objWriter->save($tempFile);
                if (!file_exists($tempFile) || filesize($tempFile) === 0) {
                    throw new Exception('File temporary tidak berhasil dibuat atau kosong');
                }
            } catch (Exception $e) {
                Log::error('Failed to save SOP DOCX to temp file: ' . $e->getMessage());
                if (file_exists($tempFile)) {
                    unlink($tempFile);
                }
                throw new Exception('Gagal menyimpan dokumen: ' . $e->getMessage());
            }

            $firstPageData = $sop->contents->first() ? $sop->contents->first()->toArray() : [];
            $docNumber = $firstPageData['nomor_dokumen'] ?? $surat->nomor_surat;
            $fileName = 'SOP-' . str_replace(['/', '\\', '*', ':', '?', '"', '<', '>', '|'], '-', $docNumber) . '.docx';
            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (Exception $e) {
            Log::error('SOP DOCX download failed for ID ' . $id . ': ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal membuat file: ' . $e->getMessage());
        }
    }
}
