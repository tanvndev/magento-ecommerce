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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            // $table->foreignId('post_catalogue_id')
            //     ->constrained('post_catalogues')
            //     ->cascadeOnDelete()
            //     ->cascadeOnUpdate();
            $table->string('name');
            $table->string('image');
            $table->text('description');
            $table->longText('content');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('canonical')->unique();
            $table->tinyInteger('publish')->default(1)->comment('1:Active, 2: Inactive');
            $table->tinyInteger('is_featured')->default(1)->comment('1: true, 2: false');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
