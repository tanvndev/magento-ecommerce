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
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code', 255)->unique();
            $table->string('type', 50);
            $table->string('description', 255)->nullable();
            $table->string('model', 50)->nullable();
            $table->json('model_ids')->nullable();
            $table->json('advertisement_banners')->nullable()->comment('banner quang cao bao gom tat ca thong tin ve quang cao do');
            $table->unsignedTinyInteger('order')->default(1);
            $table->tinyInteger('publish')->default(1)->comment('1: Active, 2: Inactive');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};
