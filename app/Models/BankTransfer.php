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
}
