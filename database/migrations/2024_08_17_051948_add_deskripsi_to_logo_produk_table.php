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
        Schema::table('logo_produk', function (Blueprint $table) {
            if (!Schema::hasColumn('logo_produk','deskripsi')) {
                $table->text('deskripsi',100)->after('id_produk');
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
        Schema::table('logo_produk', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
        });
    }
};
