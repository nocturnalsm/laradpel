<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;

class KodeAcc extends Model
{
    protected $table  = 'kode_acc';
    protected $primaryKey = 'KODEACC_ID';
    protected $guarded = ['KODEACC_ID'];
    public $timestamps = false;

    public static function add($fields)
  	{
        $check = KodeAcc::select("KODE")
                                ->where("KODE", $fields["input-kode"])
                                ->orWhere("URAIAN", $fields["input-uraian"]);
    		if ($check->count() > 0){
    			throw new \Exception("Kode Acc sudah ada");
    		}
    		$data = Array("KODE" => strtoupper($fields["input-kode"]),
    					  "URAIAN" => strtoupper($fields["input-uraian"]));
    		KodeAcc::create($data);
  	}
  	public static function edit($fields)
  	{
        $check = KodeAcc::select("KODE")
                              ->where(function($query) use ($fields){
                                  $query->where("KODE", $fields["input-kode"])
                                        ->orWhere("URAIAN", $fields["input-uraian"]);
                              })
                              ->where("KODEACC_ID" ,"<>", $fields["input-id"]);
    		if ($check->count() > 0){
    			throw new \Exception("Kode Acc sudah ada");
    		}
    		$data = Array( "KODE" => strtoupper(trim($fields["input-kode"])),
    					   "URAIAN" => trim($fields["input-uraian"]));
    		KodeAcc::where("KODEACC_ID", $fields["input-id"])->update($data);
  	}
  	public static function drop($id)
  	{
    		$checkStat = DB::table("detail_mutasi")
                     ->select("ID")->firstWhere("KODEACC_ID", $id);
    		if ($checkStat){
    			throw new \Exception("Kode Acc tidak dapat dihapus karena sudah dipakai di transaksi");
    		}
    		else {
    			$data = KodeAcc::find($id);
    			if ($data){
    				$data->delete();
    			}
    		}
  	}
}
