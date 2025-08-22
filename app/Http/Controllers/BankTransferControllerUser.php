<?php

namespace App\Http\Controllers;

use App\Models\BankTransfer;
use App\Models\Notification;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BankTransferController extends Controller
{
    public function store(Request $request)
    {
        // إضافة لوج لمتابعة تنفيذ الكود
        Log::info('Starting bank transfer process', ['user_id' => Auth::id()]);

        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'sender_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            // رفع ملف الإيصال
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
            Log::info('Receipt uploaded', ['path' => $receiptPath]);

            // إنشاء التحويل
            $transfer = BankTransfer::create([
                'subscription_id' => $request->subscription_id,
                'user_id' => Auth::id(),
                'sender_name' => $request->sender_name,
                'amount' => $request->amount,
                'receipt_path' => $receiptPath,
                'status' => 'pending',
            ]);

            Log::info('Bank transfer created', ['transfer_id' => $transfer->id]);

            // إنشاء إشعار للمستخدم - مع try/catch منفصل
            try {
                $notification = Notification::create([
                    'user_id' => Auth::id(),
                    'type' => 'bank_transfer_submitted',
                    'message' => "تم إرسال طلب التحويل البنكي بمبلغ {$request->amount} جنيه بنجاح. سيتم مراجعته خلال 24 ساعة.",
                ]);
                Log::info('User notification created', ['notification_id' => $notification->id]);
            } catch (\Exception $e) {
                Log::error('Failed to create user notification', ['error' => $e->getMessage()]);
            }

            // إشعار للإدارة
            try {
                $admins = \App\Models\User::where('role', 'admin')->get();
                Log::info('Found admins', ['count' => $admins->count()]);

                foreach ($admins as $admin) {
                    $adminNotification = Notification::create([
                        'user_id' => $admin->id,
                        'type' => 'new_bank_transfer',
                        'message' => "طلب تحويل بنكي جديد من {$request->sender_name} بمبلغ {$request->amount} جنيه يحتاج للمراجعة.",
                    ]);
                    Log::info('Admin notification created', [
                        'admin_id' => $admin->id,
                        'notification_id' => $adminNotification->id
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to create admin notifications', ['error' => $e->getMessage()]);
            }

            Log::info('Bank transfer process completed successfully');
            return redirect()->back()->with('success', 'تم إرسال طلب التحويل بنجاح!');
        } catch (\Exception $e) {
            Log::error('Bank transfer process failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'حدث خطأ أثناء معالجة التحويل: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, BankTransfer $transfer)
    {
        Log::info('Starting status update', ['transfer_id' => $transfer->id, 'new_status' => $request->status]);

        $request->validate([
            'status' => 'required|in:approved,rejected,pending'
        ]);

        try {
            $oldStatus = $transfer->status;
            $transfer->update(['status' => $request->status]);

            Log::info('Transfer status updated', [
                'transfer_id' => $transfer->id,
                'old_status' => $oldStatus,
                'new_status' => $request->status
            ]);

            // إشعار المستخدم بتحديث الحالة
            $messages = [
                'approved' => 'تم قبول التحويل البنكي وتفعيل الاشتراك بنجاح! 🎉',
                'rejected' => 'تم رفض التحويل البنكي. يرجى التواصل مع الدعم الفني للمزيد من التفاصيل. ❌',
                'pending' => 'التحويل البنكي قيد المراجعة. ⏳'
            ];

            $notification = Notification::create([
                'user_id' => $transfer->user_id,
                'type' => 'bank_transfer_status_updated',
                'message' => $messages[$request->status],
            ]);

            Log::info('Status notification created', ['notification_id' => $notification->id]);

            // إذا تم القبول، قم بتفعيل الاشتراك
            if ($request->status === 'approved' && $oldStatus !== 'approved') {
                $user = $transfer->user;
                $user->update(['subscription_id' => $transfer->subscription_id]);

                Log::info('Subscription activated', ['user_id' => $user->id, 'subscription_id' => $transfer->subscription_id]);

                // إشعار إضافي بتفعيل الاشتراك
                $activationNotification = Notification::create([
                    'user_id' => $transfer->user_id,
                    'type' => 'subscription_activated',
                    'message' => 'تم تفعيل اشتراكك بنجاح! يمكنك الآن الاستفادة من جميع المزايا المتاحة. ✅',
                ]);

                Log::info('Activation notification created', ['notification_id' => $activationNotification->id]);
            }

            return redirect()->back()->with('success', 'تم تحديث حالة التحويل بنجاح!');
        } catch (\Exception $e) {
            Log::error('Status update failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث الحالة: ' . $e->getMessage());
        }
    }
}
