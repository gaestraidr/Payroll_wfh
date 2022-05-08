<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }

    protected $fillable = [
        'keterangan',
        'photo',
        'tanggal_izin',
        'sampai_tanggal',
        'pegawai_id',
        'approval'
    ];
}
