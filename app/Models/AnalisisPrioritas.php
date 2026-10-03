<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Laporan;

class AnalisisPrioritas extends Model
{
    protected $table = 'analisis_prioritas';

    protected $fillable = [
        'laporan_id',
    
        'p1_fasum',
        'jarak_fasum',
    
        'p2_jalan',
        'jenis_jalan',
    
        'p3_kepadatan',
        'kategori_kepadatan',
    
        'skor_prioritas',
        'kategori_prioritas',
    ];
    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}