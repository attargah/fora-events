@extends('site.layouts.app')

@section('title', 'Order Complete - ForaEvents')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-16 text-center">
    <div class="mb-8 flex justify-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-green-600">
            <span class="material-symbols-outlined text-4xl">check_circle</span>
        </div>
    </div>
    
    <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Thank you for your order!</h1>
    <p class="text-lg text-slate-600 dark:text-slate-300 mb-8">
        Your order <strong>#{{ $checkout->hash }}</strong> has been placed successfully. We've sent a confirmation email to <strong>{{ $checkout->email_address }}</strong>.
    </p>

    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-white/10 mb-8 text-left">
        <h2 class="font-semibold text-slate-900 dark:text-white mb-4 border-b pb-2 dark:border-white/10">Order Details</h2>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="text-slate-500 dark:text-slate-400">Event</span>
                <span class="font-medium text-slate-900 dark:text-white">{{ $checkout->event->title }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500 dark:text-slate-400">Reference Hash</span>
                <span class="font-medium text-slate-900 dark:text-white font-mono bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded">{{ $checkout->hash }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500 dark:text-slate-400">Total</span>
                <span class="font-bold text-slate-900 dark:text-white">${{ number_format($checkout->total, 2) }}</span>
            </div>
        </div>
    </div>

    <a href="{{ route('home') }}" class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-600 transition">
        Return to Home
    </a>
</div>
@endsection
