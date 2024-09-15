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
            $table->string('description')->nullable();
            $table->string('discount_type', 20);
            $table->decimal('discount_value', 15, 2);
            $table->unsignedInteger('quantity');
            $table->decimal('min_order_value', 15, 2)->nullable();
            $table->unsignedInteger('min_quantity')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->tinyInteger('publish')->default(1)->comment('1:Active, 2: Inactive');
            $table->softDeletes();
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
