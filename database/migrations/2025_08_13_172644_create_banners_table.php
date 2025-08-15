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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // banner_1, banner_2, banner_3
            $table->string('file_path')->nullable(); // مسار الملف
            $table->string('file_type')->nullable(); // image, video, gif
            $table->string('url')->nullable(); // الرابط عند الضغط
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(1); // ترتيب البانر
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
