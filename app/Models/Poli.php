<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $table = 'poliklinik';
    // protected $primaryKey = 'kd_poli';
    protected $visible = ['nm_poli'];
    protected $hidden = ['registrasi', 'registrasilama' ,'status'];
    // protected $appends = ['nm_poli'];

    public function regPeriksa()
    {
        return $this->belongsTo('App\Models\RegPeriksa', 'kd_poli');
    }

    public function jadwalDokter()
    {
        return $this->belongsTo('App\Models\JadwalDokter', 'kd_poli', 'kd_poli');
    }

    // public function getNmPoliAttribute($value)
    // {
    //     return $this->attributes['nm_poli'];
    // }

}
