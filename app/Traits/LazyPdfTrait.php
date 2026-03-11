<?php

namespace App\Traits;

use App\Models\Surat;
use App\Models\Pegawai;
use App\Models\Regulasi;
use App\Models\Unit;
use App\Helpers\StringHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

trait LazyPdfTrait
{
    protected function generateTempPdf(Surat $surat)
    {
        return $this->generatePdfContent($surat, false);
    }

    protected function ensurePdfExists(Surat $surat)
    {
        $path = storage_path('app/' . $surat->file_path);

        if ($surat->file_path && file_exists($path) && is_file($path)) {
            return $path;
        }

        if (!$surat->is_draft) {
            return $this->generatePdfContent($surat, true);
        }

        return null;
    }

    protected function generatePdfContent(Surat $surat, $savePermanently = false)
    {
        $isImported = false;
        if ($surat->skDirektur && $surat->skDirektur->menimbang === 'Imported') {
            $isImported = true;
        }
        if ($surat->sop && $surat->sop->pengertian === 'Imported') {
            $isImported = true;
        }
        if ($surat->cuti && isset($surat->cuti->form_data['is_import']) && $surat->cuti->form_data['is_import']) {
            $isImported = true;
        }

        if ($isImported) {
            $path = storage_path('app/' . $surat->file_path);
            return ($path && file_exists($path) && is_file($path)) ? $path : null;
        }

        try {
            $direktur = Pegawai::getDirektur();
            $direktur_nama = $direktur ? $direktur->nama : 'Dr. dr. Kinik Darsono, M.Pd.Ked.';
            $direktur_nip = $direktur ? $direktur->nip : '19710415 200903 1 001';

            if ($surat->cuti) {
                $data = [
                    'kategori' => $surat->cuti->kategori,
                    'form' => $surat->cuti->form_data,
                    'nomor_surat' => $surat->nomor_surat,
                    'direktur_nama' => $direktur_nama,
                    'direktur_nip' => $direktur_nip,
                ];
                $view = 'template-surat.cuti.cuti-pns.pdf';
                if ($data['kategori'] === 'PPPK') {
                    $view = 'template-surat.cuti.cuti-pppk.pdf';
                }
                if ($data['kategori'] === 'NON ASN') {
                    $view = 'template-surat.cuti.cuti-nonasn.pdf';
                }

                $html = view($view, ['data' => $data, 'surat' => $surat])->render();
                $safeNomor = str_replace(['/', '\\', '*', ':', '?', '"', '<', '>', '|'], '-', $surat->nomor_surat);
                $newPath = $savePermanently ? 'arsip/CUTI-' . $safeNomor . '.pdf' : 'temp/pdf/CUTI-' . $safeNomor . '-' . uniqid() . '.pdf';
                $margins = [
                    'width' => '215.9mm',
                    'height' => '355.6mm',
                    'top' => '8.9mm',
                    'bottom' => '8.9mm',
                    'left' => '12.7mm',
                    'right' => '12.7mm'
                ];
                return $this->generatePdfWithPuppeteer($html, $surat, $newPath, $margins, $savePermanently);
            } elseif ($surat->sop) {
                $pagesResolver = [];
                foreach ($surat->sop->contents as $page) {
                    $kebijakanText = trim($page->kebijakan);
                    $kebijakanResolved = [];
                    if (!empty($kebijakanText)) {
                        $kebijakanLines = preg_split('/\r\n|\r|\n/', $kebijakanText);
                        $kebijakanIds = [];
                        foreach ($kebijakanLines as $line) {
                            if (preg_match('/^\d+\.\s*(\d+)/', trim($line), $matches)) {
                                $kebijakanIds[] = (int) $matches[1];
                            }
                        }
                        if (!empty($kebijakanIds)) {
                            $kebijakanResolved = Regulasi::whereIn('id_regulasi', $kebijakanIds)
                                ->orderByRaw('FIELD(id_regulasi, ' . implode(',', $kebijakanIds) . ')')
                                ->pluck('isi_regulasi')
                                ->toArray();
                        }
                    }

                    $unitText = trim($page->unit_terkait);
                    $unitResolved = [];
                    if (!empty($unitText)) {
                        $unitLines = preg_split('/\r\n|\r|\n/', $unitText);
                        $unitIds = [];
                        foreach ($unitLines as $line) {
                            if (preg_match('/^\d+\.\s*(\d+)/', trim($line), $matches)) {
                                $unitIds[] = (int) $matches[1];
                            }
                        }
                        if (!empty($unitIds)) {
                            $unitResolved = Unit::whereIn('id_unit', $unitIds)
                                ->orderByRaw('FIELD(id_unit, ' . implode(',', $unitIds) . ')')
                                ->pluck('nama_unit')
                                ->toArray();
                        }
                    }

                    $pagesResolver[] = [
                        'judul_sop' => $page->judul_sop,
                        'nomor_dokumen' => $page->nomor_dokumen,
                        'nomor_revisi' => $page->nomor_revisi,
                        'halaman' => $page->halaman,
                        'tanggal_terbit' => $this->formatDateValue($page->tanggal_terbit),
                        'pengertian' => $page->pengertian,
                        'tujuan' => explode("\n", $page->tujuan),
                        'kebijakan' => $kebijakanResolved,
                        'prosedur' => explode("\n", $page->prosedur),
                        'unit_terkait' => $unitResolved,
                    ];
                }

                $data = [
                    'contents' => $pagesResolver,
                    'direktur_nama' => $direktur_nama,
                    'direktur_nip' => $direktur_nip,
                ];
                $html = view('template-surat.sop.pdf', ['data' => $data])->render();
                $safeNomor = str_replace(['/', '\\', '*', ':', '?', '"', '<', '>', '|'], '-', $surat->nomor_surat);
                $newPath = $savePermanently ? 'arsip/SOP-' . $safeNomor . '.pdf' : 'temp/pdf/SOP-' . $safeNomor . '-' . uniqid() . '.pdf';
                $margins = [
                    'width' => '215.9mm',
                    'height' => '330.2mm',
                    'top' => '10mm',
                    'bottom' => '20mm',
                    'left' => '30mm',
                    'right' => '25mm'
                ];
                return $this->generatePdfWithPuppeteer($html, $surat, $newPath, $margins, $savePermanently);
            } elseif ($surat->skDirektur) {
                $mengingatText = trim($surat->skDirektur->mengingat);
                $mengingatResolved = [];
                if (!empty($mengingatText)) {
                    $mengingatLines = preg_split('/\r\n|\r|\n/', $mengingatText);
                    $mengingatIds = [];
                    foreach ($mengingatLines as $line) {
                        if (preg_match('/^\d+\.\s*(\d+)/', trim($line), $matches)) {
                            $mengingatIds[] = (int) $matches[1];
                        }
                    }
                    if (!empty($mengingatIds)) {
                        $mengingatResolved = Regulasi::whereIn('id_regulasi', $mengingatIds)
                            ->orderByRaw('FIELD(id_regulasi, ' . implode(',', $mengingatIds) . ')')
                            ->pluck('isi_regulasi')
                            ->toArray();
                    }
                }

                $direktur_nama_tanpa_gelar = StringHelper::removeAcademicTitles($direktur_nama);
                $data = [
                    'nomor_surat' => $surat->nomor_surat,
                    'tentang' => $surat->skDirektur->tentang,
                    'menimbang' => explode("\n", $surat->skDirektur->menimbang),
                    'mengingat' => $mengingatResolved,
                    'memutuskan' => $surat->skDirektur->memutuskan,
                    'menetapkan' => $surat->skDirektur->menetapkan,
                    'tempat_surat' => $surat->skDirektur->tempat_dibuat,
                    'tanggal_dibuat' => $this->formatDateValue($surat->skDirektur->tanggal_dibuat),
                    'direktur_nama' => $direktur_nama_tanpa_gelar,
                    'direktur_nip' => $direktur_nip,
                ];
                $html = view('template-surat.sk-direktur.pdf', ['data' => $data, 'surat' => $surat])->render();

                $safeNomor = str_replace(['/', '\\', '*', ':', '?', '"', '<', '>', '|'], '-', $surat->nomor_surat);
                $newPath = $savePermanently ? 'arsip/SK Direktur-' . $safeNomor . '.pdf' : 'temp/pdf/SK-' . $safeNomor . '-' . uniqid() . '.pdf';
                $margins = [
                    'width' => '215.9mm',
                    'height' => '330.2mm',
                    'top' => '10mm',
                    'bottom' => '10mm',
                    'left' => '15mm',
                    'right' => '15mm'
                ];
                return $this->generatePdfWithPuppeteer($html, $surat, $newPath, $margins, $savePermanently);
            } elseif ($surat->suratUndangan) {
                $data = [
                    'nomor_surat' => $surat->suratUndangan->nomor_surat,
                    'lampiran' => $surat->suratUndangan->lampiran,
                    'hal' => $surat->suratUndangan->hal,
                    'kepada' => $surat->suratUndangan->kepada,
                    'tempat_dibuat' => $surat->suratUndangan->tempat_dibuat,
                    'tanggal_dibuat' => optional($surat->suratUndangan->tanggal_dibuat)->format('Y-m-d'),
                    'hari_acara' => $surat->suratUndangan->hari_acara,
                    'tanggal_acara' => optional($surat->suratUndangan->tanggal_acara)->format('Y-m-d'),
                    'tempat_acara' => $surat->suratUndangan->tempat_acara,
                    'keperluan' => $surat->suratUndangan->keperluan,
                    'nama_tertanda' => $surat->suratUndangan->nama_tertanda,
                    'nip_tertanda' => $surat->suratUndangan->nip_tertanda,
                    'jabatan_tertanda' => $surat->suratUndangan->jabatan_tertanda,
                    'nama_kegiatan' => $surat->suratUndangan->nama_kegiatan,
                    'jam_mulai' => $surat->suratUndangan->jam_mulai,
                    'jam_selesai' => $surat->suratUndangan->jam_selesai,
                    'keterangan_waktu' => $surat->suratUndangan->keterangan_waktu,
                ];
                $html = view('template-surat.surat-undangan.pdf', ['data' => $data, 'surat' => $surat])->render();

                $safeNomor = str_replace(['/', '\\', '*', ':', '?', '"', '<', '>', '|'], '-', $surat->nomor_surat);
                $newPath = $savePermanently ? 'arsip/Surat Undangan-' . $safeNomor . '.pdf' : 'temp/pdf/Undangan-' . $safeNomor . '-' . uniqid() . '.pdf';
                $margins = [
                    'width' => '215.9mm',
                    'height' => '330.2mm',
                    'top' => '10mm',
                    'bottom' => '20mm',
                    'left' => '30mm',
                    'right' => '25mm'
                ];
                return $this->generatePdfWithPuppeteer($html, $surat, $newPath, $margins, $savePermanently);
            }
        } catch (\Exception $e) {
            Log::error('Regeneration failed for surat id ' . $surat->id_surat . ': ' . $e->getMessage());
            return null;
        }

        return null;
    }

    protected function generatePdfWithPuppeteer($html, Surat $surat, $newPath, $margins = null, $savePermanently = false)
    {
        $fullPath = storage_path('app/' . $newPath);
        $directory = dirname($fullPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        if (!$margins) {
            $margins = [
                'width' => '215.9mm',
                'height' => '330.2mm',
                'top' => '10mm',
                'bottom' => '10mm',
                'left' => '15mm',
                'right' => '15mm'
            ];
        }

        try {
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                @mkdir($tempDir, 0755, true);
            }
            $tempHtmlFile = $tempDir . DIRECTORY_SEPARATOR . 'temp-pdf-' . uniqid() . '.html';
            file_put_contents($tempHtmlFile, $html);
            Log::info('Wrote temp HTML for Puppeteer', ['temp_html' => $tempHtmlFile, 'surat_id' => $surat->id_surat]);

            $nodePath = env('NODE_PATH', null);
            if (!$nodePath) {
                if (stripos(PHP_OS, 'WIN') === 0) {
                    $whereOut = [];
                    @exec('where node 2>&1', $whereOut, $whereRc);
                    if (!empty($whereOut)) {
                        $nodePath = trim($whereOut[0]);
                    } else {
                        $nodePath = 'node';
                    }
                } else {
                    $whichOut = [];
                    @exec('which node 2>&1', $whichOut, $whichRc);
                    if (!empty($whichOut)) {
                        $nodePath = trim($whichOut[0]);
                    } else {
                        $nodePath = 'node';
                    }
                }
            }
            Log::info('Resolved node binary for Puppeteer', ['node' => $nodePath, 'surat_id' => $surat->id_surat]);

            $chromePath = env('CHROME_PATH', '');

            $configFile = $tempDir . DIRECTORY_SEPARATOR . 'pdf-config-' . uniqid() . '.json';
            $nodeLogFile = $tempDir . DIRECTORY_SEPARATOR . 'node-log-' . uniqid() . '.txt';
            $config = [
                'inputPath' => $tempHtmlFile,
                'outputPath' => $fullPath,
                'width' => $margins['width'],
                'height' => $margins['height'],
                'marginTop' => $margins['top'],
                'marginBottom' => $margins['bottom'],
                'marginLeft' => $margins['left'],
                'marginRight' => $margins['right'],
                'chromePath' => $chromePath ?: null,
                'logFile' => $nodeLogFile,
            ];
            file_put_contents($configFile, json_encode($config, JSON_UNESCAPED_SLASHES));

            $jsRenderer = base_path('resources' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'pdf-renderer.js');

            $cmdArray = [$nodePath, $jsRenderer, $configFile];
            $descriptors = [
                0 => ['pipe', 'r'],  
                1 => ['pipe', 'w'],  
                2 => ['pipe', 'w'],  
            ];

            Log::debug('Launching Puppeteer via proc_open (no shell)', [
                'cmd' => $cmdArray,
                'cwd' => base_path(),
                'config' => $config,
                'surat_id' => $surat->id_surat
            ]);

            $process = proc_open($cmdArray, $descriptors, $pipes, base_path());

            if (!is_resource($process)) {
                throw new \Exception('proc_open failed to start Node.js process');
            }

            fclose($pipes[0]);
            $stdout = stream_get_contents($pipes[1]);
            $stderr = stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            $returnVar = proc_close($process);

            $outputString = trim($stdout . "\n" . $stderr);
            $nodeLogContent = file_exists($nodeLogFile) ? file_get_contents($nodeLogFile) : '';
            $pdfCreated = file_exists($fullPath) && filesize($fullPath) > 0;

            Log::debug('Puppeteer output', [
                'return' => $returnVar,
                'stdout' => $stdout,
                'stderr' => $stderr,
                'node_log' => $nodeLogContent,
                'pdf_created' => $pdfCreated,
                'surat_id' => $surat->id_surat
            ]);

            @unlink($configFile);
            @unlink($nodeLogFile);
            if ($pdfCreated) {
                @unlink($tempHtmlFile);
            }

            $returnVar = $pdfCreated ? 0 : 1;

            if (!$pdfCreated) {
                Log::error('Puppeteer command failed', [
                    'cmd' => $cmdArray,
                    'return_code' => $returnVar,
                    'output' => $outputString,
                    'file_exists' => file_exists($fullPath),
                    'surat_id' => $surat->id_surat
                ]);
                throw new \Exception('Puppeteer failed (code ' . $returnVar . '): ' . $outputString);
            }

            Log::info('Puppeteer PDF generated successfully', [
                'surat_id' => $surat->id_surat,
                'path' => $fullPath,
                'size' => filesize($fullPath)
            ]);
        } catch (\Throwable $e) {
            Log::error('Puppeteer failed for surat ' . $surat->id_surat . ', falling back to DomPDF: ' . $e->getMessage(), ['exception' => $e]);
            try {
                $pdf = Pdf::loadHTML($html)
                    ->setPaper([0, 0, 612, 936], 'portrait')
                    ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
                Storage::put($newPath, $pdf->output());
            } catch (\Throwable $domPdfError) {
                Log::error('DomPDF also failed for surat ' . $surat->id_surat . ': ' . $domPdfError->getMessage(), ['exception' => $domPdfError]);
                throw $domPdfError;
            }
        }

        if ($savePermanently) {
            $surat->update(['file_path' => $newPath]);
        }

        return $fullPath;
    }

    protected function formatDateValue($value)
    {
        if ($value instanceof \Carbon\CarbonInterface) {
            return $value->format('Y-m-d');
        }

        if (is_string($value) && trim($value) !== '') {
            try {
                return Carbon::parse($value)->format('Y-m-d');
            } catch (\Throwable $e) {
                return now()->format('Y-m-d');
            }
        }

        return now()->format('Y-m-d');
    }
}
