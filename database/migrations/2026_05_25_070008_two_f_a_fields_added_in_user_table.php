<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('two_fa_is_active')->default(false);
            $table->string('two_fa_otp', 6)->nullable();
            $table->timestamp('two_fa_expires_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['two_fa_is_active', 'two_fa_otp', 'two_fa_expires_at']);
        });
    }
};
