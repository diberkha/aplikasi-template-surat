<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SOP extends Model
{
    protected $table = 'sop';
    protected $primaryKey = 'id_sop';

    protected $fillable = [
        'id_surat',
    ];

    protected $casts = [];

    public function contents()
    {
        return $this->hasMany(SOPContent::class, 'id_sop')->orderBy('id_sop_page', 'asc');
    }

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
