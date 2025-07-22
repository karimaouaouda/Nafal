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
        $sqlPath = database_path('world.sql'); // Adjust the path to your SQL file
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents($sqlPath));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
