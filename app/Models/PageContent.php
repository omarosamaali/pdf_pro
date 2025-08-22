<?php

// app/Models/PageContent.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'privacy_policy_ar',
        'privacy_policy_en',
        'terms_ar',
        'terms_en',
    ];
}