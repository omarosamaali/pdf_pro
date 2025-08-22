<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Subscription;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'daily_operations',
        'daily_reset_date',
        'last_seen',
        'subscription_id'
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function canPerformOperation()
    {
        // إعادة تعيين العداد إذا كان يوماً جديداً
        if ($this->daily_reset_date < now()->format('Y-m-d')) {
            $this->daily_operations = 0;
            $this->daily_reset_date = now()->format('Y-m-d');
            $this->save();
        }

        // تحديد الحد بناءً على نوع المستخدم
        if ($this->subscription_id && $this->subscription) {
            // مستخدم مشترك - استخدام حد الباقة
            $limit = $this->subscription->daily_operations_limit ?? 3;
        } else {
            // مستخدم عادي بدون باقة - استخدام الحد المجاني من الإعدادات
            $limit = (int) \App\Models\Setting::where('key', 'daily_free_limit')->value('value') ?? 3;
        }

        return $this->daily_operations < $limit;
    }

    public function hasActiveSubscription()
    {
        return $this->subscription_id !== null && $this->subscription !== null;
    }

    public function getSubscriptionName()
    {
        if (!$this->hasActiveSubscription()) {
            return null;
        }

        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->subscription->name_ar : $this->subscription->name_en;
    }

    public function getDailyOperationsLimit()
    {
        if ($this->subscription_id && $this->subscription) {
            return $this->subscription->daily_operations_limit ?? 3;
        } else {
            return (int) \App\Models\Setting::where('key', 'daily_free_limit')->value('value') ?? 3;
        }
    }

    public function getRemainingOperations()
    {
        // إعادة تعيين العداد إذا كان يوماً جديداً
        if ($this->daily_reset_date < now()->format('Y-m-d')) {
            $this->daily_operations = 0;
            $this->daily_reset_date = now()->format('Y-m-d');
            $this->save();
        }

        $limit = $this->getDailyOperationsLimit();
        $remaining = $limit - $this->daily_operations;

        return max(0, $remaining);
    }

    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    // Add method to get unread notifications
    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }
}
