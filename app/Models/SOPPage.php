<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SOPPage extends Model
{
    protected $table = 'sop_pages';
    protected $primaryKey = 'id_sop_page';

    protected $fillable = [
        'id_sop',
        'judul_sop',
        'nomor_dokumen',
        'nomor_revisi',
        'halaman',
        'tanggal_terbit',
        'pengertian',
        'tujuan',
        'kebijakan',
        'prosedur',
        'unit_terkait',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];

    protected $appends = [
        'tujuan_array',
        'prosedur_array',
        'kebijakan_array',
        'unit_terkait_array',
        'tanggal_terbit_formatted',
    ];

    public function getTujuanArrayAttribute()
    {
        return !empty($this->tujuan) ? explode("\n", $this->tujuan) : [''];
    }

    public function getProsedurArrayAttribute()
    {
        return !empty($this->prosedur) ? explode("\n", $this->prosedur) : [''];
    }

    public function getKebijakanArrayAttribute()
    {
        $kebijakanText = trim($this->kebijakan ?? '');
        $kebijakanArray = [];
        if (!empty($kebijakanText)) {
            $items = preg_split('/\r\n|\r|\n/', $kebijakanText);
            foreach ($items as $item) {
                if (preg_match('/^\d+\.\s*(\d+)/', trim($item), $matches)) {
                    $kebijakanArray[] = (int) $matches[1];
                }
            }
        }
        return $kebijakanArray;
    }

    public function getUnitTerkaitArrayAttribute()
    {
        $unitText = trim($this->unit_terkait ?? '');
        $unitArray = [];
        if (!empty($unitText)) {
            $items = preg_split('/\r\n|\r|\n/', $unitText);
            foreach ($items as $item) {
                if (preg_match('/^\d+\.\s*(\d+)/', trim($item), $matches)) {
                    $unitArray[] = (int) $matches[1];
                }
            }
        }
        return $unitArray;
    }

    public function getTanggalTerbitFormattedAttribute()
    {
        return optional($this->tanggal_terbit)->format('Y-m-d');
    }

    public function sop()
    {
        return $this->belongsTo(SOP::class, 'id_sop');
    }
}
