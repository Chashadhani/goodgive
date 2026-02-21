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
        Schema::create('donation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->constrained()->onDelete('cascade');
            $table->string('item_name'); // e.g., Shirts, Trousers, Rice bags
            $table->integer('quantity'); // e.g., 2, 4, 10
            $table->text('notes')->nullable(); // optional notes per item
            $table->timestamps();
        });

        // Remove old single goods fields from donations table
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['goods_description', 'goods_quantity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->string('goods_description')->nullable();
            $table->integer('goods_quantity')->nullable();
        });

        Schema::dropIfExists('donation_items');
    }
};
