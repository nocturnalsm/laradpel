<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailAjuBiaya extends Model
{
    protected $table  = 'detail_aju_biaya';
    protected $primaryKey = 'ID';
    protected $guarded = ['ID'];
    public $timestamps = false;
    
}
