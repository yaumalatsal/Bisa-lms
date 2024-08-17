<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyReportsTable extends Migration
{
    public function up()
    {
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->constrained('product')->onDelete('cascade');
            $table->integer('total_sales');
            $table->date('report_date');
            $table->decimal('revenue', 15, 2);
            $table->decimal('spending', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('monthly_reports');
    }
}

