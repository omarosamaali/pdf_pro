<?php

// database/migrations/xxxx_xx_xx_create_page_contents_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->longText('privacy_policy_ar')->nullable();
            $table->longText('privacy_policy_en')->nullable();
            $table->longText('terms_ar')->nullable();
            $table->longText('terms_en')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};