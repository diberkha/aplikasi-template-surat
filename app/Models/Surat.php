<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table = 'surat';
    protected $primaryKey = 'id_surat';

    protected $fillable = [
        'nama_surat',
        'nomor_surat',
        'tanggal_dibuat',
        'file_path',
        'id_template_surat',
        'id_regulasi',
        'created_by',
    ];

    protected $casts = [
        'tanggal_dibuat' => 'date',
    ];

    public function template()
    {
        return $this->belongsTo(TemplateSurat::class, 'id_template_surat');
    }

    public function regulasi()
    {
        return $this->belongsTo(Regulasi::class, 'id_regulasi');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function skDirektur()
    {
        return $this->hasOne(SKDirektur::class, 'id_surat');
    }

    public function getTipeSuratAttribute()
    {
        return $this->template ? $this->template->nama_template_surat : 'Tidak ada template';
    }
}