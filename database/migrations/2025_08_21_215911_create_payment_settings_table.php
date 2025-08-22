<?php

// database/migrations/xxxx_xx_xx_create_payment_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string('paypal_mode')->nullable();
            $table->string('paypal_live_client_id')->nullable();
            $table->string('paypal_live_client_secret')->nullable();
            // يمكنك إضافة حقول لإعدادات طرق دفع أخرى هنا
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};