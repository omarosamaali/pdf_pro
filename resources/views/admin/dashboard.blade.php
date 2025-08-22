@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('content')
<div class="content-header">
    <h2>لوحة التحكم</h2>
    <p>مرحباً بك في لوحة تحكم PDF Pro - إدارة شاملة للموقع</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon users">👥</div>
        <div class="stat-number">{{ $totalUsers }}</div>
        <div class="stat-label">إجمالي المستخدمين</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon active">✅</div>
        <div class="stat-number">{{ $activeUsersCount }}</div>
        <div class="stat-label">المستخدمين النشطين</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon percentage">📊</div>
        <div class="stat-number">{{ $activityRate }}%</div>
        <div class="stat-label">معدل النشاط</div>
    </div>
</div>

<div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2); margin-bottom: 2rem;">
    <h3 style="color: #333; margin-bottom: 1.5rem; font-size: 1.5rem;">قائمة المستخدمين النشطين</h3>
    <div style="display: grid; gap: 1rem;">
        @if($recentActiveUsers->count() > 0)
        @foreach($recentActiveUsers as $index => $user)
        @php
        $colors = ['#e74c3c', '#3498db', '#27ae60', '#9b59b6', '#f39c12'];
        $color = $colors[$index % count($colors)];

        $lastSeenDiff = \Carbon\Carbon::parse($user->last_seen)->diffForHumans();
        $isActive = \Carbon\Carbon::parse($user->last_seen)->diffInMinutes(now()) <= 30; @endphp <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: rgba({{ hexdec(substr($color, 1, 2)) }}, {{ hexdec(substr($color, 3, 2)) }}, {{ hexdec(substr($color, 5, 2)) }}, 0.05); border-radius: 12px; border-right: 4px solid {{ $color }};">
            <div>
                <p style="font-weight: 600; color: #333; margin-bottom: 0.5rem;">{{ $user->name ?? 'مستخدم' }}</p>
                <p style="color: #64748b; font-size: 0.9rem;">{{ $user->email }}</p>
            </div>
            <div style="text-align: center;">
                <span style="background: {{ $isActive ? '#27ae60' : '#f39c12' }}; color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem;">
                    {{ $isActive ? 'نشط' : 'خامل' }}
                </span>
                <p style="color: #64748b; font-size: 0.8rem; margin-top: 0.5rem;">{{ $lastSeenDiff }}</p>
            </div>
    </div>
    @endforeach
    @else
    <div style="text-align: center; padding: 2rem; color: #64748b;">
        <p>لا يوجد مستخدمين نشطين حالياً</p>
    </div>
    @endif
</div>
</div>

{{-- <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2);">
        <h3 style="color: #333; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            📊 إحصائيات الاستخدام الشهرية
        </h3>
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
            <div style="text-align: center; padding: 1rem; background: rgba(52, 152, 219, 0.1); border-radius: 12px; flex: 1; margin: 0 0.5rem;">
                <p style="font-size: 1.5rem; font-weight: bold; color: #3498db; margin-bottom: 0.5rem;">
                    {{ number_format($filesCreatedThisMonth) }}
                </p>
                <p style="color: #64748b; font-size: 0.9rem;">ملفات PDF تم إنشاؤها</p>
            </div>
            <div style="text-align: center; padding: 1rem; background: rgba(39, 174, 96, 0.1); border-radius: 12px; flex: 1; margin: 0 0.5rem;">
                <p style="font-size: 1.5rem; font-weight: bold; color: #27ae60; margin-bottom: 0.5rem;">
                    {{ $totalStorageUsedGB }} GB
                </p>
                <p style="color: #64748b; font-size: 0.9rem;">إجمالي المساحة المستخدمة</p>
            </div>
        </div>
        @php
        $previousMonth = \Carbon\Carbon::now()->subMonth();
        $previousMonthFiles = \App\Models\File::whereMonth('created_at', $previousMonth->month)
        ->whereYear('created_at', $previousMonth->year)
        ->count();

        $growthPercentage = 0;
        if ($previousMonthFiles > 0) {
        $growthPercentage = round((($filesCreatedThisMonth - $previousMonthFiles) / $previousMonthFiles) * 100, 1);
        }
        @endphp

        <p style="color: #64748b; line-height: 1.6;">
            @if($growthPercentage > 0)
            يظهر نشاط المستخدمين ارتفاعاً ملحوظاً بنسبة {{ $growthPercentage }}% مقارنة بالشهر الماضي، مع زيادة في استخدام ميزات التحويل المتقدمة.
            @elseif($growthPercentage < 0) انخفض نشاط المستخدمين بنسبة {{ abs($growthPercentage) }}% مقارنة بالشهر الماضي. @else نشاط المستخدمين مستقر مقارنة بالشهر الماضي. @endif </p>
    </div>

    <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2);">
        <h3 style="color: #333; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            🚨 تنبيهات النظام
        </h3>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @php
            $alerts = [];

            // تحقق من المساحة المستخدمة
            $maxStorage = 100; // GB - حدد الحد الأقصى حسب خطتك
            $storagePercentage = $maxStorage > 0 ? ($totalStorageUsedGB / $maxStorage) * 100 : 0;

            if ($storagePercentage > 85) {
            $alerts[] = [
            'type' => 'warning',
            'color' => '#f39c12',
            'title' => 'مساحة منخفضة',
            'message' => 'تبقى ' . round(100 - $storagePercentage, 1) . '% من المساحة'
            ];
            }

            // تحقق من المستخدمين الجدد اليوم
            $newUsersToday = \App\Models\User::whereDate('created_at', today())->count();
            if ($newUsersToday > 0) {
            $alerts[] = [
            'type' => 'info',
            'color' => '#3498db',
            'title' => 'مستخدمون جدد',
            'message' => "انضم {$newUsersToday} مستخدم جديد اليوم"
            ];
            }

            // رسالة النسخ الاحتياطي (مثال ثابت)
            $alerts[] = [
            'type' => 'success',
            'color' => '#27ae60',
            'title' => 'نسخ احتياطي مكتمل',
            'message' => 'تم بنجاح في ' . now()->format('H:i')
            ];
            @endphp

            @foreach($alerts as $alert)
            <div style="padding: 0.8rem; background: rgba({{ hexdec(substr($alert['color'], 1, 2)) }}, {{ hexdec(substr($alert['color'], 3, 2)) }}, {{ hexdec(substr($alert['color'], 5, 2)) }}, 0.1); border-radius: 8px; border-right: 3px solid {{ $alert['color'] }};">
                <p style="font-weight: 600; color: {{ $alert['color'] }}; margin-bottom: 0.3rem; font-size: 0.9rem;">
                    {{ $alert['title'] }}
                </p>
                <p style="color: #64748b; font-size: 0.8rem;">{{ $alert['message'] }}</p>
            </div>
            @endforeach

            @if(empty($alerts))
            <div style="padding: 1rem; text-align: center; color: #64748b;">
                <p>لا توجد تنبيهات حالياً ✨</p>
            </div>
            @endif
        </div>
    </div>
</div> --}}

<script>
    // Add mobile menu toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Add mobile responsiveness
        function handleResize() {
            if (window.innerWidth <= 768) {
                document.body.classList.add('mobile');
            } else {
                document.body.classList.remove('mobile');
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize();

        // Add smooth scrolling for better UX
        document.documentElement.style.scrollBehavior = 'smooth';

        // Auto refresh every 5 minutes for real-time data
        setTimeout(function() {
            location.reload();
        }, 300000); // 5 minutes
    });

</script>

@endsection
