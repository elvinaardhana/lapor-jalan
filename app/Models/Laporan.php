<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AnalisisPrioritas;

class Laporan extends Model
{
    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'foto',
        'latitude',
        'longitude',
        'alamat',
        'status',
        'tipe_lokasi',
        'geom'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function analisisPrioritas()
{
    return $this->hasOne(AnalisisPrioritas::class);
}


}