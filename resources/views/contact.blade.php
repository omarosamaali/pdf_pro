@extends('layouts.app')

@section('content')
<div class="px-4 py-0 text-center bg-gray-100">
    <div class="max-w-lg mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">{{ __('messages.contact_title') }}</h2>
        <p class="text-gray-600 mb-4">{{ __('messages.contact_instruction') }}</p>

        @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('contact.admin') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700">{{ __('messages.subject_label') }}</label>
                <input type="text" name="subject" id="subject" required class="text-center mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">{{ __('messages.description_label') }}</label>
                <textarea name="description" id="description" rows="5" required class="text-center mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            </div>
            <div>
                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('messages.submit_button') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
