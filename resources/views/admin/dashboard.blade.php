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
                <div class="stat-number">1,234</div>
                <div class="stat-label">إجمالي المستخدمين</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon active">✅</div>
                <div class="stat-number">1,156</div>
                <div class="stat-label">المستخدمين النشطين</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon percentage">📊</div>
                <div class="stat-number">89.2%</div>
                <div class="stat-label">معدل النشاط</div>
            </div>
        </div>

        <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2); margin-bottom: 2rem;">
            <h3 style="color: #333; margin-bottom: 1.5rem; font-size: 1.5rem;">قائمة المستخدمين النشطين</h3>
            <div style="display: grid; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: rgba(231, 76, 60, 0.05); border-radius: 12px; border-right: 4px solid #e74c3c;">
                    <div>
                        <p style="font-weight: 600; color: #333; margin-bottom: 0.5rem;">أحمد محمد علي</p>
                        <p style="color: #64748b; font-size: 0.9rem;">ahmed.mohamed@email.com</p>
                    </div>
                    <div style="text-align: center;">
                        <span style="background: #27ae60; color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem;">نشط</span>
                        <p style="color: #64748b; font-size: 0.8rem; margin-top: 0.5rem;">منذ 5 دقائق</p>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: rgba(52, 152, 219, 0.05); border-radius: 12px; border-right: 4px solid #3498db;">
                    <div>
                        <p style="font-weight: 600; color: #333; margin-bottom: 0.5rem;">فاطمة سالم</p>
                        <p style="color: #64748b; font-size: 0.9rem;">fatima.salem@email.com</p>
                    </div>
                    <div style="text-align: center;">
                        <span style="background: #27ae60; color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem;">نشط</span>
                        <p style="color: #64748b; font-size: 0.8rem; margin-top: 0.5rem;">منذ 12 دقيقة</p>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: rgba(39, 174, 96, 0.05); border-radius: 12px; border-right: 4px solid #27ae60;">
                    <div>
                        <p style="font-weight: 600; color: #333; margin-bottom: 0.5rem;">محمود حسن</p>
                        <p style="color: #64748b; font-size: 0.9rem;">mahmoud.hassan@email.com</p>
                    </div>
                    <div style="text-align: center;">
                        <span style="background: #f39c12; color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem;">خامل</span>
                        <p style="color: #64748b; font-size: 0.8rem; margin-top: 0.5rem;">منذ ساعتين</p>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: rgba(155, 89, 182, 0.05); border-radius: 12px; border-right: 4px solid #9b59b6;">
                    <div>
                        <p style="font-weight: 600; color: #333; margin-bottom: 0.5rem;">سارة أحمد</p>
                        <p style="color: #64748b; font-size: 0.9rem;">sara.ahmed@email.com</p>
                    </div>
                    <div style="text-align: center;">
                        <span style="background: #27ae60; color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem;">نشط</span>
                        <p style="color: #64748b; font-size: 0.8rem; margin-top: 0.5rem;">منذ دقيقة</p>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2);">
                <h3 style="color: #333; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    📊 إحصائيات الاستخدام الشهرية
                </h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <div style="text-align: center; padding: 1rem; background: rgba(52, 152, 219, 0.1); border-radius: 12px; flex: 1; margin: 0 0.5rem;">
                        <p style="font-size: 1.5rem; font-weight: bold; color: #3498db; margin-bottom: 0.5rem;">2,847</p>
                        <p style="color: #64748b; font-size: 0.9rem;">ملفات PDF تم إنشاؤها</p>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: rgba(39, 174, 96, 0.1); border-radius: 12px; flex: 1; margin: 0 0.5rem;">
                        <p style="font-size: 1.5rem; font-weight: bold; color: #27ae60; margin-bottom: 0.5rem;">12.5 GB</p>
                        <p style="color: #64748b; font-size: 0.9rem;">إجمالي المساحة المستخدمة</p>
                    </div>
                </div>
                <p style="color: #64748b; line-height: 1.6;">يظهر نشاط المستخدمين ارتفاعاً ملحوظاً بنسبة 23% مقارنة بالشهر الماضي، مع زيادة في استخدام ميزات التحويل المتقدمة.</p>
            </div>

            <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2);">
                <h3 style="color: #333; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    🚨 تنبيهات النظام
                </h3>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div style="padding: 0.8rem; background: rgba(231, 76, 60, 0.1); border-radius: 8px; border-right: 3px solid #e74c3c;">
                        <p style="font-weight: 600; color: #e74c3c; margin-bottom: 0.3rem; font-size: 0.9rem;">خطأ في الخادم</p>
                        <p style="color: #64748b; font-size: 0.8rem;">فشل في رفع 3 ملفات</p>
                    </div>
                    <div style="padding: 0.8rem; background: rgba(243, 156, 18, 0.1); border-radius: 8px; border-right: 3px solid #f39c12;">
                        <p style="font-weight: 600; color: #f39c12; margin-bottom: 0.3rem; font-size: 0.9rem;">مساحة منخفضة</p>
                        <p style="color: #64748b; font-size: 0.8rem;">تبقى 15% من المساحة</p>
                    </div>
                    <div style="padding: 0.8rem; background: rgba(39, 174, 96, 0.1); border-radius: 8px; border-right: 3px solid #27ae60;">
                        <p style="font-weight: 600; color: #27ae60; margin-bottom: 0.3rem; font-size: 0.9rem;">نسخ احتياطي مكتمل</p>
                        <p style="color: #64748b; font-size: 0.8rem;">تم بنجاح الساعة 2:30 ص</p>
                    </div>
                </div>
            </div>
        </div>
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
        });

    </script>


@endsection