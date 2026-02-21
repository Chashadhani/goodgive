<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add request_type to ngo_posts
        Schema::table('ngo_posts', function (Blueprint $table) {
            $table->string('request_type')->default('money')->after('urgency'); // money or goods
        });

        // Add request_type to help_requests
        Schema::table('help_requests', function (Blueprint $table) {
            $table->string('request_type')->default('money')->after('urgency'); // money or goods
        });

        // Create ngo_post_items table
        Schema::create('ngo_post_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ngo_post_id')->constrained()->onDelete('cascade');
            $table->string('item_name');
            $table->integer('quantity');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Create help_request_items table
        Schema::create('help_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('help_request_id')->constrained()->onDelete('cascade');
            $table->string('item_name');
            $table->integer('quantity');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('help_request_items');
        Schema::dropIfExists('ngo_post_items');

        Schema::table('help_requests', function (Blueprint $table) {
            $table->dropColumn('request_type');
        });

        Schema::table('ngo_posts', function (Blueprint $table) {
            $table->dropColumn('request_type');
        });
    }
};
