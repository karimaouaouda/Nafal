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
        Schema::dropIfExists('transactions');
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')
                ->primary();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->mediumText('attention')->nullable();
            $table->string('cus_ref')->nullable();
            $table->enum('status', \App\Enums\TransactionStatus::values());
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
