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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 50);
            $table->string('email')->unique();
            $table->foreignId('user_catalogue_id')->constrained('user_catalogues')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('google_id', 100)->nullable()->unique();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->string('province_id', 10)->nullable();
            $table->string('district_id', 10)->nullable();
            $table->string('ward_id', 10)->nullable();
            $table->string('address', 255)->nullable();
            $table->date('birthday')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('user_agent')->nullable();
            $table->tinyInteger('publish')->default(1)->comment('1: Active, 2: Inactive');
            $table->string('ip')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
