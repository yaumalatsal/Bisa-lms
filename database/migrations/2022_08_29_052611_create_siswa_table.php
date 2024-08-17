<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
   
    {
        
        Schema::create('siswa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor_induk',20);
            $table->string('password',225);
            $table->date('tanggal_lahir');
            $table->string('nama');
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
        Schema::drop('siswa');
    }
};
