<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class PremiumController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::all();
        return view('premium', compact('subscriptions'));
    }
}
