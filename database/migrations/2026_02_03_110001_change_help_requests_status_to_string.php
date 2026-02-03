<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change status column to string to allow more flexibility
        Schema::table('help_requests', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to enum if needed
        DB::statement("ALTER TABLE help_requests MODIFY COLUMN status ENUM('pending', 'approved', 'in_progress', 'fulfilled', 'rejected', 'completed') DEFAULT 'pending'");
    }
};
