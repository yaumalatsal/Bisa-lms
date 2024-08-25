<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::table('penilaian')
            ->whereRaw('NOT file_nilai REGEXP "^[0-9]+$"')
            ->update(['file_nilai' => 0]);
        
        Schema::table('penilaian', function (Blueprint $table) {
            $table->integer('file_nilai')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penilaian', function (Blueprint $table) {
            $table->string('file_nilai')->change();
        });
    }
};
