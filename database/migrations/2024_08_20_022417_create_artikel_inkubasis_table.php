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
        Schema::create('artikel_inkubasis', function (Blueprint $table) {
           
                $table->id();
                $table->string('judul');
                $table->enum('kategori', ['bmc', 'ide bisnis', 'cara memulai bisnis']);
                $table->enum('bentuk_kategori', ['artikel', 'video']);
                $table->string('link')->nullable();
                $table->string('thumbnail')->nullable();
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
        Schema::dropIfExists('artikel_inkubasis');
    }
};
