@extends('site.layouts.app')

@section('title', 'Order Failed - ForaEvents')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-16 text-center">
    <div class="mb-8 flex justify-center">
        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center text-red-600">
            <span class="material-symbols-outlined text-4xl">error</span>
        </div>
    </div>
    
    <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Payment Failed</h1>
    <p class="text-lg text-slate-600 dark:text-slate-300 mb-8">
        Unfortunately, we could not process your order. This may be due to a payment issue or system error.
    </p>

    <div class="flex gap-4 justify-center">
        <a href="{{ route('checkout.index', ['hash' => $checkout->hash]) }}" class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-600 transition">
            Try Again
        </a>
        <a href="{{ route('home') }}" class="inline-block bg-slate-200 text-slate-900 px-8 py-3 rounded-lg font-bold hover:bg-slate-300 transition">
            Return to Home
        </a>
    </div>
</div>
@endsection
