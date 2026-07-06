<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('products')) {
            return;
        }

        if (!Schema::hasColumn('products', 'discount_percent')) {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedTinyInteger('discount_percent')->default(0)->after('price');
                // 0 = tidak ada promo, 1-99 = persen diskon
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('products') || !Schema::hasColumn('products', 'discount_percent')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('discount_percent');
        });
    }
};
