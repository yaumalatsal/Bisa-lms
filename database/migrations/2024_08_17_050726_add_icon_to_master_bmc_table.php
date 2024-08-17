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
        Schema::table('master_bmc', function (Blueprint $table) {
            if (!Schema::hasColumn('master_bmc','icon')) {
                $table->string('icon',50)->after('route');
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
        Schema::table('master_bmc', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
