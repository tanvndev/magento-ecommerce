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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 255)->unique();
            $table->string('name', 255)->comment('Ten san pham se luu chung');
            $table->string('canonical', 255)->unique();
            $table->string('sku', 100)->nullable();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('price', 15, 2)->comment('Gia ban');
            $table->decimal('sale_price', 15, 2)->nullable()->comment('Gia khuyen mai');
            $table->decimal('import_price', 15, 2)->comment('Gia nhap');
            $table->string('image', 255)->nullable();
            $table->json('album')->nullable();
            $table->float('weight')->nullable();
            $table->float('length')->nullable();
            $table->float('width')->nullable();
            $table->float('height')->nullable();
            $table->boolean('is_discount_time')->default(false);
            $table->dateTime('sale_price_start_at')->nullable();
            $table->dateTime('sale_price_end_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
