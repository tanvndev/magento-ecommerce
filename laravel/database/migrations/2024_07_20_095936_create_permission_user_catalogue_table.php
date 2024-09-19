<?php

declare(strict_types=1);

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
        Schema::create('permission_user_catalogue', function (Blueprint $table) {
            $table->foreignId('user_catalogue_id')->constrained('user_catalogues')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('permission_id')->constrained('permissions')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_catalogue_permission');
    }
};
