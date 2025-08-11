@extends('layouts.app')

@section('content')
<div class="px-4 py-0 text-center bg-gray-100">
    <div class="mx-auto max-w-7xl py-5">
        <h1 class="text-[24px] w-full md:text-[42px] font-bold text-[#33333b] my-2">Every tool you need to work with PDFs in one place</h1>
        <p class="max-w-5xl mx-auto text-[16px] md:text-[22px] text-gray-700 mb-4">Every tool you need to use PDFs, at your fingertips. All are 100% FREE and easy to use! Merge, split, compress, convert, rotate, unlock and watermark PDFs with just a few clicks.</p>
        <x-tabs />
    </div>
</div>
<div class="mx-auto px-4 py-0 text-center bg-white relative z-[9]">
    <div class="mx-auto max-w-7xl py-5">
        <x-features />
    </div>
</div>
@endsection
