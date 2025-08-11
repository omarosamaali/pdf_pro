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
        'slug',
        'price',
        'daily_operations_limit',
        'duration_in_days',
        'features_ar',
        'features_en',
    ];

    // app/Models/Subscription.php

    protected $casts = [
        'features_ar' => 'array',
        'features_en' => 'array',
        'price' => 'decimal:2'

    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
