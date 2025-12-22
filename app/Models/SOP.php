<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SOP extends Model
{
    protected $table = 'sop';
    protected $primaryKey = 'id_sop';

    protected $fillable = [
        'id_surat',
        'judul_sop',
        'nomor_dokumen',
        'nomor_revisi',
        'halaman',
        'tanggal_terbit',
        'pengertian',
        'tujuan',
        'kebijakan',
        'prosedur',
        'unit_terkait',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
