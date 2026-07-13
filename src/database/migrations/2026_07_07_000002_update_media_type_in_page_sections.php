<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE page_sections MODIFY COLUMN media_type VARCHAR(50) DEFAULT 'none'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE page_sections MODIFY COLUMN media_type ENUM('none','image','video','youtube') DEFAULT 'none'");
    }
};
