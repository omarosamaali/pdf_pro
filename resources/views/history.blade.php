@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900" style="text-align: center;">{{ __('messages.subscription_history') }}</h1>
                    <p class="mt-2 text-gray-600" style="text-align: center;">{{ __('messages.subscription_history_description') }}</p>
                </div>

                <div class="space-y-6">
                    @if($user->subscription)
                    <!-- Current Active Subscription -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ __('messages.current_active_subscription') }}</h3>
                            </div>
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                {{ __('messages.active') }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div style="text-align: center;">

                                <p class="text-sm text-gray-600">{{ __('messages.plan_name') }}</p>
                                <p class="font-medium text-gray-900">
                                    @if(app()->getLocale() == 'ar')
                                    {{ $user->subscription->name_ar }}
                                    @else
                                    {{ $user->subscription->name_en }}
                                    @endif
                                </p>
                            </div>
                            <div style="text-align: center;">
                                <p class="text-sm text-gray-600">{{ __('messages.price') }}</p>
                                <p class="font-medium text-gray-900">${{ $user->subscription->price }}</p>
                            </div>
                            <div style="text-align: center;">
                                <p class="text-sm text-gray-600">{{ __('messages.duration') }}</p>
                                <p class="font-medium text-gray-900">{{ $user->subscription->duration_in_days }} {{ __('messages.days') }}</p>
                            </div>
                            <div style="text-align: center;">
                                <p class="text-sm text-gray-600">{{ __('messages.operations_limit') }}</p>
                                <p class="font-medium text-gray-900">
                                    @if($user->subscription->daily_operations_limit)
                                    {{ $user->subscription->daily_operations_limit }}/{{ __('messages.day') }}
                                    @else
                                    {{ __('messages.unlimited') }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($user->subscription_start_date || $user->subscription_end_date)
                        <div class="mt-4 pt-4 border-t border-green-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($user->subscription_start_date)
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('messages.start_date') }}</p>
                                    <p class="font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($user->subscription_start_date)->format('Y-m-d') }}
                                    </p>
                                </div>
                                @endif
                                @if($user->subscription_end_date)
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('messages.end_date') }}</p>
                                    <p class="font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($user->subscription_end_date)->format('Y-m-d') }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    @else
                    <!-- No Active Subscription -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-300 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2M4 13h2m0 0V9a2 2 0 012-2h2m0 0V6a2 2 0 012-2h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V9M16 13h2m-6 0h2m0 0V9a2 2 0 00-2-2H8a2 2 0 00-2 2v4.01" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('messages.no_active_subscription') }}</h3>
                        <p class="text-gray-600 mb-4">{{ __('messages.no_subscription_history') }}</p>
                        <a href="{{ route('premium') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            {{ __('messages.browse_plans') }}
                        </a>
                    </div>
                    @endif

                    <!-- Future: Add subscription history from separate table -->
                    {{--
                    @if(isset($subscriptionHistory) && $subscriptionHistory->count() > 0)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('messages.previous_subscriptions') }}</h3>

                    @foreach($subscriptionHistory as $history)
                    <div class="bg-white border border-gray-200 rounded-lg p-4 mb-3">
                        <!-- History item content -->
                    </div>
                    @endforeach
                </div>
                @endif
                --}}
            </div>

            <div class="mt-6 flex justify-between">
                <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-800">
                    ← {{ __('messages.back_to_profile') }}
                </a>
                <a href="{{ route('premium') }}" class="text-blue-600 hover:text-blue-800">
                    {{ __('messages.browse_plans') }} →
                </a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
