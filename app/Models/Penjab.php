<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjab extends Model
{
    protected $table = 'penjab';

    public function regPeriksa()
    {
        return $this->belongsTo('App\Models\RegPeriksa', 'kd_pj');
    }
}
