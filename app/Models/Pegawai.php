<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'jenis_pegawai',
        'masa_kerja',
        'sisa_cuti_tahunan',
        'sisa_cuti_n',
        'sisa_cuti_n1',
        'sisa_cuti_n2',
    ];

    public static function getDirektur()
    {
        return self::whereRaw('LOWER(jabatan) = ?', ['direktur'])->first();
    }
}
