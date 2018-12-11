<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeminjamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->increments('id');
            $table->String('nama')->nullable();
            $table->String('instansi')->nullable();
            $table->String('alamat')->nullable();
            $table->String('perihal')->nullable();
            $table->String('tgl_mulai')->nullable();
            $table->String('tgl_kembali')->nullable();
            $table->String('jenis')->nullable();
            $table->String('plat')->nullable();
            $table->Integer('harga')->nullable();
            $table->String('status')->nullable();
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
        Schema::dropIfExists('peminjamen');
    }
}
