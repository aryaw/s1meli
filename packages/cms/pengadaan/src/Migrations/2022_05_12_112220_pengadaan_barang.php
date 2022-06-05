<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PengadaanBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('kode_barang')->nullable();
            $table->text('nama')->nullable();
            $table->text('kategory')->nullable();
            $table->text('merk')->nullable();
            $table->text('bahan')->nullable();
            $table->text('spesifikasi')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('barang');
    }
}
