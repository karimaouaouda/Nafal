<?php

/**
 * this table is representing the transactions between us ( company ) and supplier)
 * each row represent a transaction with it's own proprieties
 * better then place them into the product model and table
*/
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
        Schema::create('supplier_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade');
            // extra attributes
            $table->float('purchase_price')
                ->default(0);
            $table->float('delivery_price')
                ->default(0);
            $table->enum('payment_method', ['cash', 'credit'])
                ->default('cash');
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
