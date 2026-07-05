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
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('harga_sewa_unit', 15, 2)->default(0)->after('total_harga');
            $table->decimal('biaya_tol', 15, 2)->default(0)->after('harga_sewa_unit');
            $table->decimal('biaya_solar', 15, 2)->default(0)->after('biaya_tol');
            $table->decimal('tips_crew', 15, 2)->default(0)->after('biaya_solar');
            $table->decimal('biaya_parkir', 15, 2)->default(0)->after('tips_crew');
            $table->decimal('biaya_tujuan', 15, 2)->default(0)->after('biaya_parkir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'harga_sewa_unit',
                'biaya_tol',
                'biaya_solar',
                'tips_crew',
                'biaya_parkir',
                'biaya_tujuan',
            ]);
        });
    }
};
