<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiKas extends Model
{
    protected $table  = 'mutasikas';
    protected $primaryKey = 'ID';
    protected $guarded = ['ID'];
    public $timestamps = false;

}
