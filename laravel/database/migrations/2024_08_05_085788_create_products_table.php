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
            $table->tinyInteger('publish')->default(1);
            $table->boolean('enable_manage_stock')->default(0);
            $table->varchar('stock_status')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_keyword', 255)->nullable();
            $table->text('meta_description')->nullable();
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
