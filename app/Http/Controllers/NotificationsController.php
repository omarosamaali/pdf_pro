<?php

namespace App\Http\Controllers;

use App\Models\BankTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Not;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = BankTransfer::where('user_id', Auth::id())->latest()->get();
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id === Auth::id()) {
            $notification->update(['read_at' => now()]);
        }
        return redirect()->back()->with('success', 'تم تحديد الإشعار كمقروء.');
    }
}
