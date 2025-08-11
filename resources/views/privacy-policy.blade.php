@extends('layouts.app')

@section('content')
    
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="prose prose-lg max-w-none">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Privacy Policy</h1>
            <p class="text-gray-600">Last updated: August 2025</p>
        </div>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-8">
            <p class="text-blue-800">
                At PDF Pro, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you use our PDF processing services.
            </p>
        </div>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Information We Collect</h2>

            <h3 class="text-xl font-medium text-gray-800 mb-3">Personal Information</h3>
            <ul class="list-disc pl-6 mb-4 text-gray-700">
                <li>Email address when you create an account</li>
                <li>Name and contact information for premium services</li>
                <li>Payment information processed through secure payment providers</li>
                <li>Usage data and preferences to improve our services</li>
            </ul>

            <h3 class="text-xl font-medium text-gray-800 mb-3">File Information</h3>
            <ul class="list-disc pl-6 mb-4 text-gray-700">
                <li>PDF files you upload for processing</li>
                <li>Metadata associated with your files</li>
                <li>Processing history and preferences</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">How We Use Your Information</h2>
            <ul class="list-disc pl-6 text-gray-700">
                <li>Process and convert your PDF files according to your requests</li>
                <li>Provide customer support and respond to your inquiries</li>
                <li>Improve our services and develop new features</li>
                <li>Send important updates about our services</li>
                <li>Prevent fraud and ensure platform security</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">File Security & Storage</h2>
            <div class="bg-green-50 border border-green-200 p-6 rounded-lg">
                <h3 class="text-lg font-medium text-green-800 mb-3">Your Files Are Safe</h3>
                <ul class="list-disc pl-6 text-green-700">
                    <li>All files are encrypted during upload and processing</li>
                    <li>Files are automatically deleted from our servers within 24 hours</li>
                    <li>We never access or view the content of your files</li>
                    <li>Secure servers with industry-standard protection</li>
                </ul>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Data Sharing</h2>
            <p class="text-gray-700 mb-4">We do not sell, trade, or share your personal information with third parties, except:</p>
            <ul class="list-disc pl-6 text-gray-700">
                <li>With your explicit consent</li>
                <li>To comply with legal obligations</li>
                <li>To protect our rights and prevent fraud</li>
                <li>With trusted service providers who help operate our platform</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Cookies & Tracking</h2>
            <p class="text-gray-700 mb-4">
                We use cookies to enhance your experience on our website. These include:
            </p>
            <ul class="list-disc pl-6 text-gray-700">
                <li><strong>Essential cookies:</strong> Required for basic website functionality</li>
                <li><strong>Analytics cookies:</strong> Help us understand how you use our site</li>
                <li><strong>Preference cookies:</strong> Remember your settings and preferences</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Your Rights</h2>
            <p class="text-gray-700 mb-4">You have the right to:</p>
            <ul class="list-disc pl-6 text-gray-700">
                <li>Access and review your personal data</li>
                <li>Request corrections to inaccurate information</li>
                <li>Delete your account and associated data</li>
                <li>Export your data in a portable format</li>
                <li>Opt-out of marketing communications</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Updates to This Policy</h2>
            <p class="text-gray-700">
                We may update this Privacy Policy from time to time. We will notify you of any significant changes by email or through our website. Your continued use of our services after any updates constitutes acceptance of the revised policy.
            </p>
        </section>
    </div>
</div>

@endsection