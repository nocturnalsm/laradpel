<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\Import;
use App\Models\Produk;
use DB;
use Excel;

class ImportController extends Controller
{
    public function index()
    {
        $array = Excel::toArray(new Import, 'import.xlsx');
        $produk_id = Produk::where("nama", "ADJUSTMENT")->first()->id;

        foreach ($array[0] as $key=>$row){
            $kodeBarang = $row[0];
            $kodeProduk = $row[1];
            $tax = 0;
            $tglKonversi = '2020-12-31';
            $jmlKonversi = $row[2];
            $satKonversi = $row[3];

            $data = DB::table(DB::raw("tbl_penarikan_header h"))
                        ->selectRaw("db.ID, db.KODEBARANG, pr.KODE AS KODEPRODUK, ks.PRODUK_ID, db.SATUAN_ID,"
                                ."c.nama_customer AS NAMACUSTOMER, db.JMLSATHARGA, ks.JMLSATKONVERSI, ks.ID AS IDKONVERSI,"
                                ."ks.SATKONVERSI, db.HARGA*h.NDPBM AS RUPIAH, db.SATUAN_ID AS SATHARGA, TAX,"
                                ."(SELECT satuan FROM satuan WHERE id =  db.SATUAN_ID) AS NAMASATHARGA,"
                                ."(SELECT satuan FROM satuan WHERE id =  ks.SATKONVERSI) AS NAMASATKONVERSI")
                        ->join(DB::raw("tbl_detail_barang db"), "h.ID","=","db.ID_HEADER")
                        ->leftJoin(DB::raw("konversistok ks"),"db.ID","=","ks.KODEBARANG")
                        ->leftJoin(DB::raw("tbl_detail_bongkar bd"), "db.ID","=","bd.KODEBARANG")
                        ->leftJoin(DB::raw("tbl_header_bongkar bh"),"bh.ID","=","bd.ID_HEADER")
                        ->leftJoin(DB::raw("produk pr"),"pr.id","=","ks.PRODUK_ID")
                        ->leftJoin(DB::raw("importir i"), "h.IMPORTIR", "=", "i.importir_id")
                        ->leftJoin(DB::raw("plbbandu_app15.tb_customer c"), "h.CUSTOMER", "=", "c.id_customer")
                        ->whereRaw("db.KODEBARANG = '{$kodeBarang}'");
            if ($data->count() != 0){
                  $row = $data->first();
                  $sql = "";
                  $satuan = $row->SATHARGA ?? 1;
                  if ($row->IDKONVERSI == ""){
                    $sql = "INSERT INTO konversistok (KODEBARANG, PRODUK_ID, JMLSATKONVERSI, SATKONVERSI, TGL_KONVERSI, TAX) "
                          ." VALUES (" .$row->ID .",{$produk_id},{$row->JMLSATHARGA},{$satuan}, '2020-12-31', 0);";
                    echo $sql ."<br>";
                  }

            }

        }
    }
}
