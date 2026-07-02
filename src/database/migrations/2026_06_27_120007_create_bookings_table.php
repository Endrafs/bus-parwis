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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('bus_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('kode_booking')->unique();

            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');

            $table->string('tujuan');

            $table->unsignedInteger('jumlah_hari');

            $table->decimal('total_harga', 15, 2);

            $table->enum('status', [
                'Pending',
                'Menunggu Verifikasi',
                'Dikonfirmasi',
                'Berjalan',
                'Selesai',
                'Dibatalkan',
            ])->default('Pending');

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};