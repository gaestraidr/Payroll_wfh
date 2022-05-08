<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    public function pegawais()
    {
        return $this->hasMany('App\Models\Pegawai');
    }

    protected $fillable = [
        'nama_jabatan',
        'gaji_pokok',
        'remote_absen'
    ];
}
