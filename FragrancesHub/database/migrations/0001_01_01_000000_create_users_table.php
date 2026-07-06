<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    // Gunakan ::create untuk membuat tabel baru
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        
        // Kolom tambahan kamu
        $table->enum('role', ['admin', 'user'])->default('user');
        $table->string('phone')->nullable();
        $table->text('address')->nullable();
        
        $table->rememberToken();
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'address']);
        });
    }
};
