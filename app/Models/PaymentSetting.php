<?php

// app/Models/PaymentSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'paypal_mode',
        'paypal_live_client_id',
        'paypal_live_client_secret',
        'paypal_sandbox_client_id',
        'paypal_sandbox_client_secret',
    ];
}