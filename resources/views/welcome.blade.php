@extends('layouts.app')

@section('content')
<div class="px-4 py-0 text-center bg-gray-100">
    <div class="mx-auto max-w-7xl py-5">
        <h1 class="text-[24px] w-full md:text-[42px] font-bold text-[#33333b] my-2">
            {{ __('messages.every_tool_title') }}
        </h1>
        <p class="max-w-5xl mx-auto text-[16px] md:text-[22px] text-gray-700 mb-4">
            {{ __('messages.every_tool_description') }}
        </p>
        <x-tabs :banners="$banners" />
    </div>
</div>
<div class="mx-auto px-4 py-0 text-center bg-white relative z-[9]">
    <div class="mx-auto max-w-7xl py-5">
        <x-features />
    </div>
</div>
@endsection
