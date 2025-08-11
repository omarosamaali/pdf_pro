@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-4 py-12">
    <!-- Hero Section -->
    <div class="text-center mb-16">
        <h1 class="text-5xl font-bold text-gray-900 mb-6">About PDF Pro</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
            We're passionate about making PDF management simple, fast, and accessible for everyone. Since our launch, we've helped millions of users transform their document workflows.
        </p>
    </div>

    <!-- Mission Section -->
    <section class="mb-16">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-8 rounded-2xl">
            <h2 class="text-3xl font-bold mb-4">Our Mission</h2>
            <p class="text-lg leading-relaxed">
                To empower individuals and businesses worldwide with powerful, intuitive PDF tools that save time, increase productivity, and eliminate the frustration of document management. We believe everyone deserves access to professional-grade PDF solutions without the complexity.
            </p>
        </div>
    </section>

    <!-- Story Section -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Our Story</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <div class="prose prose-lg">
                    <p class="text-gray-700 leading-relaxed mb-6">
                        PDF Pro was born from a simple frustration: dealing with clunky, expensive PDF software that made simple tasks unnecessarily complicated. Our founders, experienced developers and designers, saw an opportunity to create something better.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        Starting in 2020, we set out to build the PDF platform we wished existed - one that was fast, secure, and actually enjoyable to use. Today, we're proud to serve users in over 150 countries, processing millions of documents every month.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        What started as a side project has grown into a comprehensive PDF ecosystem, but our core values remain the same: simplicity, security, and putting our users first.
                    </p>
                </div>
            </div>
            <div class="bg-gradient-to-br from-orange-100 to-red-100 p-8 rounded-2xl">
                <div class="text-center">
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <div class="text-3xl font-bold text-orange-600 mb-2">5M+</div>
                            <div class="text-gray-600">Files Processed</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-red-600 mb-2">150+</div>
                            <div class="text-gray-600">Countries Served</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-purple-600 mb-2">99.9%</div>
                            <div class="text-gray-600">Uptime</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-blue-600 mb-2">24/7</div>
                            <div class="text-gray-600">Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">What We Stand For</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Privacy First -->
            <div class="text-center p-6 bg-green-50 rounded-xl">
                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Privacy First</h3>
                <p class="text-gray-600">
                    Your documents are yours. We never store, access, or share your files. Everything is processed securely and deleted within 24 hours.
                </p>
            </div>

            <!-- User-Centric -->
            <div class="text-center p-6 bg-blue-50 rounded-xl">
                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">User-Centric</h3>
                <p class="text-gray-600">
                    Every feature we build starts with a real user need. We listen to feedback and continuously improve based on what matters to you.
                </p>
            </div>

            <!-- Innovation -->
            <div class="text-center p-6 bg-purple-50 rounded-xl">
                <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Innovation</h3>
                <p class="text-gray-600">
                    We're constantly pushing the boundaries of what's possible with PDF technology, bringing you the latest advances in document processing.
                </p>
            </div>
        </div>
    </section>

    <!-- Features Highlight -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Why Choose PDF Pro?</h2>
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
                            <h4 class="font-semibold text-gray-900 mb-1">Lightning Fast Processing</h4>
                            <p class="text-gray-600">Advanced algorithms ensure your files are processed in seconds, not minutes.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">No Installation Required</h4>
                            <p class="text-gray-600">Work from any device, anywhere. No downloads, no setup hassles.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Enterprise-Grade Security</h4>
                            <p class="text-gray-600">Bank-level encryption and security protocols protect your sensitive documents.</p>
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
                            <h4 class="font-semibold text-gray-900 mb-1">All-in-One Solution</h4>
                            <p class="text-gray-600">Convert, edit, merge, split, compress - everything you need in one place.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">24/7 Expert Support</h4>
                            <p class="text-gray-600">Our dedicated support team is always here to help when you need it.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Constantly Improving</h4>
                            <p class="text-gray-600">Regular updates and new features based on user feedback and industry trends.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="text-center">
        <div class="bg-gradient-to-r from-gray-900 to-gray-700 text-white p-12 rounded-2xl">
            <h2 class="text-3xl font-bold mb-4">Ready to Transform Your PDF Workflow?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Join millions of users who trust PDF Pro for their document needs. Experience the difference today.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('/') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg transition-colors duration-200">
                    Get Started Free
                </a>
                <a href="{{ route('register') }}" class="border-2 border-white text-white hover:bg-white hover:text-gray-900 font-semibold px-8 py-3 rounded-lg transition-colors duration-200">
                    Regsiter
                </a>
            </div>
        </div>
    </section>
</div>

@endsection