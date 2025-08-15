<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') PDF Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eeeeee;
            min-height: 100vh;
            color: #333;
        }

        /* Header Styles */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid #d8d8d8;
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .logo h1 {
            font-size: 1.8rem;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .notification-btn,
        .profile-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(231, 76, 60, 0.1);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #e74c3c;
        }

        .notification-btn:hover,
        .profile-btn:hover {
            background: rgba(231, 76, 60, 0.2);
            transform: translateY(-2px);
        }

        .profile-btn {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-left: 1px solid #d8d8d8;
            height: 100vh;
            padding-top: 100px;
            position: fixed;
            top: 0;
            right: 0;
            overflow-y: auto;
            z-index: 999;
        }

        .sidebar-header {
            padding: 0 2rem 2rem;
            border-bottom: 1px solid rgba(231, 76, 60, 0.1);
            margin-bottom: 2rem;
        }

        .sidebar-header h3 {
            color: #e74c3c;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .sidebar-menu {
            padding: 0 1rem;
        }

        .menu-item {
            margin-bottom: 8px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            color: #64748b;
            text-decoration: none;
            border-radius: 16px;
            transition: all 0.3s ease;
            font-weight: 500;
            margin-bottom: 10px;
            position: relative;
        }

        .menu-link:hover {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
            transform: translateX(-4px);
        }

        .menu-link.active {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }

        .menu-link.active::before {
            content: '';
            position: absolute;
            right: -16px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: #e74c3c;
            border-radius: 2px;
        }

        .menu-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* Main Content */
        .main-content {
            margin-right: 280px;
            padding: 120px 2rem 2rem;
            min-height: 100vh;
        }

        .content-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .content-header h2 {
            font-size: 2rem;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .content-header p {
            color: #64748b;
            font-size: 1.1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: white;
            font-size: 24px;
        }

        .stat-icon.users {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }

        .stat-icon.active {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
        }

        .stat-icon.percentage {
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #64748b;
            font-size: 1.1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                transform: translateX(100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-right: 0;
                padding: 100px 1rem 2rem;
            }

            .header {
                padding: 1rem;
            }

            .logo h1 {
                font-size: 1.5rem;
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(231, 76, 60, 0.3);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(231, 76, 60, 0.5);
        }

    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <div class="logo-icon">PDF</div>
            <h1>PDF Pro Admin</h1>
        </div>
        <div class="header-actions">
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500  bg-white  hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('الملف الشخصي') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('تسجيل خروج') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

    </header>

    <aside class="sidebar">

        <nav class="sidebar-menu">
            <div class="menu-item">
                <a href="{{ route('dashboard') }}" class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="menu-icon">📊</span>
                    لوحة التحكم
                </a>

                <a href="{{ route('users.index') }}" class="menu-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                    <span class="menu-icon">👥</span>
                    المستخدمين
                </a>

                <a href="{{ route('subscriptions.index') }}" class="menu-link {{ request()->routeIs('subscriptions.index') ? 'active' : '' }}">
                    <span class="menu-icon">💰</span>
                    العضوية والاشتراكات
                </a>

                <a href="{{ route('payments.bank_details') }}" class="menu-link {{ request()->routeIs('payments.index') ? 'active' : '' }}">
                    <span class="menu-icon">💳</span>
                    بيانات التحويل البنكي
                </a>

                <a href="{{ route('banners.index') }}" class="menu-link {{ request()->routeIs('banners.index') ? 'active' : '' }}">
                    <span class="menu-icon">📸</span>
                    البانرات والإعلانات
                </a>

            </div>
        </nav>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>

</body>
</html>
