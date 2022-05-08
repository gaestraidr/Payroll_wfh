<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pegawai extends Authenticatable
{
    use Notifiable;

    protected $table = 'pegawai';

    public function jabatan()
    {
        return $this->belongsTo('App\Models\Jabatan')->withDefault(['nama_jabatan' => 'Tanpa Jabatan', 'gaji_pokok' => 0, 'remote_absen' => 0]);;
    }

    public function absensis()
    {
        return $this->hasMany('App\Models\Absensi');
    }

    public function izins()
    {
        return $this->hasMany('App\Models\Izin');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'jabatan_id',
        'no_rek',
        'role',
        'jumlah_cuti'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
