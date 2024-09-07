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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('product_type', 100)->comment('Luu kieu cua san pham vi du: san pham don gian; san pham bien the');
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('excerpt')->nullable()->comment('Mo ta tom tat san pham');
            $table->longText('description')->nullable()->comment('Mo ta chi tiet san pham');
            $table->json('upsell_ids')->nullable()->comment(' hien thi lien ket den cac san pham mong muon');
            $table->json('shipping_ids')->nullable()->comment('Hinh thuc van chuyen');
            $table->tinyInteger('publish')->default(1);
            $table->string('canonical', 255)->unique();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
