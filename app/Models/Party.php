<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;

class Party extends Model
{
    protected $table  = 'party';
    protected $primaryKey = 'PARTY_ID';
    protected $guarded = ['PARTY_ID'];
    public $timestamps = false;

    public static function add($fields)
  	{
		$kodeParty = KodeParty::find($fields["input-kodeparty"]);
		if ($kodeParty->URAIAN == 'KTP' || $kodeParty->URAIAN == 'NPWP'){
			$check = Party::select("NO_IDENTITAS")
						   ->where("NO_IDENTITAS", $fields["input-noid"])
						   ->where("KODE_PARTY", $fields["input-kodeparty"]);
			if ($check->count() > 0){
				throw new \Exception("No Identitas sudah ada");
			}
		}
		$data = Array("KODE_PARTY" => strtoupper($fields["input-kodeparty"]),
					"NO_IDENTITAS" => strtoupper($fields["input-noid"]),
					"NAMA" => strtoupper($fields["input-nama"]),
					"ALAMAT" => strtoupper($fields["input-alamat"]));
		Party::create($data);
  	}
  	public static function edit($fields)
  	{
		$kodeParty = KodeParty::find($fields["input-kodeparty"]);
		if ($kodeParty->URAIAN == 'KTP' || $kodeParty->URAIAN == 'NPWP'){
			$check = Party::select("NO_IDENTITAS")
								->where("NO_IDENTITAS", $fields["input-noid"])
								->where("KODE_PARTY", $fields["input-kodeparty"])
								->where("PARTY_ID" ,"<>", $fields["input-id"]);
			if ($check->count() > 0){
				throw new \Exception("No Identitas sudah ada");
			}
		}
        $data = Array("KODE_PARTY" => strtoupper($fields["input-kodeparty"]),
                      "NO_IDENTITAS" => strtoupper($fields["input-noid"]),
                      "NAMA" => strtoupper($fields["input-nama"]),
    					        "ALAMAT" => strtoupper($fields["input-alamat"]));

    		Party::where("PARTY_ID", $fields["input-id"])->update($data);
  	}
  	public static function drop($id)
  	{
    		$checkStat = DB::table("detail_mutasi")
                     ->select("ID")->firstWhere("PARTY_ID", $id);
    		if ($checkStat){
    			throw new \Exception("Party tidak dapat dihapus karena sudah dipakai di transaksi");
    		}
    		else {
    			$data = Party::find($id);
    			if ($data){
    				$data->delete();
    			}
    		}
  	}
}
