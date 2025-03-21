<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->index()->constrained();
            $table->string('description', 1000);
            $table->integer('price');
            $table->integer('stock');
            $table->foreignId('user_id')->index()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('item_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->index()->constrained();
            $table->string('path');
            $table->integer('img_position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_images');
        Schema::dropIfExists('items');
        Schema::dropIfExists('categories');
    }
};
