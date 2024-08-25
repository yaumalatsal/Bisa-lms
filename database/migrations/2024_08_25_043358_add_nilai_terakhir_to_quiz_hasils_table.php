<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNilaiTerakhirToQuizHasilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_hasils', function (Blueprint $table) {
            $table->integer('nilai_terakhir')->nullable()->after('nilai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_hasils', function (Blueprint $table) {
            $table->dropColumn('nilai_terakhir');
        });
    }
}
