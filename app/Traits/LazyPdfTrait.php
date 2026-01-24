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

trait LazyPdfTrait
{
    protected function ensurePdfExists(Surat $surat)
    {
        $path = storage_path('app/' . $surat->file_path);

        if ($surat->file_path && file_exists($path) && is_file($path)) {
            return $path;
        }

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
            return ($path && file_exists($path) && is_file($path)) ? $path : null;
        }

        try {
            $direktur = Pegawai::getDirektur();
            $direktur_nama = $direktur ? $direktur->nama : 'Dr. dr. Kinik Darsono, M.Pd.Ked.';
            $direktur_nip = $direktur ? $direktur->nip : '19710415 200903 1 001';

            if ($surat->sop) {
                $kebijakanText = trim($surat->sop->kebijakan);
                $kebijakanResolved = [];
                if (!empty($kebijakanText)) {
                    $kebijakanLines = preg_split('/\r\n|\r|\n/', $kebijakanText);
                    $kebijakanIds = [];
                    foreach ($kebijakanLines as $line) {
                        if (preg_match('/^\d+\.\s*(\d+)/', trim($line), $matches)) {
                            $kebijakanIds[] = (int)$matches[1];
                        }
                    }
                    if (!empty($kebijakanIds)) {
                        $kebijakanResolved = Regulasi::whereIn('id_regulasi', $kebijakanIds)
                            ->orderByRaw('FIELD(id_regulasi, ' . implode(',', $kebijakanIds) . ')')
                            ->pluck('isi_regulasi')
                            ->toArray();
                    }
                }

                $unitText = trim($surat->sop->unit_terkait);
                $unitResolved = [];
                if (!empty($unitText)) {
                    $unitLines = preg_split('/\r\n|\r|\n/', $unitText);
                    $unitIds = [];
                    foreach ($unitLines as $line) {
                        if (preg_match('/^\d+\.\s*(\d+)/', trim($line), $matches)) {
                            $unitIds[] = (int)$matches[1];
                        }
                    }
                    if (!empty($unitIds)) {
                        $unitResolved = Unit::whereIn('id_unit', $unitIds)
                            ->orderByRaw('FIELD(id_unit, ' . implode(',', $unitIds) . ')')
                            ->pluck('nama_unit')
                            ->toArray();
                    }
                }

                $data = [
                    'judul_sop' => $surat->sop->judul_sop,
                    'nomor_dokumen' => $surat->sop->nomor_dokumen,
                    'nomor_revisi' => $surat->sop->nomor_revisi,
                    'halaman' => $surat->sop->halaman,
                    'tanggal_terbit' => $surat->sop->tanggal_terbit,
                    'pengertian' => $surat->sop->pengertian,
                    'tujuan' => explode("\n", $surat->sop->tujuan),
                    'kebijakan' => $kebijakanResolved,
                    'prosedur' => explode("\n", $surat->sop->prosedur),
                    'unit_terkait' => $unitResolved,
                    'direktur_nama' => $direktur_nama,
                    'direktur_nip' => $direktur_nip,
                ];
                $pdf = Pdf::loadView('template-surat.sop.pdf', ['data' => $data])->setOptions(['defaultFont' => 'Times New Roman']);
                $newPath = 'surat/' . $surat->nomor_surat . '.pdf';
                Storage::put($newPath, $pdf->output());
                $surat->update(['file_path' => $newPath]);
                return storage_path('app/' . $newPath);
            } elseif ($surat->skDirektur) {
                $mengingatText = trim($surat->skDirektur->mengingat);
                $mengingatResolved = [];
                if (!empty($mengingatText)) {
                    $mengingatLines = preg_split('/\r\n|\r|\n/', $mengingatText);
                    $mengingatIds = [];
                    foreach ($mengingatLines as $line) {
                        if (preg_match('/^\d+\.\s*(\d+)/', trim($line), $matches)) {
                            $mengingatIds[] = (int)$matches[1];
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
                    'tanggal_dibuat' => $surat->skDirektur->tanggal_dibuat,
                    'direktur_nama' => $direktur_nama_tanpa_gelar,
                    'direktur_nip' => $direktur_nip,
                ];
                $html = view('template-surat.sk-direktur.pdf', ['data' => $data, 'surat' => $surat])->render();

                $newPath = 'arsip/SK Direktur-' . str_replace('/', '-', $surat->nomor_surat) . '.pdf';
                $fullPath = storage_path('app/' . $newPath);

                $directory = dirname($fullPath);
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                $browsershot = \Spatie\Browsershot\Browsershot::html($html)
                    ->setOption('args', ['--no-sandbox', '--disable-setuid-sandbox', '--disable-gpu', '--disable-software-rasterizer'])
                    ->newHeadless()
                    ->timeout(120)
                    ->showBackground()
                    ->paperSize(8.5, 13, 'in')
                    ->margins(0, 0, 0, 0);

                $nodeBinary = env('NODE_BINARY', 'C:\\Program Files\\nodejs\\node.exe');
                if (is_string($nodeBinary) && $nodeBinary !== '') {
                    $browsershot->setNodeBinary($nodeBinary);
                }

                $chromePath = env('CHROME_PATH');
                if (!is_string($chromePath) || $chromePath === '' || !file_exists($chromePath)) {
                    $puppeteerPathEnv = env('PUPPETEER_EXECUTABLE_PATH');
                    if (is_string($puppeteerPathEnv) && $puppeteerPathEnv !== '' && file_exists(base_path($puppeteerPathEnv))) {
                        $chromePath = base_path($puppeteerPathEnv);
                    } else {
                        $base = base_path('node_modules/puppeteer/.local-chromium');
                        if (file_exists($base)) {
                            $candidates = glob($base . '/win64-*/chrome-win/chrome.exe');
                            if (is_array($candidates) && count($candidates) > 0) {
                                $chromePath = $candidates[0];
                            }
                        }
                        if (!is_string($chromePath) || $chromePath === '' || !file_exists($chromePath)) {
                            $edgeCandidates = [
                                'C:\\Program Files\\Microsoft\\Edge\\Application\\msedge.exe',
                                'C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe'
                            ];
                            foreach ($edgeCandidates as $edgePath) {
                                if (file_exists($edgePath)) { $chromePath = $edgePath; break; }
                            }
                        }
                    }
                }
                if (is_string($chromePath) && $chromePath !== '' && file_exists($chromePath)) {
                    $browsershot->setChromePath($chromePath);
                }

                try {
                    $browsershot->save($fullPath);
                } catch (\Throwable $bsEx) {
                    \Illuminate\Support\Facades\Log::error('Browsershot failed, falling back to DomPDF for surat id ' . $surat->id_surat . ': ' . $bsEx->getMessage());
                    $pdf = Pdf::loadHTML($html)->setPaper([0, 0, 612, 936], 'portrait')->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
                    \Illuminate\Support\Facades\Storage::put($newPath, $pdf->output());
                }

                $surat->update(['file_path' => $newPath]);
                return $fullPath;
            } elseif ($surat->cuti) {
                $data = [
                    'kategori' => $surat->cuti->kategori,
                    'form' => $surat->cuti->form_data,
                    'nomor_surat' => $surat->nomor_surat,
                    'direktur_nama' => $direktur_nama,
                    'direktur_nip' => $direktur_nip,
                ];
                $view = 'template-surat.cuti.cuti-pns.pdf';
                if ($data['kategori'] === 'PPPK')
                    $view = 'template-surat.cuti.cuti-pppk.pdf';
                if ($data['kategori'] === 'NON ASN')
                    $view = 'template-surat.cuti.cuti-nonasn.pdf';

                $html = view($view, ['data' => $data, 'surat' => $surat])->render();
                $pdf = Pdf::loadHTML($html)->setPaper([0, 0, 612, 936], 'portrait')->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
                $newPath = 'arsip/' . $surat->nomor_surat . '.pdf';
                Storage::put($newPath, $pdf->output());
                $surat->update(['file_path' => $newPath]);
                return storage_path('app/' . $newPath);
            }
        } catch (\Exception $e) {
            Log::error('Regeneration failed for surat id ' . $surat->id_surat . ': ' . $e->getMessage());
            return null;
        }

        return ($path && file_exists($path) && is_file($path)) ? $path : null;
    }
}
