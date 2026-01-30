@extends('site.layouts.app')

@section('title', 'Ticket Details - ForaEvents')

@section('content')
    <div class="px-6 lg:px-20 py-12">
        <div class="mx-auto max-w-[1440px]">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <a href="{{ route('tickets.index') }}"
                       class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-primary transition-colors mb-4">
                        <span class="material-symbols-outlined text-sm mr-1">arrow_back</span>
                        Back to My Tickets
                    </a>
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Registration Details</h1>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Event Info -->
                <div class="lg:col-span-1 space-y-6">
                    <div
                        class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Event Information</h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Event Name</p>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $registration->event->title ?? 'Unknown' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Order Date</p>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $registration->created_at->format('F d, Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total
                                    Quantity</p>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $registration->quantity }}
                                    Tickets</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Price</p>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">
                                    ${{ number_format($registration->total_price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendees & QR Codes -->
                <div class="lg:col-span-2 space-y-6">
                    <div
                        class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Attendees</h2>

                        @if($registration->attendees->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($registration->attendees as $attendee)
                                    <div
                                        x-data="{ open: false }"
                                        class="flex flex-col items-center p-6 rounded-lg border border-gray-100 dark:border-slate-800 bg-gray-50 dark:bg-slate-800/50"
                                    >

                                        <div
                                            class="mb-4 bg-white p-2 rounded-lg shadow-sm cursor-pointer hover:scale-105 transition"
                                            @click="open = true"
                                        >
                                            <img
                                                src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($attendee->registration_code) }}"
                                                alt="QR Code for {{ $attendee->name }}"
                                                class="w-32 h-32"
                                            >
                                        </div>

                                        <div class="text-center">
                                            <h3 class="font-bold text-slate-900 dark:text-white">{{ $attendee->name }}</h3>
                                            <p class="text-xs text-slate-500">{{ $attendee->email }}</p>
                                        </div>


                                        <div
                                            x-show="open"
                                            x-transition.opacity
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/70"
                                            @click.self="open = false"
                                            @keydown.escape.window="open = false"
                                        >
                                            <div
                                                x-transition.scale
                                                class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-xl"
                                            >
                                                <img
                                                    src="https://api.qrserver.com/v1/create-qr-code/?size=400x400&data={{ urlencode($attendee->registration_code) }}"
                                                    alt="QR Code Large"
                                                    class="w-120 h-120"
                                                >

                                                <p class="mt-4 text-center text-sm text-slate-500">
                                                    Click outside or press ESC to close
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-sm text-slate-500">No attendees found for this registration.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
