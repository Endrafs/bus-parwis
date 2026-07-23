<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email', 100)->nullable();
            $table->string('no_wa', 20);
            $table->text('pesan');
            $table->text('balasan')->nullable();
            $table->timestamp('dibalas_pada')->nullable();
            $table->unsignedBigInteger('dibalas_oleh')->nullable();
            $table->foreign('dibalas_oleh')->references('id')->on('users')->nullOnDelete();
            $table->enum('status', ['baru', 'dibalas'])->default('baru');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};