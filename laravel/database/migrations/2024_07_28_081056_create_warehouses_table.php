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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 100)->unique();
            $table->string('phone', 15)->nullable();
            $table->string('address', 50)->nullable();
            $table->integer('row')->default(0)->comment('So hang');
            $table->integer('shelve')->default(0)->comment('So ke hang');
            $table->string('supervisor_name', 50)->nullable()->comment('Ten nguoi quan ly');
            $table->string('description', 255)->nullable();
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
        Schema::dropIfExists('warehouses');
    }
};
