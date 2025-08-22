<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'price',
        'daily_operations_limit',
        'duration_in_days',
        'features_ar',
        'features_en',
        'slug',
        'is_active',
        'sort_order'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'daily_operations_limit' => 'integer',
        'duration_in_days' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get features_ar attribute and decode it properly
     */
    public function getFeaturesArAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        // إذا كان JSON string، فك التشفير
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return $decoded ?: [];
        }

        // إذا كان array بالفعل
        if (is_array($value)) {
            return $value;
        }

        return [];
    }

    /**
     * Get features_en attribute and decode it properly
     */
    public function getFeaturesEnAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        // إذا كان JSON string، فك التشفير
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return $decoded ?: [];
        }

        // إذا كان array بالفعل
        if (is_array($value)) {
            return $value;
        }

        return [];
    }

    /**
     * Get the features based on the current locale
     */
    public function getFeaturesAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->features_ar : $this->features_en;
    }

    /**
     * Get localized name
     */
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->name_ar : $this->name_en;
    }

    /**
     * Scope للاشتراكات النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope للترتيب
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('price', 'asc');
    }
}
