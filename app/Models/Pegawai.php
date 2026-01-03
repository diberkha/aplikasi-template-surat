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
        'tanggal_masuk',
        'sisa_cuti_tahunan',
        'sisa_cuti_n',
        'sisa_cuti_n1',
        'sisa_cuti_n2',
    ];
}
