<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keputusan extends Model
{
    protected $table = 'keputusan';
    protected $primaryKey = 'id_keputusan';
    public $timestamps = true;

    protected $fillable = [
        'nama_keputusan',
    ];

    public function regulasis()
    {
        return $this->hasMany(Regulasi::class, 'id_keputusan');
    }
}
