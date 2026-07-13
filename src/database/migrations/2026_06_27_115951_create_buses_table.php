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
        Schema::create('buses', function (Blueprint $table) {
            $table->id();

            $table->string('nama_bus');
            $table->enum('kategori_bus', [
                'Big Bus',
                'Medium Bus',
                'Travel',
            ]);

            $table->enum('tipe_bus', [
                'Super High Deck Single Glass',
                'Super High Deck Double Glass',
                'Medium High Deck Single Glass',
                'Travel',
            ]);

            $table->unsignedInteger('kapasitas');
            $table->decimal('harga_sewa', 15, 2);

            $table->string('foto')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};