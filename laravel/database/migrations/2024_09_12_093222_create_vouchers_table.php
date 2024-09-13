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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->string('discount_type', 20);
            $table->decimal('discount_value', 15, 2);
            $table->integer('quantity');
            $table->decimal('min_order_value', 15, 2);
            $table->integer('min_quantity');
            $table->date('start_at');
            $table->date('end_at');
            $table->boolean('publish');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
