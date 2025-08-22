<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'user_id',
        'sender_name',
        'amount',
        'receipt_path',
        'status',
    ];

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    // احذف Events للتجربة أولاً - قد تكون تتعارض مع Controller
    // سنتعامل مع الإشعارات في Controller فقط
}
