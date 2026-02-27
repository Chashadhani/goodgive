<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('allocations', function (Blueprint $table) {
            $table->string('otp_code', 6)->nullable()->after('status');
            $table->boolean('otp_verified')->default(false)->after('otp_code');
            $table->timestamp('otp_generated_at')->nullable()->after('otp_verified');
            $table->timestamp('otp_verified_at')->nullable()->after('otp_generated_at');
        });
    }

    public function down(): void
    {
        Schema::table('allocations', function (Blueprint $table) {
            $table->dropColumn(['otp_code', 'otp_verified', 'otp_generated_at', 'otp_verified_at']);
        });
    }
};
