{{-- resources/views/privacy_policy.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
    <div class="max-w-5xl mx-auto px-4">

        <!-- Header Section -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-600 text-white rounded-full mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h1 class="text-5xl font-bold text-gray-900 mb-4">{{ __('messages.privacy_policy') }}</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">نحن نقدر خصوصيتك ونلتزم بحماية بياناتك الشخصية</p>
        </div>

        <!-- Privacy Policy Section -->
        <div class="text-center bg-white rounded-2xl shadow-xl mb-12 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
                <h2 class="justify-center text-3xl font-bold text-white flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    سياسة الخصوصية
                </h2>
                <p class="text-blue-100 mt-2">آخر تحديث: {{ date('Y/m/d') }}</p>
            </div>

            <div class="px-8 py-8">
                <div class="prose prose-lg max-w-none">
                    {!! $privacyPolicy !!}
                </div>
            </div>
        </div>

        <!-- Terms and Conditions Section -->
        <div class="text-center bg-white rounded-2xl shadow-xl mb-12 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-teal-600 px-8 py-6">
                <h2 class="justify-center text-3xl font-bold text-white flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    الشروط والأحكام
                </h2>
                <p class="text-green-100 mt-2">آخر تحديث: {{ date('Y/m/d') }}</p>
            </div>

            <div class="px-8 py-8">
                <div class="prose prose-lg max-w-none">
                    {!! $terms !!}
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="bg-gray-900 rounded-2xl shadow-xl p-8 text-center">
            <h3 class="text-2xl font-bold text-white mb-4">هل لديك أسئلة؟</h3>
            <p class="text-gray-300 mb-6">إذا كان لديك أي استفسار حول سياسة الخصوصية أو الشروط والأحكام، لا تتردد في التواصل معنا</p>
            <a href="{{ route('contact') }}" class="text-center inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                تواصل معنا
            </a>
        </div>
    </div>
</div>

<style>
    .prose {
        color: #374151;
        line-height: 1.75;
    }

    .prose h1 {
        color: #1f2937;
        font-weight: 800;
        font-size: 2.25rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
        border-bottom: 3px solid #3b82f6;
        padding-bottom: 0.5rem;
    }

    .prose h2 {
        color: #1f2937;
        font-weight: 700;
        font-size: 1.875rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
        position: relative;
        padding-left: 1rem;
    }

    .prose h2::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0.5rem;
        width: 4px;
        height: 1.5rem;
        background: linear-gradient(to bottom, #3b82f6, #8b5cf6);
        border-radius: 2px;
    }

    .prose h3 {
        color: #374151;
        font-weight: 600;
        font-size: 1.5rem;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .prose p {
        margin-bottom: 1.25rem;
        text-align: justify;
    }

    .prose ul {
        margin: 1.25rem 0;
        padding-right: 1.5rem;
    }

    .prose li {
        margin-bottom: 0.5rem;
        position: relative;
    }

    .prose ul li::before {
        content: '•';
        color: #3b82f6;
        font-weight: bold;
        position: absolute;
        right: -1rem;
    }

    .prose strong {
        color: #1f2937;
        font-weight: 600;
    }

    .prose a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .prose a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    .prose blockquote {
        border-right: 4px solid #3b82f6;
        padding-right: 1rem;
        margin: 1.5rem 0;
        font-style: italic;
        background: #f8fafc;
        padding: 1rem;
        border-radius: 0.5rem;
    }

</style>
@endsection
