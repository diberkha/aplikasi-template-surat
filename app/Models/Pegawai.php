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
        'is_n_postponed',
        'is_n1_postponed',
    ];

    public static function getDirektur()
    {
        return self::whereRaw('LOWER(jabatan) = ?', ['direktur'])->first();
    }

    public function getAvailableCuti()
    {
        $total = $this->sisa_cuti_n + $this->sisa_cuti_n1 + $this->sisa_cuti_n2;
        return min(24, $total);
    }

    public function adjustLeaveBalance(int $days)
    {
        if ($this->jenis_pegawai === 'PNS') {
            if ($days < 0) {
                $remainingToSubtract = abs($days);

                $deductN2 = min($remainingToSubtract, $this->sisa_cuti_n2);
                $this->sisa_cuti_n2 -= $deductN2;
                $remainingToSubtract -= $deductN2;

                if ($remainingToSubtract > 0) {
                    $deductN1 = min($remainingToSubtract, $this->sisa_cuti_n1);
                    $this->sisa_cuti_n1 -= $deductN1;
                    $remainingToSubtract -= $deductN1;
                }

                if ($remainingToSubtract > 0) {
                    $this->sisa_cuti_n = max(0, $this->sisa_cuti_n - $remainingToSubtract);
                }
            } else {
                $this->sisa_cuti_n += $days;
            }

            $total_akumulasi = $this->sisa_cuti_n + $this->sisa_cuti_n1 + $this->sisa_cuti_n2;
            $this->sisa_cuti_tahunan = min(24, $total_akumulasi);
        } else {
            $this->sisa_cuti_n = max(0, $this->sisa_cuti_n + $days);
            $this->sisa_cuti_tahunan = $this->sisa_cuti_n;
        }

        $this->save();
    }
}
