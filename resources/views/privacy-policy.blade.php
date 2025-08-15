@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="prose prose-lg max-w-none">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ __('messages.privacy_policy') }}</h1>
            <p class="text-gray-600">{{ __('messages.last_updated') }}</p>
        </div>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-8">
            <p class="text-blue-800">
                {{ __('messages.privacy_intro_text') }}
            </p>
        </div>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('messages.information_we_collect') }}</h2>

            <h3 class="text-xl font-medium text-gray-800 mb-3">{{ __('messages.personal_information') }}</h3>
            <ul class="list-disc pl-6 mb-4 text-gray-700">
                <li>{{ __('messages.personal_info_list_1') }}</li>
                <li>{{ __('messages.personal_info_list_2') }}</li>
                <li>{{ __('messages.personal_info_list_3') }}</li>
                <li>{{ __('messages.personal_info_list_4') }}</li>
            </ul>

            <h3 class="text-xl font-medium text-gray-800 mb-3">{{ __('messages.file_information') }}</h3>
            <ul class="list-disc pl-6 mb-4 text-gray-700">
                <li>{{ __('messages.file_info_list_1') }}</li>
                <li>{{ __('messages.file_info_list_2') }}</li>
                <li>{{ __('messages.file_info_list_3') }}</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('messages.how_we_use_info') }}</h2>
            <ul class="list-disc pl-6 text-gray-700">
                <li>{{ __('messages.how_we_use_list_1') }}</li>
                <li>{{ __('messages.how_we_use_list_2') }}</li>
                <li>{{ __('messages.how_we_use_list_3') }}</li>
                <li>{{ __('messages.how_we_use_list_4') }}</li>
                <li>{{ __('messages.how_we_use_list_5') }}</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('messages.file_security') }}</h2>
            <div class="bg-green-50 border border-green-200 p-6 rounded-lg">
                <h3 class="text-lg font-medium text-green-800 mb-3">{{ __('messages.your_files_are_safe') }}</h3>
                <ul class="list-disc pl-6 text-green-700">
                    <li>{{ __('messages.file_security_list_1') }}</li>
                    <li>{{ __('messages.file_security_list_2') }}</li>
                    <li>{{ __('messages.file_security_list_3') }}</li>
                    <li>{{ __('messages.file_security_list_4') }}</li>
                </ul>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('messages.data_sharing') }}</h2>
            <p class="text-gray-700 mb-4">{{ __('messages.data_sharing_intro') }}</p>
            <ul class="list-disc pl-6 text-gray-700">
                <li>{{ __('messages.data_sharing_list_1') }}</li>
                <li>{{ __('messages.data_sharing_list_2') }}</li>
                <li>{{ __('messages.data_sharing_list_3') }}</li>
                <li>{{ __('messages.data_sharing_list_4') }}</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('messages.cookies_tracking') }}</h2>
            <p class="text-gray-700 mb-4">
                {{ __('messages.cookies_intro') }}
            </p>
            <ul class="list-disc pl-6 text-gray-700">
                <li><strong>{{ __('messages.essential_cookies') }}</strong> {{ __('messages.essential_cookies_desc') }}</li>
                <li><strong>{{ __('messages.analytics_cookies') }}</strong> {{ __('messages.analytics_cookies_desc') }}</li>
                <li><strong>{{ __('messages.preference_cookies') }}</strong> {{ __('messages.preference_cookies_desc') }}</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('messages.your_rights') }}</h2>
            <p class="text-gray-700 mb-4">{{ __('messages.your_rights_intro') }}</p>
            <ul class="list-disc pl-6 text-gray-700">
                <li>{{ __('messages.your_rights_list_1') }}</li>
                <li>{{ __('messages.your_rights_list_2') }}</li>
                <li>{{ __('messages.your_rights_list_3') }}</li>
                <li>{{ __('messages.your_rights_list_4') }}</li>
                <li>{{ __('messages.your_rights_list_5') }}</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('messages.updates_to_policy') }}</h2>
            <p class="text-gray-700">
                {{ __('messages.updates_policy_desc') }}
            </p>
        </section>
    </div>
</div>

@endsection
