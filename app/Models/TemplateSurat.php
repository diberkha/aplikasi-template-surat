<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateSurat extends Model
{
    protected $table = 'template_surat';
    protected $primaryKey = 'id_template_surat';

    protected $fillable = [
        'nama_template_surat',
    ];

    public function surat()
    {
        return $this->hasMany(Surat::class, 'id_template_surat');
    }

    public function regulasi()
    {
        return $this->hasMany(Regulasi::class, 'id_template_surat');
    }
}
