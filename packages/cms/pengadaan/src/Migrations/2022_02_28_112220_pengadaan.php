<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pengadaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengadaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->text('actor')->nullable();
            $table->text('nomor_laporan')->nullable();
            $table->integer('jenis_pengajuan')->default(0);
            $table->integer('status')->default(0);
            $table->integer('approve_wakasek')->default(0);
            $table->integer('approve_kepsek')->default(0);
            $table->date('pengajuan')->nullable();
            $table->date('tgl_penerimaan')->nullable();
            $table->text('nota')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        Schema::create('item_pengadaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pengadaan_id')->unsigned();
            $table->text('nama_barang');
            $table->text('spesifikasi_barang');
            $table->text('uraian_barang');
            $table->text('keterangan');
            $table->integer('qty')->nullable()->default(0);
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
        Schema::drop('pengadaan');
        Schema::drop('item_pengadaan');
    }
}
