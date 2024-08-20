<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKeteranganToPenilaianTable extends Migration
{
    /**
     * Menjalankan migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penilaian', function (Blueprint $table) {
            $table->text('keterangan')->nullable()->after('file_nilai');
        });
    }

    /**
     * Membalikkan perubahan yang dilakukan oleh migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penilaian', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
}
