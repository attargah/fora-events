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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('content')->nullable();

            $table->string('banner');
            $table->json('images')->nullable();

            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->datetime('sales_start_date')->nullable();
            $table->datetime('sales_end_date')->nullable();

            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->integer('minimum_age')->nullable();
            $table->boolean('is_alcohol_allowed')->default(false);
            $table->boolean('is_featured')->default(false);


            $table->foreignId('event_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('event_type_id')->nullable()->constrained()->nullOnDelete();

            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
