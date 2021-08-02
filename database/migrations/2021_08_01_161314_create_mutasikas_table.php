<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutasikasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('mutasikas', function (Blueprint $table) {
          $table->bigIncrements("ID");
          $table->date("TANGGAL")->nullable();
          $table->unsignedInteger("IMPORTIR_ID")->index();
          $table->unsignedInteger("REKENING_ID")->index();
      });
      Schema::create('mutasikas_detail', function (Blueprint $table) {
          $table->bigIncrements("ID");
          $table->unsignedInteger("ID_HEADER")->index();
          $table->unsignedInteger("KODEACC_ID")->index();
          $table->unsignedInteger("PARTY_ID")->index();
          $table->string("NO_DOK",50)->default("");
          $table->date("TGL_DOK")->nullable();
          $table->decimal("NOMINAL", 13, 2)->default(0);
          $table->char("DK", 1);
          $table->string("REMARKS", 200)->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mutasikas_detail');
        Schema::dropIfExists('mutasikas');
    }
}
