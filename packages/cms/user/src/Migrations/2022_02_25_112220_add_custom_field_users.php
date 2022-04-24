<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomFieldUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->text('address')->nullable();
            $table->date('dob')->nullable();            
            $table->string('photo')->nullable();
            $table->text('jabatan')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'phone',
                'gender',
                'address',
                'dob',
                'photo',
                'jabatan',
            ]);
        });
    }
}
