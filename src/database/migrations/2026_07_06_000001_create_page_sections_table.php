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
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();

            $table->string('page'); // home, about, services, contact
            $table->string('section_key'); // hero, about_content, stats, values, dll

            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();

            $table->enum('media_type', ['none', 'image', 'video', 'youtube'])->default('none');
            $table->string('media_path')->nullable(); // uploaded image/video
            $table->string('media_url')->nullable(); // YouTube embed URL

            $table->json('metadata')->nullable(); // extra data: stats, process steps, FAQ, values

            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
