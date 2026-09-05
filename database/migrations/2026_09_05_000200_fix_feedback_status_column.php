<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 2024_08_17_044101_add_status_column_to_feedback_table guarded the new column
 * with an inverted condition:
 *
 *     if (! Schema::hasColumn('feedback', 'komentar')) {
 *         $table->integer('status')->after('komentar');
 *     }
 *
 * `komentar` is created by the original feedback migration and therefore always
 * exists, so `status` was never added. Both feedback screens read
 * `$feedback->status` and FeedbackController::konfirmFeed writes to it, so on
 * any freshly migrated database those pages fail outright.
 *
 * This adds the column for real, defaulting to 0 ("belum dikonfirmasi").
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('feedback', 'status')) {
            return;
        }

        Schema::table('feedback', function (Blueprint $table) {
            $table->unsignedTinyInteger('status')->default(0)->after('komentar');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('feedback', 'status')) {
            return;
        }

        Schema::table('feedback', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
