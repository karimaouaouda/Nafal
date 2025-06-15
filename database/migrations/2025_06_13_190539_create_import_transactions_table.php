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
        Schema::create('import_transactions', function (Blueprint $table) {
            $table->uuid('id')
                ->primary();
            $table->foreignId('supplier_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->float('buy_price')
                ->default(0);
            $table->integer('quantity', unsigned: true)
                ->default(0);
            $table->enum('payment_method', ['cash', 'credit'])
                ->default('cash');
            $table->enum('delivery_type', ['standard', 'express', 'pickup'])
                ->default('standard');
            $table->float('delivery_price')
                ->default(0);
            $table->integer('sold', unsigned: true)
                ->default(0);
            $table->float('discount')
                ->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_transactions');
    }
};
