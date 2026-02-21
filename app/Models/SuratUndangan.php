<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratUndangan extends Model
{
    protected $table = 'surat_undangan';
    protected $primaryKey = 'id_surat_undangan';

    protected $fillable = [
        'nomor_surat',
        'lampiran',
        'hal',
        'kepada',
        'tempat_dibuat',
        'tanggal_dibuat',
        'hari_acara',
        'tanggal_acara',
        'nama_kegiatan',
        'jam_mulai',
        'jam_selesai',
        'keterangan_waktu',
        'tempat_acara',
        'keperluan',
        'nama_tertanda',
        'nip_tertanda',
        'jabatan_tertanda',
        'id_surat',
    ];

    protected $casts = [
        'tanggal_dibuat' => 'date',
        'tanggal_acara' => 'date',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
