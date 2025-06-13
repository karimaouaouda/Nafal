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
        Schema::create('transaction_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')
                ->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')
                ->cascadeOnDelete();
            $table->float('sold', 2)->default(0);
            $table->float('sell_price', 2); // price of the product ( in case of product changes )

            $table->integer('quantity', false, unsigned: true)->default(1);
            $table->float('discount', 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_products');
    }
};
