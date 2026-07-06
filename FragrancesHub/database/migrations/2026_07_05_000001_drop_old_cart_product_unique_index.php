<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!$this->indexExists('carts', 'carts_user_id_index')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->index('user_id', 'carts_user_id_index');
            });
        }

        if ($this->indexExists('carts', 'carts_user_id_product_id_unique')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->dropUnique('carts_user_id_product_id_unique');
            });
        }

        if (!$this->indexExists('carts', 'carts_user_product_variant_index')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->index(['user_id', 'product_id', 'product_variant_id'], 'carts_user_product_variant_index');
            });
        }
    }

    public function down(): void
    {
        if ($this->indexExists('carts', 'carts_user_product_variant_index')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->dropIndex('carts_user_product_variant_index');
            });
        }

        if ($this->indexExists('carts', 'carts_user_id_index')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->dropIndex('carts_user_id_index');
            });
        }

        if (!$this->indexExists('carts', 'carts_user_id_product_id_unique')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->unique(['user_id', 'product_id']);
            });
        }
    }

    private function indexExists(string $table, string $index): bool
    {
        $database = DB::getDatabaseName();

        return DB::table('information_schema.statistics')
            ->where('table_schema', $database)
            ->where('table_name', $table)
            ->where('index_name', $index)
            ->exists();
    }
};
