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
            $table->string('nama_website')->nullable()->after('id');
            $table->string('logo')->nullable()->after('nama_website');
            $table->text('deskripsi')->nullable()->after('logo');
            $table->string('nomor_whatsapp')->nullable()->after('deskripsi');
            $table->string('email')->nullable()->after('nomor_whatsapp');
            $table->text('alamat')->nullable()->after('email');
            $table->string('rekening_bank')->nullable()->after('alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn([
                'nama_website', 'logo', 'deskripsi',
                'nomor_whatsapp', 'email', 'alamat', 'rekening_bank',
            ]);
        });
    }
};
