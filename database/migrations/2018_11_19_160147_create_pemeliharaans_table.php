<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemeliharaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemeliharaans', function (Blueprint $table) {
            $table->increments('id');
            $table->String('plat')->nullable();
            $table->String('jenis')->nullable();
            $table->Integer('odometer')->nullable();
            $table->String('keterangan', 400)->nullable();
            $table->String('jenis_bb')->nullable();
            $table->Integer('harga_bb')->nullable();
            $table->Integer('jumlah_bb')->nullable();
            $table->String('tipe_service')->nullable();
            $table->Integer('harga_service')->nullable();
            $table->String('tgl_mulai')->nullable();
            $table->String('tgl_selesai')->nullable();
            $table->String('suku_cadang')->nullable();
            $table->Integer('harga_suku')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemeliharaans');
    }
}
