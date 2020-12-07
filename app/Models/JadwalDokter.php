<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    protected $table = 'jadwal';
    protected $visible = ['nm_poli', 'nm_dokter', 'jam_mulai', 'jam_selesai', 'hari_kerja'];
    // protected $appends = ['nm_poli'];

    public function dokter()
    {
        return $this->hasMany('App\Models\Dokter', 'kd_dokter', 'kd_dokter');
    }

    public function poli()
    {
        return $this->hasOne('App\Models\Poli', 'kd_poli', 'kd_poli');
    }


    public function getJamMulaiAttribute($jamMulai)
    {
        return date('s.i', $jamMulai);
    }
    public function getJamSelesaiAttribute($jamSelesai)
    {
        return date('s.i', $jamSelesai);
    }

    public function getNmDokterAttribute($dokter)
    {
        return "*$dokter*";
    }
}
