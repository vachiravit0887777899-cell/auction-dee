<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->decimal('starting_price', 12, 2);
            $table->decimal('current_price', 12, 2);
            $table->decimal('bid_increment', 12, 2)->default(10);
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->enum('status', ['draft', 'active', 'ended', 'cancelled'])->default('draft');
            $table->foreignId('winner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['status', 'ends_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};