<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratIzinCuti extends Model
{
    use HasFactory;

    protected $table = 'surat_izin_cuti';
    protected $primaryKey = 'id_cuti';

    protected $fillable = [
        'id_surat',
        'kategori',
        'form_data',
    ];

    protected $casts = [
        'form_data' => 'array',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat', 'id_surat');
    }
}
