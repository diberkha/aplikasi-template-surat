<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';
    protected $primaryKey = 'id_ruangan';

    protected $fillable = [
        'nama_ruangan',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_ruangan');
    }
}