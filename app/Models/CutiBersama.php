<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiBersama extends Model
{
    use HasFactory;

    protected $table = 'cuti_bersama';

    protected $fillable = [
        'jenis_cuti_bersama',
        'tahun',
        'jumlah_hari',
        'is_perhitungan_cuti_tahunan',
        'catatan',
    ];

    protected $casts = [
        'is_perhitungan_cuti_tahunan' => 'boolean',
        'tahun' => 'integer',
        'jumlah_hari' => 'integer',
    ];
}
