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
        Schema::table('mentor', function (Blueprint $table) {
            if (!Schema::hasColumn('mentor', 'password')) {
                $table->string('password', 255)->nullable(false)->after('email');
            }
            if (!Schema::hasColumn('mentor', 'instansi')) {
                $table->string('instansi', 100)->nullable(false)->after('umur');
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
        Schema::table('mentor', function (Blueprint $table) {
            $table->dropColumn('password');
            $table->dropColumn('mentor');
        });
    }
};
