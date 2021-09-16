<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AjuBiaya extends Model
{
    protected $table  = 'ajubiaya';
    protected $primaryKey = 'ID';
    protected $guarded = ['ID'];
    public $timestamps = false;

    public function details()
    {
        return $this->hasMany(DetailAjuBiaya::class, "ID_HEADER", "ID");
    }
}
