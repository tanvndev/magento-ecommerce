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
        Schema::create('product_catalogues', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('image', 255)->nullable();
            $table->string('canonical', 255)->unique();
            $table->string('description', 255)->nullable();
            $table->integer('order')->default(0);
            $table->tinyInteger('publish')->default(1);
            $table->tinyInteger('is_featured')->default(1)->comment('1: true, 2: false');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('product_catalogues')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('product_catalogues');
    }
};
