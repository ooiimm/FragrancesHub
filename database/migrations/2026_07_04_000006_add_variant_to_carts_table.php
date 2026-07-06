<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Add variant_id for variant selection
            $table->foreignId('product_variant_id')->nullable()->constrained('product_variants')->onDelete('cascade')->after('product_id');
            $table->string('variant_size')->nullable()->after('product_variant_id'); // cache size for display
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeignKeyConstraints();
            $table->dropColumn(['product_variant_id', 'variant_size']);
        });
    }
};
