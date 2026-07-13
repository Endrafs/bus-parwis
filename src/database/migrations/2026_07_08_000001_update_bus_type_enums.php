<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update kategori_bus ENUM: add 'Big Bus MHD', 'Travel Car'
        DB::statement("ALTER TABLE buses MODIFY COLUMN kategori_bus ENUM('Big Bus','Medium Bus','Big Bus MHD','Travel Car') DEFAULT NULL");

        // Update tipe_bus ENUM: rename & add new types
        DB::statement("ALTER TABLE buses MODIFY COLUMN tipe_bus VARCHAR(50) DEFAULT NULL");
    }

    public function down(): void
    {
        // Restore original kategori_bus ENUM
        DB::statement("ALTER TABLE buses MODIFY COLUMN kategori_bus ENUM('Big Bus','Medium Bus','Travel') DEFAULT NULL");

        // Restore original tipe_bus ENUM — note this may fail if new values exist
        DB::statement("ALTER TABLE buses MODIFY COLUMN tipe_bus ENUM('Super High Deck Single Glass','Super High Deck Double Glass','Medium High Deck Single Glass','Travel') DEFAULT NULL");
    }
};
