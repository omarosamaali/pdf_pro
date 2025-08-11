<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // إضافة عمود daily_operations إذا لم يكن موجوداً
            if (!Schema::hasColumn('users', 'daily_operations')) {
                $table->integer('daily_operations')->default(0);
            }
            // إضافة عمود daily_reset_date إذا لم يكن موجوداً
            if (!Schema::hasColumn('users', 'daily_reset_date')) {
                $table->timestamp('daily_reset_date')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // حذف الأعمدة عند التراجع عن الـ migration
            $table->dropColumn(['daily_operations', 'daily_reset_date']);
        });
    }
};