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
            $table->string('product_type', 100)->comment('Luu kieu cua san pham vi du: san pham don gian; san pham bien the');
            $table->foreignId('product_catalogue_id')->constrained('product_catalogues')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('excerpt')->nullable()->comment('Mo ta tom tat san pham');
            $table->longText('description')->nullable()->comment('Mo ta chi tiet san pham');
            $table->json('upsell_ids')->nullable()->comment(' hien thi lien ket den cac san pham mong muon');
            $table->tinyInteger('publish')->default(1);
            $table->boolean('is_taxable')->default(false)->comment('Cot tinh trang thue');
            $table->tinyInteger('tax_status')->nullable()->comment('Trang thai thue san pham');
            $table->unsignedBigInteger('input_tax_id')->nullable()->comment('Thue dau vao');
            $table->unsignedBigInteger('ouput_tax_id')->nullable()->comment('Thue dau ra');
            $table->foreign('input_tax_id')->references('id')->on('taxes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('output_tax_id')->references('id')->on('taxes')->cascadeOnDelete()->cascadeOnUpdate();

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
