<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteName }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }

        main {
            flex: 1 0 auto;
        }

        footer {
            flex-shrink: 0;
        }

        .drag-over {
            border-color: #3B82F6 !important;
            background-color: #EBF8FF !important;
        }

        .sidebar {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.open {
            transform: translateX(0);
        }

    </style>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg fixed top-0 w-full z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center">
                    <a href="{{ route('/') }}" class="text-2xl font-bold text-black">{{ $siteName }}</a>
                </div>

                <div class="lg:hidden">
                    <button id="menu-toggle" class="text-gray-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>

                <div id="menu" class="hidden lg:flex md:items-center md:space-x-4 md:space-x-reverse">
                    <a href="{{ route('merge_pdf') }}" class="block md:inline-block px-2 py-2 md:py-0 text-md font-semibold text-gray-700 hover:text-black">
                        {{ __('messages.merge_pdf') }}
                    </a>
                    <a href="{{ route('pdf_to_word') }}" class="block md:inline-block py-2 md:py-0 text-md font-semibold text-gray-700 hover:text-black">
                        {{ __('messages.convert_word') }}
                    </a>
                    <a href="{{ route('pdf_to_powerpoint') }}" class="block md:inline-block py-2 md:py-0 text-md font-semibold text-gray-700 hover:text-black">
                        {{ __('messages.convert_powerpoint') }}
                    </a>
                    <a href="{{ route('pdf_to_excel') }}" class="block md:inline-block py-2 md:py-0 text-md font-semibold text-gray-700 hover:text-black">
                        {{ __('messages.convert_excel') }}
                    </a>
                    <a href="{{ route('rotate_pdf') }}" class="block md:inline-block py-2 md:py-0 text-md font-semibold text-gray-700 hover:text-black">
                        {{ __('messages.rotate_pdf') }}
                    </a>
                    <div>
                        @auth
                        <a href="{{ route('premium') }}" class="block md:inline-block py-2 md:py-0 text-md font-semibold text-gray-700 hover:text-black">
                            {{ __('messages.subscription') }}
                        </a>
                        @else
                        <a href="{{ route('register') }}" class="block md:inline-block py-2 md:py-0 text-md font-semibold text-gray-700 hover:text-black">
                            {{ __('messages.subscription') }}
                        </a>
                        @endauth
                    </div>
                    @auth
                    <a href="{{ route('contact') }}" class="block md:inline-block py-2 md:py-0 text-md font-semibold text-gray-700 hover:text-black">
                        {{ __('messages.contact') }}
                    </a>
                    @else
                    <a href="{{ route('register') }}" class="block md:inline-block py-2 md:py-0 text-md font-semibold text-gray-700 hover:text-black">
                        {{ __('messages.contact') }}
                    </a>
                    @endauth
                </div>

                <div id="auth-menu" class="hidden lg:flex md:items-center space-x-4 rtl:space-x-reverse">
                    <a href="{{ route('lang.switch', ['locale' => App::isLocale('ar') ? 'en' : 'ar']) }}" class="text-md font-bold text-gray-700 hover:text-black">
                        {{ App::isLocale('ar') ? __('messages.english') : __('messages.arabic') }}
                    </a>

                    @auth
                                      <div class="relative">
                        <a href="{{ route('notifications.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white hover:text-gray-700 focus:outline-none">
                            @if($bank_transfers > 0)
                            <span style="position: relative;
    top: -10px;
    right: -13px;
    background: red;
    color: white;
    border-radius: 50%;
    height: 19px;
    font-size: 11px;
    width: 19px;
    text-align: center;">{{ $bank_transfers }}</span>
@endif

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            @if (Auth::user()->unreadNotifications()->count() > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                {{ Auth::user()->unreadNotifications()->count() }}
                            </span>
                            @endif
                        </a>
                        <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg z-50">
                            <div class="py-2">
                                @foreach (Auth::user()->notifications()->latest()->take(5)->get() as $notification)
                                <div class="px-4 py-2 {{ $notification->read_at ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200">
                                    <p class="text-sm text-gray-700">{{ $notification->message }}</p>
                                    <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                                @endforeach
                                <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-blue-600 hover:bg-gray-200">عرض جميع الإشعارات</a>
                            </div>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
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
                                    {{ __('messages.profile') }}
                                </x-dropdown-link>
                                {{-- <x-dropdown-link :href="route('admin.dashboard')" v-if="Auth::user()->is_admin">
                                    لوحة تحكم الإدارة
                                </x-dropdown-link> --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('messages.logout') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    @else
                    <div class="md:space-x-4 md:space-x-reverse">
                        <a href="{{ route('login') }}" class="block md:inline-block py-2 md:py-0 text-gray-900 hover:text-black font-bold px-2">
                            {{ __('messages.login') }}
                        </a>

                        <a href="{{ route('register') }}" class="block md:inline-block py-1 bg-black text-white px-3 rounded-lg hover:bg-gray-700 font-bold">
                            {{ __('messages.sign_up') }}
                        </a>
                    </div>
                    @endauth
                </div>
            </div>
            <div id="mobile-menu" class="lg:hidden hidden">
                <div class="flex flex-col space-y-2 py-4">
                    <!-- Language Switcher for Mobile -->
                    <div class="language-switcher mb-2">
                        <a href="{{ route('lang.switch', 'en') }}" class="px-3 py-1 mr-2 {{ app()->getLocale() == 'en' ? 'bg-blue-500 text-white' : 'text-blue-500' }} rounded">
                            {{ __('messages.english') }}
                        </a>
                        <a href="{{ route('lang.switch', 'ar') }}" class="px-3 py-1 {{ app()->getLocale() == 'ar' ? 'bg-blue-500 text-white' : 'text-blue-500' }} rounded">
                            {{ __('messages.arabic') }}
                        </a>
                    </div>

                    <a href="{{ route('merge_pdf') }}" class="py-2 text-md font-semibold text-gray-700 hover:text-black">
                        {{ __('messages.merge_pdf') }}
                    </a>
                    <a href="{{ route('pdf_to_word') }}" class="py-2 text-md font-semibold text-gray-700 hover:text-black">
                        {{ __('messages.convert_word') }}
                    </a>
                    <a href="{{ route('pdf_to_powerpoint') }}" class="py-2 text-md font-semibold text-gray-700 hover:text-black">
                        {{ __('messages.convert_powerpoint') }}
                    </a>
                    <a href="{{ route('pdf_to_excel') }}" class="py-2 text-md font-semibold text-gray-700 hover:text-black">
                        {{ __('messages.convert_excel') }}
                    </a>
                    <a href="{{ route('rotate_pdf') }}" class="py-2 text-md font-semibold text-gray-700 hover:text-black">
                        {{ __('messages.rotate_pdf') }}
                    </a>

                    @auth
                    <a href="{{ route('notifications.index') }}" class="py-2 text-md font-semibold text-gray-700 hover:text-black">
                        الإشعارات
                        @if (auth()->user()->unreadNotifications()->count() > 0)
                        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                            {{ auth()->user()->unreadNotifications()->count() }}
                        </span>
                        @endif
                    </a>
                    <a href="{{ route('profile.edit') }}" class="py-2 text-md font-semibold text-gray-700 hover:text-black">
                        {{ __('messages.profile') }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="py-2 text-gray-700 hover:text-black w-full text-left">
                            {{ __('messages.logout') }}
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="block py-2 text-gray-900 hover:text-black font-bold">
                        {{ __('messages.login') }}
                    </a>

                    <a href="{{ route('register') }}" class="py-3 bg-black text-white px-3 rounded-lg hover:bg-gray-700 font-bold">
                        {{ __('messages.sign_up') }}
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <script>
        // Existing JavaScript for hamburger menu
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // JavaScript for notifications dropdown
        const notificationsToggle = document.getElementById('notifications-toggle');
        const notificationsDropdown = document.getElementById('notifications-dropdown');
        notificationsToggle.addEventListener('click', () => {
            notificationsDropdown.classList.toggle('hidden');
        });

    </script>

    <main class="mt-[3.5rem]">
        @if(session('error'))
        <div class="bg-red-100 mt-3 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white rounded-lg shadow-sm m-4 border">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-gray-500 sm:text-center">
                © 2025
                <a target="_blank" href="https://omarosamaali.github.io/Portfolio/" class="hover:underline">
                    Omar
                </a>.
                {{ __('messages.all_rights_reserved') }}
            </span>
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 sm:mt-0">
                <li>
                    <a href="{{ route('about') }}" class="hover:underline me-4 md:me-6">
                        {{ __('messages.about') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('privacy-policy') }}" class="hover:underline me-4 md:me-6">
                        {{ __('messages.privacy_policy') }}
                    </a>
                </li>
            </ul>
        </div>
    </footer>
</body>

</html>
