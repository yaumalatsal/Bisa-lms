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
    Schema::create('monitorings', function (Blueprint $table) {
        $table->id();
        $table->string('product')->nullable();
        $table->integer('profit')->nullable();
        $table->string ('income')->nullable();
        $table->string ('expenses')->nullable();
        $table->integer('quantity')->nullable();
        $table->string('order')->nullable();
        $table->date('date');
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
        Schema::dropIfExists('monitorings');
    }
};
