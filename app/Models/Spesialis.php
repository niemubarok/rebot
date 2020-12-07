<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spesialis extends Model
{
    protected $table = 'spesialis';

    public function dokter()
    {
        return $this->belongsTo('App\Models\Dokter', 'kd_sps');
    }
}
