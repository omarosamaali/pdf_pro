<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('messages.subscription_information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('messages.subscription_details_description') }}
        </p>
    </header>

    <div class="mt-6 space-y-4">
        @if($user->subscription_id && $user->subscription)
        <!-- Current Subscription -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">
                        @if(app()->getLocale() == 'ar')
                        {{ $user->subscription->name_ar }}
                        @else
                        {{ $user->subscription->name_en }}
                        @endif
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ __('messages.current_subscription') }}
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-indigo-600">
                        ${{ $user->subscription->price }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $user->subscription->duration_in_days }} {{ __('messages.days') }}
                    </div>
                </div>
            </div>

            <!-- Features -->
            @php
            $locale = app()->getLocale();
            $featuresColumn = $locale == 'ar' ? 'features_ar' : 'features_en';
            $featuresRaw = $user->subscription->getRawOriginal($featuresColumn);

            $features = [];
            if (!empty($featuresRaw)) {
            if (is_string($featuresRaw)) {
            $decoded = json_decode($featuresRaw, true);
            $features = is_array($decoded) ? $decoded : [];
            } elseif (is_array($featuresRaw)) {
            $features = $featuresRaw;
            }
            }
            @endphp

            @if(!empty($features))
            <div class="mt-4 pt-4 border-t border-blue-200">
                <h4 class="font-medium text-gray-900 mb-2">{{ __('messages.features') }}:</h4>
                <ul class="space-y-2">
                    @foreach($features as $feature)
                    @if(!empty(trim($feature)))
                    <li class="flex items-center text-sm text-gray-700">
                        <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ $feature }}
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Operations Limit -->
            @if($user->subscription->daily_operations_limit)
            <div class="mt-4 pt-4 border-t border-blue-200">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">
                        {{ __('messages.daily_operations_limit') }}
                    </span>
                    <span class="text-sm text-indigo-600 font-semibold">
                        {{ $user->subscription->daily_operations_limit }} {{ __('messages.operations_per_day') }}
                    </span>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="mt-4 pt-4 border-t border-blue-200 flex space-x-3">
                <a href="{{ route('payment') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('messages.upgrade_subscription') }}
                </a>
                <a href="{{ route('history') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('messages.subscription_history') }}
                </a>
            </div>
        </div>
        @else
        <!-- No Active Subscription -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center" style="justify-content: center;">
                <svg class="h-6 w-6 text-yellow-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.082 15.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <div>
                    <h3 class="text-lg font-medium text-yellow-800">
                        {{ __('messages.no_active_subscription') }}
                    </h3>
                    <p class="text-sm text-yellow-700 mt-1">
                        {{ __('messages.no_subscription_description') }}
                    </p>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('subscriptions.index') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('messages.choose_subscription') }}
                </a>
            </div>
        </div>
        @endif
    </div>
</section>
