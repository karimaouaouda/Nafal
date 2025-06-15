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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained('categories');
            $table->foreignId('unity_id')
                ->constrained('unities')
                ->noActionOnDelete();
            $table->string('sku');
            $table->string('title');
            $table->string('description');
            $table->string('image')
                ->nullable();
            $table->json('sheets')
                ->nullable();
            $table->mediumText('remark')
                ->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
