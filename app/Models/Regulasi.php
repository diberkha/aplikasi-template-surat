<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regulasi extends Model
{
    protected $table = 'regulasi';
    protected $primaryKey = 'id_regulasi';
    public $timestamps = true;

    protected $fillable = [
        'id_template_surat',
        'id_surat',
        'isi_regulasi',
        'created_by',
    ];

    protected $casts = [
        'isi_regulasi' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'isi_regulasi' => '{"menimbang": "", "mengingat": ""}',
    ];

    public function template()
    {
        return $this->belongsTo(TemplateSurat::class, 'id_template_surat');
    }

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getMenimbangAttribute()
    {
        $isi = $this->isi_regulasi;
        if (is_array($isi)) {
            return $isi['menimbang'] ?? '';
        }
        return '';
    }

    public function getMengingatAttribute()
    {
        $isi = $this->isi_regulasi;
        if (is_array($isi)) {
            return $isi['mengingat'] ?? '';
        }
        return '';
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('Y-m-d') : 'N/A';
    }
}