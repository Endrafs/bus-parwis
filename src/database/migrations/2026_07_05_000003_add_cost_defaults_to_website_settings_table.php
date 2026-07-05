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
        Schema::table('website_settings', function (Blueprint $table) {
            $table->decimal('biaya_tol_default', 15, 2)->default(0)->after('rekening_bank');
            $table->decimal('biaya_solar_default', 15, 2)->default(0)->after('biaya_tol_default');
            $table->decimal('tips_crew_default', 15, 2)->default(0)->after('biaya_solar_default');
            $table->decimal('biaya_parkir_default', 15, 2)->default(0)->after('tips_crew_default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn([
                'biaya_tol_default',
                'biaya_solar_default',
                'tips_crew_default',
                'biaya_parkir_default',
            ]);
        });
    }
};
