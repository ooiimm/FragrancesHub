<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Tambah kolom untuk support berbagai payment methods
            $table->string('payment_method')->default('bank_transfer')->after('order_id');
            // bank_transfer, ovo, gopay, dana, cod
            
            // Untuk e-wallet
            $table->string('phone_number')->nullable()->after('payment_method');
            
            // Ubah account_number/account_name menjadi nullable karena tidak perlu untuk e-wallet & COD
            $table->dropColumn(['bank_name', 'account_number', 'account_name']);
            
            // Tambah kolom umum untuk semua tipe
            $table->string('recipient_name')->nullable();
            $table->string('recipient_account')->nullable(); // bisa account number atau phone
            $table->text('payment_notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'phone_number', 'recipient_name', 'recipient_account', 'payment_notes']);
            
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_name');
        });
    }
};
