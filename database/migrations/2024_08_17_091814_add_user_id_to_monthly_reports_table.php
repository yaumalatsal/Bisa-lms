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
        Schema::table('monthly_reports', function (Blueprint $table) {
            // Change the column type to match the 'id' column in 'siswa'
            $table->unsignedInteger('user_id')->after('id');
    
            // Add foreign key constraint
            $table->foreign('user_id')->references('id')->on('siswa')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('monthly_reports', function (Blueprint $table) {
            // Drop the foreign key constraint and column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
    

};
