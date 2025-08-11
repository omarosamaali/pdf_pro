@extends('layouts.app')

@section('content')
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-bold text-center mb-4 text-gray-800">Choose Your Plan</h1>
        <p class="text-center text-lg text-gray-600 mb-12">Start your journey with us today and choose the plan that suits your needs.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($subscriptions as $subscription)
            <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col justify-between">
                <div>
                    {{-- Displaying name based on current locale --}}
                    @php
                    $name = (app()->getLocale() == 'ar' && isset($subscription->name_ar)) ? $subscription->name_ar : ($subscription->name_en ?? 'N/A');
                    @endphp
                    <h2 class="text-2xl font-bold mb-4 text-center text-indigo-600">{{ $name }}</h2>

                    <p class="text-4xl font-extrabold text-center mb-6 text-gray-900">
                        {{ number_format($subscription->price, 2) }} <span class="text-base font-medium text-gray-500">
                            / {{ $subscription->duration_in_days }} Days
                        </span>
                    </p>
                    <ul class="space-y-4 text-gray-700">
                        @php
                        // Get the features array directly from the model, thanks to Model Casting
                        $features = (app()->getLocale() == 'ar' && isset($subscription->features_ar))
                        ? $subscription->features_ar
                        : ($subscription->features_en ?? []);
                        @endphp

                        {{-- The variable $features is already an array, so no need for json_decode --}}
                        @if(is_array($features))
                        @foreach ($features as $feature)
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>{{ $feature }}</span>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
                <a href="{{ route('payment', ['id' => $subscription['id']]) }}" class="mt-5 w-full bg-indigo-600 text-white text-center py-3 px-6 rounded-lg hover:bg-indigo-700 transition duration-300 font-semibold">
                    Subscribe Now
                </a>
            </div>
            @endforeach
        </div>
    </div>
</body>
@endsection
