<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SKDirektur extends Model
{
    protected $table = 'sk_direktur';
    protected $primaryKey = 'id_sk_direktur';

    protected $fillable = [
        'judul_surat',
        'nomor_surat',
        'tentang',
        'menimbang',
        'mengingat',
        'memutuskan',
        'menetapkan',
        'tempat_dibuat',
        'tanggal_dibuat',
        'id_surat',
    ];

    protected $casts = [
        'tanggal_dibuat' => 'date',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}