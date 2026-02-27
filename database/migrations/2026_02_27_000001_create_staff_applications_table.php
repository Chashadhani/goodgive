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
        Schema::create('staff_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone', 20);
            $table->string('nic', 50); // National ID Card number
            $table->text('address');
            $table->string('position')->nullable(); // desired role/position
            $table->text('experience')->nullable(); // brief experience/skills
            $table->text('motivation')->nullable(); // why they want to join
            $table->string('resume')->nullable(); // uploaded file path
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('admin_notes')->nullable();
            // Generated credentials (stored temporarily until staff logs in)
            $table->string('generated_username')->nullable();
            $table->string('generated_password_plain')->nullable(); // plain text shown once to admin
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // linked user account
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_applications');
    }
};
