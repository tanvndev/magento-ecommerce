<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->collation('utf8mb4_0900_ai_ci');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('province_code', 20);
            $table->foreign('province_code')
                ->references('code')->on('provinces')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('district_code', 20);
            $table->foreign('district_code')
                ->references('code')->on('districts')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('ward_code', 20);
            $table->foreign('ward_code')
                ->references('code')->on('wards')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('fullname');
            $table->string('shipping_address');
            $table->string('phone');
            $table->tinyInteger('is_primary')->default(0)->comment('1: IsPrimary, 0: NotPrimary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
