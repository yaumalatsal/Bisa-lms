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
        Schema::table('master_step', function (Blueprint $table) {
            if (!Schema::hasColumn('master_step','deskripsi')) {
                $table->string('deskripsi',100)->after('nama_step');
            } 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_step', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
        });
    }
};
