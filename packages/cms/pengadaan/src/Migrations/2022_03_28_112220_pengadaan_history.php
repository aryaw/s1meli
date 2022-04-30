<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PengadaanHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengadaan_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pengadaan_id')->unsigned();
            $table->integer('jenis_pengajuan')->default(0);
            $table->integer('approve_wakasek')->default(0);
            $table->integer('approve_kepsek')->default(0);
            $table->date('tgl_approve_wakasek')->nullable();
            $table->date('tgl_approve_kepsek')->nullable();
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
        Schema::drop('pengadaan_history');
    }
}
