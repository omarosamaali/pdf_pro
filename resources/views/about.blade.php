@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-4 py-12" dir="rtl">
    <div class="text-center mb-16">
        <h1 class="text-5xl font-bold text-gray-900 mb-6">{{ __('messages.about_pdf_pro') }}</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
            {{ __('messages.about_pdf_pro_description') }}
        </p>
    </div>

    <section class="mb-16">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-8 rounded-2xl">
            <h2 class="text-3xl font-bold mb-4">{{ __('messages.our_mission') }}</h2>
            <p class="text-lg leading-relaxed">
                {{ __('messages.our_mission_description') }}
            </p>
        </div>
    </section>

    <section class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">{{ __('messages.our_story') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <div class="prose prose-lg">
                    <p class="text-gray-700 leading-relaxed mb-6">
                        {{ __('messages.our_story_paragraph_1') }}
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        {{ __('messages.our_story_paragraph_2') }}
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        {{ __('messages.our_story_paragraph_3') }}
                    </p>
                </div>
            </div>
            <div class="bg-gradient-to-br from-orange-100 to-red-100 p-8 rounded-2xl">
                <div class="text-center">
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <div class="text-3xl font-bold text-orange-600 mb-2">5M+</div>
                            <div class="text-gray-600">{{ __('messages.files_processed') }}</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-red-600 mb-2">150+</div>
                            <div class="text-gray-600">{{ __('messages.countries_served') }}</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-purple-600 mb-2">99.9%</div>
                            <div class="text-gray-600">{{ __('messages.uptime') }}</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-blue-600 mb-2">24/7</div>
                            <div class="text-gray-600">{{ __('messages.support') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">{{ __('messages.what_we_stand_for') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6 bg-green-50 rounded-xl">
                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ __('messages.privacy_first') }}</h3>
                <p class="text-gray-600">
                    {{ __('messages.privacy_first_description') }}
                </p>
            </div>

            <div class="text-center p-6 bg-blue-50 rounded-xl">
                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ __('messages.user_centric') }}</h3>
                <p class="text-gray-600">
                    {{ __('messages.user_centric_description') }}
                </p>
            </div>

            <div class="text-center p-6 bg-purple-50 rounded-xl">
                <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ __('messages.innovation') }}</h3>
                <p class="text-gray-600">
                    {{ __('messages.innovation_description') }}
                </p>
            </div>
        </div>
    </section>

    <section class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">{{ __('messages.why_choose_pdf_pro') }}</h2>
        <div class="bg-gray-50 p-8 rounded-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">{{ __('messages.lightning_fast_processing') }}</h4>
                            <p class="text-gray-600">{{ __('messages.lightning_fast_processing_description') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">{{ __('messages.no_installation_required') }}</h4>
                            <p class="text-gray-600">{{ __('messages.no_installation_required_description') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">{{ __('messages.enterprise_grade_security') }}</h4>
                            <p class="text-gray-600">{{ __('messages.enterprise_grade_security_description') }}</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">{{ __('messages.all_in_one_solution') }}</h4>
                            <p class="text-gray-600">{{ __('messages.all_in_one_solution_description') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">{{ __('messages.expert_support_247') }}</h4>
                            <p class="text-gray-600">{{ __('messages.expert_support_247_description') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">{{ __('messages.constantly_improving') }}</h4>
                            <p class="text-gray-600">{{ __('messages.constantly_improving_description') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="text-center">
        <div class="bg-gradient-to-r from-gray-900 to-gray-700 text-white p-12 rounded-2xl">
            <h2 class="text-3xl font-bold mb-4">{{ __('messages.ready_to_transform') }}</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                {{ __('messages.ready_to_transform_description') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('/') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg transition-colors duration-200">
                    {{ __('messages.get_started_free') }}
                </a>
                <a href="{{ route('register') }}" class="border-2 border-white text-white hover:bg-white hover:text-gray-900 font-semibold px-8 py-3 rounded-lg transition-colors duration-200">
                    {{ __('messages.register') }}
                </a>
            </div>
        </div>
    </section>
</div>

@endsection
