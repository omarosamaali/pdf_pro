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
        Schema::table('files', function (Blueprint $table) {
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])
                ->default('completed')
                ->after('size_in_bytes'); // أو أي عمود آخر تريد وضعه بعده

            $table->text('error_message')->nullable()->after('status');
            $table->timestamp('processed_at')->nullable()->after('error_message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn(['status', 'error_message', 'processed_at']);
        });
    }
};
