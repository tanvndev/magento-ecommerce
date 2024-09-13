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
            $table->string('name');
            $table->string('code', 50)->unique();
            $table->string('image')->nullable();
            $table->string('description');
            $table->string('discount_type', 20);
            $table->decimal('discount_value', 15, 2);
            $table->integer('quantity');
            $table->decimal('min_order_value', 15, 2)->nullable();
            $table->integer('min_quantity')->nullable();
            $table->date('start_at');
            $table->date('end_at');
            $table->tinyInteger('publish')->default(1)->comment('1:Active, 2: Inactive');
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
