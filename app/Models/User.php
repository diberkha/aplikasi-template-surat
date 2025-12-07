<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'password',
        'id_ruangan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function surat()
    {
        return $this->hasMany(Surat::class, 'created_by');
    }

    public function regulasi()
    {
        return $this->hasMany(Regulasi::class, 'created_by');
    }
}