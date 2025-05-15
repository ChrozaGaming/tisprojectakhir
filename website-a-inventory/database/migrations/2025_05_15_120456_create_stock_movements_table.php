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
        // First drop the table if it exists to avoid the "table already exists" error
        Schema::dropIfExists('stock_movements');
        
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->integer('previous_stock');
            $table->integer('current_stock');
            $table->enum('type', ['addition', 'reduction'])->default('addition');
            $table->text('notes')->nullable();
            $table->timestamps();
            // Foreign key will be added in a separate migration
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};