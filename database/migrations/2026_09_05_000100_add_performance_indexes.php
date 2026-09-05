<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The hot lookups in this application (member -> product, track_step -> ceo,
 * monthly_reports -> product) all ran as full table scans because none of the
 * foreign-key columns were indexed. This adds the indexes, plus the unique
 * constraints that the login/registration code was only enforcing in PHP.
 */
return new class extends Migration
{
    /**
     * table => [ [index columns...], ... ]
     */
    private array $indexes = [
        'member' => [['id_siswa'], ['id_produk'], ['id_produk', 'position']],
        'product' => [['id_mentor'], ['id_ceo']],
        'track_step' => [['id_ceo'], ['id_produk'], ['id_step']],
        'jawaban_bmc' => [['id_produk'], ['id_pertanyaan']],
        'pertanyaan_bmc' => [['id_poin_bmc']],
        'monthly_reports' => [['product_id', 'status'], ['report_date']],
        'penilaian' => [['id_produk']],
        'feedback' => [['id_produk']],
        'logo_produk' => [['id_produk']],
        'video_produk' => [['id_produk']],
        'poster_produk' => [['id_produk']],
        'presentasi' => [['id_produk']],
        'protolink' => [['id_produk']],
        'messages' => [['id_produk']],
    ];

    /**
     * table => [column, ...] to make unique.
     */
    private array $uniques = [
        'siswa' => ['nomor_induk'],
        'mentor' => ['email'],
    ];

    public function up(): void
    {
        foreach ($this->indexes as $table => $columnSets) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            foreach ($columnSets as $columns) {
                if (! $this->hasAllColumns($table, $columns)) {
                    continue;
                }

                Schema::table($table, function (Blueprint $blueprint) use ($table, $columns) {
                    $blueprint->index($columns, $this->indexName($table, $columns));
                });
            }
        }

        foreach ($this->uniques as $table => $columns) {
            if (! Schema::hasTable($table) || ! $this->hasAllColumns($table, $columns)) {
                continue;
            }

            // A duplicate value would abort the migration; leave the table alone
            // and let an operator clean it up rather than failing the deploy.
            if ($this->hasDuplicates($table, $columns[0])) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table, $columns) {
                $blueprint->unique($columns, $this->indexName($table, $columns) . '_unique');
            });
        }
    }

    public function down(): void
    {
        foreach ($this->indexes as $table => $columnSets) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            foreach ($columnSets as $columns) {
                if (! $this->hasAllColumns($table, $columns)) {
                    continue;
                }

                Schema::table($table, function (Blueprint $blueprint) use ($table, $columns) {
                    $blueprint->dropIndex($this->indexName($table, $columns));
                });
            }
        }

        foreach ($this->uniques as $table => $columns) {
            if (! Schema::hasTable($table) || ! $this->hasAllColumns($table, $columns)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table, $columns) {
                $blueprint->dropUnique($this->indexName($table, $columns) . '_unique');
            });
        }
    }

    private function hasAllColumns(string $table, array $columns): bool
    {
        foreach ($columns as $column) {
            if (! Schema::hasColumn($table, $column)) {
                return false;
            }
        }

        return true;
    }

    private function hasDuplicates(string $table, string $column): bool
    {
        return \Illuminate\Support\Facades\DB::table($table)
            ->select($column)
            ->groupBy($column)
            ->havingRaw('COUNT(*) > 1')
            ->exists();
    }

    private function indexName(string $table, array $columns): string
    {
        return $table . '_' . implode('_', $columns) . '_idx';
    }
};
