<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;

class DraftSuratController extends Controller
{
    public function sopIndex()
    {
        $drafts = Surat::with(['sop.contents', 'createdBy.ruangan', 'template'])
            ->where('is_draft', true)
            ->where('created_by', auth()->id())
            ->whereHas('template', function ($query) {
                $query->where('nama_template_surat', 'like', '%SOP%')
                    ->orWhere('nama_template_surat', 'like', '%Standar Operasional Prosedur%');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $drafts = $drafts->map(function ($item) {
            $sopData = $item->sop;
            $firstPage = $item->sop && $item->sop->contents->isNotEmpty() ? $item->sop->contents->first() : null;

            return [
                'id_surat' => $item->id_surat,
                'nama_surat' => $item->nama_surat,
                'nomor_surat' => $item->nomor_surat,
                'created_at' => $item->created_at->toDateTimeString(),
                'username' => $item->createdBy->username ?? 'Unknown',
                'ruangan' => $item->createdBy->ruangan->nama_ruangan ?? '-',
                'sop' => $sopData ? [
                    'id_sop' => $sopData->id_sop,
                    'judul_sop' => $firstPage ? $firstPage->judul_sop : ($sopData->judul_sop ?? $item->nama_surat),
                    'nomor_dokumen' => $firstPage ? $firstPage->nomor_dokumen : ($sopData->nomor_dokumen ?? $item->nomor_surat),
                ] : null,
            ];
        });

        $regulasis = \App\Models\Regulasi::all();
        $units = \App\Models\Unit::all();
        return view('draft-surat.sop.index', compact('drafts', 'regulasis', 'units'));
    }

    public function skDirekturIndex()
    {
        $drafts = Surat::with(['skDirektur', 'createdBy.ruangan', 'template'])
            ->where('is_draft', true)
            ->where('created_by', auth()->id())
            ->whereHas('template', function ($query) {
                $query->where('nama_template_surat', 'like', '%SK Direktur%')
                    ->orWhere('nama_template_surat', 'like', '%Surat Keputusan Direktur%');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $drafts = $drafts->map(function ($item) {
            return [
                'id_surat' => $item->id_surat,
                'nama_surat' => $item->nama_surat,
                'nomor_surat' => $item->nomor_surat,
                'created_at' => $item->created_at->toDateTimeString(),
                'username' => $item->createdBy->username ?? 'Unknown',
                'ruangan' => $item->createdBy->ruangan->nama_ruangan ?? '-',
                'sk_direktur' => $item->skDirektur,
            ];
        });

        $regulasis = \App\Models\Regulasi::all();
        return view('draft-surat.sk-direktur.index', compact('drafts', 'regulasis'));
    }

    public function cutiIndex()
    {
        $drafts = Surat::with(['cuti', 'createdBy.ruangan', 'template'])
            ->where('is_draft', true)
            ->where('created_by', auth()->id())
            ->whereHas('template', function ($query) {
                $query->where('nama_template_surat', 'like', '%Cuti%')
                    ->orWhere('nama_template_surat', 'like', '%Izin Cuti%');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $drafts = $drafts->map(function ($item) {
            return [
                'id_surat' => $item->id_surat,
                'nama_surat' => $item->nama_surat,
                'nomor_surat' => $item->nomor_surat,
                'created_at' => $item->created_at->toDateTimeString(),
                'username' => $item->createdBy->username ?? 'Unknown',
                'ruangan' => $item->createdBy->ruangan->nama_ruangan ?? '-',
                'cuti' => $item->cuti,
            ];
        });

        $pegawais = \App\Models\Pegawai::orderBy('nama', 'asc')->get();
        return view('draft-surat.cuti.index', compact('drafts', 'pegawais'));
    }
}
