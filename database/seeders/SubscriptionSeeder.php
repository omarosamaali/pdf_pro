<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name_ar' => 'الباقة الفضية',
                'name_en' => 'Silver Package',
                'features_ar' => json_encode([
                    '3 عمليات يومية',
                    'دعم عبر البريد الإلكتروني',
                    'مساحة تخزين 1 جيجا بايت'
                ]),
                'features_en' => json_encode([
                    '3 daily operations',
                    'Email support',
                    '1GB storage space'
                ]),
                'price' => 29.99,
                'daily_operations_limit' => 3, // تم إضافة هذا الحقل
                'duration_in_days' => 30,
                'slug' => Str::slug('Silver Package'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'الباقة الذهبية',
                'name_en' => 'Gold Package',
                'features_ar' => json_encode([
                    '5 عمليات يومية',
                    'دعم فني على مدار الساعة',
                    'مساحة تخزين 5 جيجا بايت',
                    'تحويلات غير محدودة'
                ]),
                'features_en' => json_encode([
                    '5 daily operations',
                    '24/7 technical support',
                    '5GB storage space',
                    'Unlimited conversions'
                ]),
                'price' => 59.99,
                'daily_operations_limit' => 5, // تم إضافة هذا الحقل
                'duration_in_days' => 30,
                'slug' => Str::slug('Gold Package'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'باقة المحترفين',
                'name_en' => 'Professional Package',
                'features_ar' => json_encode([
                    'عدد غير محدود من العمليات',
                    'دعم فني مباشر',
                    'مساحة تخزين 10 جيجا بايت',
                    'تحويلات سريعة',
                    'ميزات متقدمة'
                ]),
                'features_en' => json_encode([
                    'Unlimited operations',
                    'Live technical support',
                    '10GB storage space',
                    'Fast conversions',
                    'Advanced features'
                ]),
                'price' => 99.99,
                'daily_operations_limit' => null, // تم إضافة هذا الحقل لقيمة غير محدودة
                'duration_in_days' => 30,
                'slug' => Str::slug('Professional Package'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('subscriptions')->insert($packages);
    }
}
