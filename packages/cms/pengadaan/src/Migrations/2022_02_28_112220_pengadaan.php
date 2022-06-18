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
            $table->integer('jenis_pengajuan')->nullable()->default(0);
            $table->integer('status')->default(0);
            $table->integer('approve_wakasek')->nullable()->default(0);
            $table->integer('approve_kepsek')->nullable()->default(0);
            $table->date('pengajuan')->nullable();
            $table->date('tgl_penerimaan')->nullable();
            $table->text('nota')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        Schema::create('item_pengadaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('barang_id')->unsigned()->nullable();
            $table->bigInteger('pengadaan_id')->unsigned()->nullable();
            $table->text('nama_barang')->nullable();
            $table->text('spesifikasi_barang')->nullable();
            $table->text('uraian_barang')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('qty')->nullable()->default(0);
            $table->text('satuan')->nullable();
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
