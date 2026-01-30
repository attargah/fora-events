@extends('site.layouts.app')

@section('title', $event->title . ' - ForaEvents')

@section('content')
    <div class="max-w-[1440px] mx-auto px-4 md:px-10 py-6">

        <!-- Breadcrumbs -->
        <div class="flex flex-wrap items-center gap-2 mb-8">
            <a href="{{ route('home') }}" class="text-slate-500 text-sm hover:text-primary">Home</a>
            <span>/</span>
            <a href="{{ route('events.index') }}" class="text-slate-500 text-sm hover:text-primary">Events</a>
            <span>/</span>
            <span class="text-slate-900 dark:text-white text-sm font-medium">
            {{ $event->title }}
        </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- LEFT -->
            <div class="lg:col-span-2 flex flex-col gap-8">

                <!-- IMAGE SLIDER -->
                <div
                        x-data="{
        images: {{ Js::from($event->getImages()) }},
        active: 0
    }"
                        class="flex flex-col gap-4"
                >
                    <div class="w-full h-96 rounded-2xl overflow-hidden">
                        <img
                                :src="images[active]"
                                class="w-full h-full object-cover transition"
                                alt="{{ $event->title }}"
                        />
                    </div>

                    <template x-if="images.length > 1">
                        <div class="flex gap-2 overflow-x-auto hide-scrollbar">
                            <template x-for="(img, index) in images" :key="index">
                                <div
                                        @click="active = index"
                                        class="w-20 h-20 rounded-lg overflow-hidden cursor-pointer border-2"
                                        :class="active === index ? 'border-primary' : 'border-transparent'"
                                >
                                    <img :src="img" class="w-full h-full object-cover">
                                </div>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- EVENT INFO -->
                <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-slate-200 dark:border-white/10">

                <span class="inline-block px-3 py-1 mb-4 rounded-lg bg-primary/10 text-primary text-sm font-semibold">
                    {{ $event->category->name ?? 'Event' }}
                </span>

                    <h1 class="text-4xl font-black text-slate-900 dark:text-white mb-6">
                        {{ $event->title }}
                    </h1>

                    <div class="flex flex-col gap-4 mb-6 pb-6 border-b border-slate-200 dark:border-white/10">
                        <div class="flex gap-3 text-slate-600 dark:text-slate-300">
                            <span class="material-symbols-outlined">location_on</span>
                            {{ $event->city ?? '' }}
                        </div>

                        <div class="flex gap-3 text-slate-600 dark:text-slate-300">
                            <span class="material-symbols-outlined">schedule</span>
                            {{ $event->start_date?->format('F d, Y H:i') ?? '' }}
                        </div>

                        @if($event->type)
                            <div class="flex gap-3 text-slate-600 dark:text-slate-300">
                                <span class="material-symbols-outlined">category</span>
                                {{ $event->type->name }}
                            </div>
                        @endif
                    </div>

                    <!-- DESCRIPTION + CONTENT -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold mb-3 text-slate-900 dark:text-white">
                            About This Event
                        </h2>

                        <p class="text-slate-600 dark:text-slate-300 mb-6">
                            {{ $event->description }}
                        </p>

                        @if($event->content)
                            <div class="prose dark:prose-invert max-w-none">
                                {!! nl2br(str($event->content)->markdown()) !!}
                            </div>
                        @endif
                    </div>

                    <!-- STATS -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-lg">
                            <p class="text-xs uppercase text-slate-500 font-semibold">Status</p>
                            <p class="text-lg font-bold">
                                {{ $event->status->getLabel() }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- RIGHT -->
            <aside class="lg:col-span-1">
                <div
                        x-data="{
            qty: 1,
            openTicket: null,
            selectedTicket: null,
            selectedPrice: 0,
            total() {
                return this.selectedPrice * this.qty
            }
        }"
                        class="sticky top-24 bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg"
                >

                    <h2 class="text-2xl font-bold mb-6">Select Tickets</h2>

                    @if($event->tickets->isNotEmpty())
                        <div class="space-y-3 mb-6">
                            @foreach($event->tickets as $index => $ticket)
                                <div
                                        class="border border-slate-200 dark:border-white/10 rounded-lg overflow-hidden bg-slate-50 dark:bg-slate-700/40"
                                        :class="selectedTicket === {{ $ticket->id }} ? 'ring-2 ring-white' : ''"
                                >
                                    <!-- HEADER -->
                                    <button
                                            type="button"
                                            @click="
                                openTicket === {{ $index }} ? openTicket = null : openTicket = {{ $index }};
                                selectedTicket = {{ $ticket->id }};
                                selectedPrice = {{ $ticket->price }};
                            "
                                            class="w-full flex justify-between items-center p-4 text-left hover:bg-slate-100 dark:hover:bg-slate-700 transition"
                                    >
                                        <div>
                                            <p class="font-semibold text-slate-900 dark:text-white">
                                                {{ $ticket->name }}
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                {{ $ticket->quantity }} available
                                            </p>
                                        </div>

                                        <div class="flex items-center gap-3">
                                <span class="font-bold text-white">
                                    ${{ number_format($ticket->price, 2) }}
                                </span>
                                            <span
                                                    class="material-symbols-outlined transition-transform"
                                                    :class="openTicket === {{ $index }} ? 'rotate-180' : ''"
                                            >
                                    expand_more
                                </span>
                                        </div>
                                    </button>

                                    <!-- DROPDOWN CONTENT -->
                                    <div
                                            x-show="openTicket === {{ $index }}"
                                            x-collapse
                                            class="px-4 pt-4 pb-4 text-sm text-slate-600 dark:text-slate-300"
                                    >
                                        {{ $ticket->description ?? 'No description available.' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-500 text-center mb-6">
                            No tickets available
                        </p>
                    @endif

                    <!-- QTY -->
                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">Quantity</label>
                        <div class="flex items-center gap-4 border rounded-lg p-2">
                            <button @click="qty = Math.max(1, qty - 1)">−</button>
                            <input
                                    x-model="qty"
                                    type="number"
                                    min="1"
                                    class="w-full text-center bg-transparent border-none
                           [appearance:textfield]
                           [&::-webkit-inner-spin-button]:appearance-none
                           [&::-webkit-outer-spin-button]:appearance-none"
                            >
                            <button @click="qty++" :disabled="!selectedTicket">+</button>
                        </div>
                    </div>

                    <!-- TOTAL PRICE -->
                    <div
                            x-show="selectedTicket"
                            x-transition
                            class="mb-6 flex justify-between items-center text-lg font-semibold"
                    >
                        <span>Total</span>
                        <span class="text-white">
                $<span x-text="total().toFixed(2)"></span>
            </span>
                    </div>

                    <!-- BUY -->
                    <form action="{{ route('checkout.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        <input type="hidden" name="event_ticket_id" :value="selectedTicket">
                        <input type="hidden" name="quantity" :value="qty">
                        
                        <button
                                type="submit"
                                class="w-full bg-primary text-white py-3 rounded-lg font-bold mb-3 disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="!selectedTicket"
                        >
                            Buy Now
                        </button>
                    </form>

                </div>
            </aside>


        </div>
    </div>
@endsection
