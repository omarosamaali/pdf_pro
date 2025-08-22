<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $activeUsersCount = User::where('last_seen', '>=', now()->subDay())->count();
        $activityRate = ($activeUsersCount / $totalUsers) * 100;
        $recentActiveUsers = User::where('last_seen', '>=', now()->subDay())->orderBy('last_seen', 'desc')->take(5)->get();
        $filesCreatedThisMonth = File::whereMonth('created_at', now()->month)->count();
        return view('admin.dashboard', compact('filesCreatedThisMonth','totalUsers', 'activeUsersCount', 'activityRate', 'recentActiveUsers'));
    }

    /**
     * الحصول على تنبيهات النظام
     */
    private function getSystemAlerts($totalStorageUsedGB)
    {
        $alerts = [];

        try {
            // تحقق من الملفات الفاشلة اليوم
            $failedUploadsToday = File::whereDate('created_at', today())
                ->where('status', 'failed')
                ->count();

            if ($failedUploadsToday > 0) {
                $alerts[] = [
                    'type' => 'error',
                    'icon' => '⚠️',
                    'title' => 'أخطاء في الرفع',
                    'message' => "فشل رفع {$failedUploadsToday} ملف اليوم",
                    'action_url' => route('admin.files.failed') // إذا كان لديك رابط لعرض الملفات الفاشلة
                ];
            }

            // تحقق من المساحة المتاحة (افتراض 100GB كحد أقصى)
            $maxStorageGB = config('app.max_storage_gb', 100);
            $storagePercentage = ($totalStorageUsedGB / $maxStorageGB) * 100;

            if ($storagePercentage > 90) {
                $alerts[] = [
                    'type' => 'critical',
                    'icon' => '🔴',
                    'title' => 'مساحة التخزين ممتلئة',
                    'message' => 'المساحة المستخدمة: ' . round($storagePercentage, 1) . '%'
                ];
            } elseif ($storagePercentage > 75) {
                $alerts[] = [
                    'type' => 'warning',
                    'icon' => '⚠️',
                    'title' => 'مساحة التخزين منخفضة',
                    'message' => 'المساحة المستخدمة: ' . round($storagePercentage, 1) . '%'
                ];
            }

            // تحقق من النسخ الاحتياطي (مثال - يمكنك تخصيصه حسب نظامك)
            $lastBackup = cache('last_backup_time');
            if ($lastBackup && Carbon::parse($lastBackup)->diffInHours(now()) < 25) {
                $alerts[] = [
                    'type' => 'success',
                    'icon' => '✅',
                    'title' => 'نسخ احتياطي حديث',
                    'message' => 'آخر نسخة: ' . Carbon::parse($lastBackup)->diffForHumans()
                ];
            } else {
                $alerts[] = [
                    'type' => 'warning',
                    'icon' => '📋',
                    'title' => 'النسخ الاحتياطي متأخر',
                    'message' => 'لم يتم إجراء نسخ احتياطي منذ أكثر من 24 ساعة'
                ];
            }

            // تحقق من المستخدمين الجدد اليوم
            $newUsersToday = User::whereDate('created_at', today())->count();
            if ($newUsersToday > 0) {
                $alerts[] = [
                    'type' => 'info',
                    'icon' => '👥',
                    'title' => 'مستخدمون جدد',
                    'message' => "انضم {$newUsersToday} مستخدم جديد اليوم"
                ];
            }
        } catch (\Exception $e) {
            $alerts[] = [
                'type' => 'error',
                'icon' => '⚠️',
                'title' => 'خطأ في النظام',
                'message' => 'حدث خطأ أثناء جمع تنبيهات النظام'
            ];
        }

        return $alerts;
    }

    /**
     * API endpoint للحصول على إحصائيات محدثة (للـ AJAX)
     */
    public function getStats()
    {
        return response()->json([
            'totalUsers' => User::count(),
            'activeUsers' => User::where('last_seen', '>=', now()->subDay())->count(),
            'todayFiles' => File::whereDate('created_at', today())->count(),
            'onlineUsers' => User::where('last_seen', '>=', now()->subMinutes(5))->count(),
        ]);
    }

    /**
     * الحصول على نشاط المستخدمين في الوقت الفعلي
     */
    public function getRealtimeActivity()
    {
        $recentActivity = File::with('user:id,name,email')
            ->select(['id', 'user_id', 'original_name', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($file) {
                return [
                    'user_name' => $file->user->name ?? 'مجهول',
                    'action' => 'تم إنشاء ملف: ' . $file->original_name,
                    'time' => $file->created_at->diffForHumans()
                ];
            });

        return response()->json($recentActivity);
    }
}
