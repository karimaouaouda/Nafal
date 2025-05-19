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
        Schema::create('quotation_products', function (Blueprint $table) {
           $table->id();
           $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnDelete();
           $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
           $table->float('sold', 2)->default(0);
           $table->float('discount', 2)->default(0);
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
