<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('help_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('category'); // education, healthcare, shelter, food, clothing, emergency, livelihood, other
            $table->text('description');
            $table->string('location')->nullable();
            $table->decimal('amount_needed', 10, 2)->nullable();
            $table->string('urgency')->default('medium'); // low, medium, high, critical
            $table->text('documents')->nullable(); // JSON array of file paths
            $table->enum('status', ['pending', 'approved', 'in_progress', 'fulfilled', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('fulfilled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_requests');
    }
};
