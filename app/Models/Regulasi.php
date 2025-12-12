<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regulasi extends Model
{
    protected $table = 'regulasi';
    protected $primaryKey = 'id_regulasi';
    public $timestamps = true;

    protected $fillable = [
        'isi_regulasi',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('Y-m-d') : 'N/A';
    }
}