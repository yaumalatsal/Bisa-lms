<?php

// database/migrations/xxxx_xx_xx_create_messages_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_siswa')->nullable();
            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('cascade')->nullable();
            $table->unsignedInteger('id_mentor')->nullable();
            $table->foreign('id_mentor')->references('id')->on('mentor')->onDelete('cascade')->nullable();
            $table->unsignedInteger('id_product');
            $table->foreign('id_product')->references('id')->on('product')->onDelete('cascade');


            $table->text('message');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}

