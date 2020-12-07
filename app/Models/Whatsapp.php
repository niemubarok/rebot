<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Whatsapp extends Model
{
    use HasFactory;

    protected $table = 'whatsapp';
    protected $guarded = ['id'];

    protected $primaryKey = 'kontak';
    public $incrementing = false;


}
