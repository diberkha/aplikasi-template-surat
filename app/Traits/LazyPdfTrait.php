<?php

namespace App\Traits;

use App\Models\Surat;
use App\Models\Pegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

trait LazyPdfTrait
{
    protected function ensurePdfExists(Surat $surat)
    {
        $path = storage_path('app/' . $surat->file_path);

        if ($surat->file_path && file_exists($path)) {
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
            return $path;
        }

        try {
            $direktur = Pegawai::getDirektur();
            $direktur_nama = $direktur ? $direktur->nama : 'Dr. dr. Kinik Darsono, M.Pd.Ked.';
            $direktur_nip = $direktur ? $direktur->nip : '19710415 200903 1 001';

            if ($surat->sop) {
                $data = [
                    'judul_sop' => $surat->sop->judul_sop,
                    'nomor_dokumen' => $surat->sop->nomor_dokumen,
                    'nomor_revisi' => $surat->sop->nomor_revisi,
                    'halaman' => $surat->sop->halaman,
                    'tanggal_terbit' => $surat->sop->tanggal_terbit,
                    'pengertian' => $surat->sop->pengertian,
                    'tujuan' => explode("\n", $surat->sop->tujuan),
                    'kebijakan' => $surat->sop->kebijakan,
                    'prosedur' => explode("\n", $surat->sop->prosedur),
                    'unit_terkait' => $surat->sop->unit_terkait,
                    'direktur_nama' => $direktur_nama,
                    'direktur_nip' => $direktur_nip,
                ];
                $pdf = Pdf::loadView('template-surat.sop.pdf', ['data' => $data])->setOptions(['defaultFont' => 'Times New Roman']);
                $newPath = 'surat/' . $surat->nomor_surat . '.pdf';
                Storage::put($newPath, $pdf->output());
                $surat->update(['file_path' => $newPath]);
                return storage_path('app/' . $newPath);
            } elseif ($surat->skDirektur) {
                $data = [
                    'nomor_surat' => $surat->nomor_surat,
                    'tentang' => $surat->skDirektur->tentang,
                    'menimbang' => explode("\n", $surat->skDirektur->menimbang),
                    'mengingat' => $surat->skDirektur->mengingat,
                    'memutuskan' => $surat->skDirektur->memutuskan,
                    'menetapkan' => $surat->skDirektur->menetapkan,
                    'tempat_surat' => $surat->skDirektur->tempat_dibuat,
                    'tanggal_dibuat' => $surat->skDirektur->tanggal_dibuat,
                    'direktur_nama' => $direktur_nama,
                    'direktur_nip' => $direktur_nip,
                ];
                $html = view('template-surat.sk-direktur.pdf', ['data' => $data, 'surat' => $surat])->render();
                $pdf = Pdf::loadHTML($html)->setPaper([0, 0, 612, 936], 'portrait')->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isFontSubsettingEnabled' => false,
                    'defaultFont' => 'Cambria',
                    'fontDir' => storage_path('fonts'),
                    'fontCache' => storage_path('fonts')
                ]);
                $newPath = 'arsip/SK Direktur-' . str_replace('/', '-', $surat->nomor_surat) . '.pdf';
                Storage::put($newPath, $pdf->output());
                $surat->update(['file_path' => $newPath]);
                return storage_path('app/' . $newPath);
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
        }

        return $path;
    }
}
