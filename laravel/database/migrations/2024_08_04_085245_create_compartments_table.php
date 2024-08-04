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
        Schema::create('compartments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('code', 50)->unique();
            $table->foreignId('shelf_id')->constrained('shelves')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('unique_identifier', 100)->unique()->comment('Ma dinh danh ví dụ: "A01-R05-S03-C12"');
            $table->string('description', 255)->nullable();
            $table->decimal('max_weight_capacity', 10, 2)->nullable()->comment('Tong suc chua (Kg)');
            $table->decimal('current_weight_used', 10, 2)->nullable()->comment('Suc chua da su dung (Kg)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compartments');
    }
};
