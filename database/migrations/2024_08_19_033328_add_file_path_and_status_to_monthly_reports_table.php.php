<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilePathAndStatusToMonthlyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_reports', function (Blueprint $table) {
            // Tambahkan kolom file_path untuk menyimpan jalur file PDF
            $table->string('file_path')->nullable();

            // Tambahkan kolom status untuk menyimpan status persetujuan
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly_reports', function (Blueprint $table) {
            // Hapus kolom file_path dan status saat rollback migrasi
            $table->dropColumn('file_path');
            $table->dropColumn('status');
        });
    }
}

