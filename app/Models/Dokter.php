<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';

    public function regPeriksa()
    {
        return $this->belongsTo('App\Models\RegPeriksa', 'kd_dokter' );
    }

    public function jadwalDokter()
    {
        return $this->belongsTo('App\Models\JadwalDokter', 'kd_dokter');
    }

    
}
