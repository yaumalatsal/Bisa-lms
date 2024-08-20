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
        Schema::table('mapels_quiz', function (Blueprint $table) {
            // Menambahkan kolom durasi dengan tipe data integer
            $table->integer('durasi')->after('name')->nullable()->comment('Durasi pengerjaan dalam menit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mapels_quiz', function (Blueprint $table) {
            // Menghapus kolom durasi
            $table->dropColumn('durasi');
        });
    }
};
