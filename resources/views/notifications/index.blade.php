@extends('layouts.app')

@section('title', __('messages.notifications'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">📢 {{ __('messages.notifications') }}</h2>
        <p class="text-gray-600">{{ __('messages.track_account_activities') }}</p>
    </div>

    @if (session('success'))
    <div class="bg-green-50 border-r-4 border-green-500 text-green-800 p-4 rounded-lg mb-6 shadow-sm">
        <div class="flex items-center">
            <span class="text-green-500 ml-3">✅</span>
            {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden" style="direction: rtl;">
        @if(isset($notifications) && $notifications->count() > 0)
        <!-- Header with Statistics -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold">{{ __('messages.total_notifications') }}</h3>
                    <p class="text-blue-100">{{ __('messages.notifications_count', ['count' => $notifications->count()]) }}</p>
                </div>
                <div class="text-right">
                    <span class="bg-blue-500 px-3 py-1 rounded-full text-sm">
                        {{ __('messages.unread_notifications', ['count' => $notifications->where('read_at', null)->count()]) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="divide-y divide-gray-100">
            @foreach($notifications as $notification)
            <div class="hover:bg-gray-50 transition-colors duration-200 {{ is_null($notification->read_at) ? 'bg-blue-50 border-r-4 border-blue-500' : '' }}">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <!-- Notification Message -->
                            <div class="flex items-center mb-3">
                                @if(is_null($notification->read_at))
                                <span class="w-3 h-3 bg-blue-500 rounded-full ml-3 animate-pulse"></span>
                                @else
                                <span class="w-3 h-3 bg-gray-400 rounded-full ml-3"></span>
                                @endif
                                <h4 class="font-medium text-gray-900">{{ __('messages.bank_transfer_request') }}</h4>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <p class="text-gray-700 mb-3 leading-relaxed">
                                    {{ __('messages.bank_transfer_submitted', ['amount' => $notification->amount]) }}
                                </p>

                                <div class="grid md:grid-cols-2 gap-4 text-sm">
                                    <div class="flex items-center">
                                        <span class="text-gray-500 ml-2">📦</span>
                                        <span class="text-gray-600">{{ __('messages.package_name') }}</span>
                                        <span class="font-medium text-gray-800 mr-2">{{ $notification->subscription->name }}</span>
                                    </div>

                                    <div class="flex items-center">
                                        <span class="text-gray-500 ml-2">📊</span>
                                        <span class="text-gray-600">{{ __('messages.request_status') }}</span>
                                        <span class="mr-2 px-2 py-1 rounded-full text-xs font-medium
                                                @if($notification->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($notification->status == 'approved') bg-green-100 text-green-800
                                                @elseif($notification->status == 'rejected') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                            @if($notification->status == 'pending') {{ __('messages.status_pending') }}
                                            @elseif($notification->status == 'approved') {{ __('messages.status_approved') }}
                                            @elseif($notification->status == 'rejected') {{ __('messages.status_rejected') }}
                                            @else {{ $notification->status }} @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Receipt Image -->
                            @if($notification->receipt_path)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2 flex items-center">
                                    <span class="ml-2">🧾</span>
                                    {{ __('messages.receipt_image') }}
                                </p>
                                <div class="relative inline-block">
                                    <img src="{{ asset('storage/' . $notification->receipt_path) }}" alt="{{ __('messages.receipt_image') }}" class="w-24 h-24 object-cover rounded-lg border-2 border-gray-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $notification->receipt_path) }}')">
                                    <span class="absolute -top-1 -right-1 bg-blue-500 text-white text-xs px-1 rounded-full">📷</span>
                                </div>
                            </div>
                            @endif

                            <!-- Date and Time Info -->
                            <div class="flex items-center gap-6 text-sm text-gray-500 bg-white rounded-lg p-3 border">
                                <div class="flex items-center">
                                    <span class="ml-2">📅</span>
                                    {{ $notification->created_at->format('Y-m-d') }}
                                </div>
                                <div class="flex items-center">
                                    <span class="ml-2">🕐</span>
                                    {{ $notification->created_at->format('H:i') }}
                                </div>
                                <div class="flex items-center">
                                    <span class="ml-2">⏱️</span>
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- No Notifications State -->
        <div class="text-center py-16">
            <div class="mb-6">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
            </div>

            <h3 class="text-xl font-semibold text-gray-700 mb-2">{{ __('messages.no_notifications') }}</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">
                {{ __('messages.no_notifications_message') }}
            </p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('/') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 hover:scale-105 shadow-lg">
                    {{ __('messages.back_to_home') }}
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal for Enlarged Image -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" src="" alt="{{ __('messages.receipt_image') }}" class="max-w-full max-h-full object-contain rounded-lg">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center hover:bg-opacity-75 transition-colors">
            ✕
        </button>
    </div>
</div>

<script>
    function openImageModal(imageSrc) {
        document.getElementById('imageModal').classList.remove('hidden');
        document.getElementById('modalImage').src = imageSrc;
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close the modal by pressing Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImageModal();
        }
    });

</script>
@endsection
