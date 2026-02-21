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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // donor
            $table->foreignId('ngo_post_id')->nullable()->constrained()->onDelete('set null'); // optional link to NGO post
            $table->enum('donation_type', ['money', 'goods']);
            $table->decimal('amount', 10, 2)->nullable(); // for money donations
            $table->string('goods_description')->nullable(); // for goods donations
            $table->integer('goods_quantity')->nullable(); // for goods donations
            $table->string('status')->default('pending'); // pending, confirmed, rejected
            $table->text('donor_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
