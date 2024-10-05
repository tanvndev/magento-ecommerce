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
            // $table->foreignId('category_id')
            //     ->constrained('post_categories')
            //     ->cascadeOnDelete()
            //     ->cascadeOnUpdate();
            $table->string('name');
            $table->string('image');
            $table->text('description');
            $table->text('content');
            $table->string('canonical')->unique();
            $table->string('icon');
            $table->integer('order');
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->string('meta_description');
            $table->tinyInteger('publish')->default(1)->comment('1:Active, 2: Inactive');
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
