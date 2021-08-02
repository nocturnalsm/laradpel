<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;

class KodeParty extends Model
{
    protected $table  = 'kode_party';
    protected $primaryKey = 'KODEPARTY_ID';
    protected $guarded = ['KODEPARTY_ID'];
    public $timestamps = false;

    public static function add($fields)
  	{
        $check = KodeParty::select("KODE")
                                ->where("KODE", $fields["input-kode"])
                                ->orWhere("URAIAN", $fields["input-uraian"]);
    		if ($check->count() > 0){
    			throw new \Exception("Kode Party sudah ada");
    		}
    		$data = Array("KODE" => strtoupper($fields["input-kode"]),
    					  "URAIAN" => strtoupper($fields["input-uraian"]));
    		KodeParty::create($data);
  	}
  	public static function edit($fields)
  	{
        $check = KodeParty::select("KODE")
                              ->where(function($query) use ($fields){
                                  $query->where("KODE", $fields["input-kode"])
                                        ->orWhere("URAIAN", $fields["input-uraian"]);
                              })
                              ->where("KODEPARTY_ID" ,"<>", $fields["input-id"]);
    		if ($check->count() > 0){
    			throw new \Exception("Kode Party sudah ada");
    		}
    		$data = Array( "KODE" => strtoupper(trim($fields["input-kode"])),
    					   "URAIAN" => trim($fields["input-uraian"]));
    		KodeParty::where("KODEPARTY_ID", $fields["input-id"])->update($data);
  	}
  	public static function drop($id)
  	{
    		$checkStat = DB::table("detail_mutasi")
                     ->select("ID")->firstWhere("KODEPARTY_ID", $id);
    		if ($checkStat){
    			throw new \Exception("Kode Party tidak dapat dihapus karena sudah dipakai di transaksi");
    		}
    		else {
    			$data = KodeParty::find($id);
    			if ($data){
    				$data->delete();
    			}
    		}
  	}
}
