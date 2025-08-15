<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_path',
        'file_type',
        'url',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Get the full URL for the banner file
     */
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/banners/' . $this->file_path);
        }
        return null;
    }

    /**
     * Check if banner is an image
     */
    public function isImage()
    {
        return in_array($this->file_type, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }

    /**
     * Check if banner is a video
     */
    public function isVideo()
    {
        return in_array($this->file_type, ['mp4', 'avi', 'mov', 'webm']);
    }

    /**
     * Check if banner is animated (GIF)
     */
    public function isAnimated()
    {
        return $this->file_type === 'gif';
    }

    /**
     * Scope to get active banners
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get banners ordered
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get banners for homepage
     */
    public static function getHomepageBanners()
    {
        return self::active()->ordered()->get();
    }
}
