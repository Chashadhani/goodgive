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
        Schema::create('allocations', function (Blueprint $table) {
            $table->id();

            // Source: which donation the stock comes from
            $table->foreignId('donation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('donation_item_id')->nullable()->constrained()->cascadeOnDelete(); // for goods

            // Target: polymorphic (NgoPost or HelpRequest)
            $table->string('allocatable_type'); // App\Models\NgoPost or App\Models\HelpRequest
            $table->unsignedBigInteger('allocatable_id');

            // Who allocated
            $table->foreignId('allocated_by')->constrained('users');

            // What's being allocated
            $table->string('type'); // money or goods
            $table->decimal('amount', 12, 2)->nullable(); // for money allocations
            $table->integer('quantity')->nullable(); // for goods allocations
            $table->string('item_name')->nullable(); // denormalized from donation_item for easy display

            // 3-stage lifecycle
            $table->string('status')->default('processing'); // processing, delivery, distributed

            // Proof of distribution
            $table->string('proof_photo')->nullable();
            $table->text('proof_notes')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['allocatable_type', 'allocatable_id']);
            $table->index('donation_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allocations');
    }
};
