<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegPeriksa extends Model
{
    protected $table = 'reg_periksa';
    protected $guarded = [];

    public $timestamps = false;
    // protected $appends = ['nm_dokter'];
    protected $visible = ['no_rawat','no_rkm_medis', 'kd_dokter' , 'kd_poli', 'kontak_wa', 'tgl_registrasi', 'no_reg'];

    public function poli()
    {
        return $this->hasOne('App\Models\Poli', 'kd_poli', 'kd_poli');
    }

    public function dokter()
    {
        return $this->hasOne('App\Models\Dokter', 'kd_dokter', 'kd_dokter');
    }

    public function penjab()
    {
        return $this->hasOne('App\Models\Penjab', 'pj', 'pj');
    }

    public function pasien()
    {
        return $this->hasOne('App\Models\pasien', 'no_rkm_medis', 'no_rkm_medis');
    }

    // public function getNmDokterAttribute()
    // {
    //     return $this->dokter->nm_dokter;
    // }
}
