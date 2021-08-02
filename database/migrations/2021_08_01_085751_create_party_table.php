<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('party', function (Blueprint $table) {
            $table->bigIncrements("PARTY_ID");
            $table->unsignedInteger("KODE_PARTY")->index();
            $table->string("NO_IDENTITAS", 25)->default("");
            $table->string("NAMA", 50)->default();
            $table->string("ALAMAT", 200)->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('party');
    }
}
