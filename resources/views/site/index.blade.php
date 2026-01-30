@extends('site.layouts.app')

@section('title', 'ForaEvents | Experience the Moment')

@section('content')
<!-- Hero Section -->
<section class="relative h-[600px] w-full overflow-hidden lg:h-[700px]">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: linear-gradient(rgba(16, 22, 34, 0.4), rgba(16, 22, 34, 0.9)), url('https://lh3.googleusercontent.com/aida-public/AB6AXuDkiekO5X5D7Ob1XIlfEPKMZ2JxkL0Z6ECd4FK0RICWjRvRvRJwJT5IK2VJocsAZ16T8n1l2V6dOix7cYJf920sXxLoU_b4m3bRP-kJ7E3X0NpYxngyhAAA3WAMpjr6G5wc2S7TE-8LrBUyL_4wn3mj_IPP7zwY0yWdhnbaWaPBVDbHfipj_Pe-dO8J5T8fQ9zesnrwwIOxAVzUkW-5UXQIBMI2hPXDxOOM9riC8R26Na8UwjlXIQFKzYKwZc9AiPvc22DoSmPTUw');">
    </div>
    <div class="relative flex h-full items-center justify-center px-6">
        <div class="flex w-full max-w-[800px] flex-col items-center gap-8 text-center">
            <div class="space-y-4">
                <h2 class="text-5xl font-black leading-tight tracking-tight text-white md:text-7xl lg:leading-[1.1]">
                    Find Your Next Live Experience
                </h2>
                <p class="mx-auto max-w-xl text-lg text-slate-200 md:text-xl">
                    Discover and book tickets to concerts, sports, theater, and more events happening near you.
                </p>
            </div>
            <!-- Search Bar -->
            <div class="w-full">
                <form action="{{ route('events.index') }}" method="GET" class="flex h-16 w-full items-stretch overflow-hidden rounded-xl bg-white shadow-2xl dark:bg-slate-900 md:h-20">
                    <button type="submit" class="text-slate-400 flex border-none bg-white dark:bg-slate-900 items-center justify-center pl-6 rounded-l-xl">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                    <input name="search" class="form-input flex w-full min-w-0 flex-1 border-none bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-0 focus:outline-0 h-full placeholder:text-slate-400 dark:placeholder:text-slate-500 rounded-r-xl px-4 text-base font-normal" 
                           placeholder="Search for artists, teams or venues"
                           value="{{ request('search') }}"/>
                </form>

            
            </div>
        </div>
    </div>
</section>

<!-- Categories Tabs -->
<div class="mx-auto mt-[-32px] max-w-4xl px-6 relative z-10">
    <div class="flex items-center justify-center gap-2 rounded-2xl bg-white p-2 shadow-xl dark:bg-slate-800 border border-slate-200 dark:border-white/10">
        <a class="flex flex-1 items-center justify-center gap-2 rounded-xl py-4 font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors" href="{{ route('events.index', ['category' => ['concerts']]) }}">
            <span class="material-symbols-outlined text-[20px]">music_note</span> Concerts
        </a>
        <a class="flex flex-1 items-center justify-center gap-2 rounded-xl py-4 font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors" href="{{ route('events.index', ['category' => ['theater']]) }}">
            <span class="material-symbols-outlined text-[20px]">theater_comedy</span> Theater
        </a>
        <a class="flex flex-1 items-center justify-center gap-2 rounded-xl py-4 font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors" href="{{ route('events.index', ['category' => ['sports']]) }}">
            <span class="material-symbols-outlined text-[20px]">sports_soccer</span> Sports
        </a>
    </div>
</div>

<!-- Featured Events Carousel -->
<section class="mt-20" x-data="{ 
    scroll(direction) {
        const carousel = this.$refs.carousel;
        const scrollAmount = 450;
        carousel.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
    }
}">
    <div class="mx-auto max-w-[1440px] px-6 lg:px-20">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-black tracking-tight">Featured Events</h2>
            <div class="flex gap-2">
                <button @click="scroll(-1)" class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-300 dark:border-white/10 hover:bg-white dark:hover:bg-white/10 transition-colors">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <button @click="scroll(1)" class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-300 dark:border-white/10 hover:bg-white dark:hover:bg-white/10 transition-colors">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>
        </div>
        <div x-ref="carousel" class="hide-scrollbar flex gap-6 overflow-x-auto pb-6">
            @forelse($featuredEvents as $event)
            <!-- Event Card -->
            <div class="min-w-[400px] group flex flex-col overflow-hidden rounded-2xl bg-white shadow-md dark:bg-slate-800 transition-transform duration-300 hover:-translate-y-2">
                <div class="h-[240px] w-full overflow-hidden relative">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" 
                         src="{{ $event->getBanner() }}"
                         alt="{{ $event->title }}"/>
                    <div class="absolute top-3 right-3 bg-primary px-3 py-1 rounded-lg text-white text-xs font-bold">
                        {{ $event->category->name ?? 'Event' }}
                    </div>
                </div>
                <div class="flex flex-col p-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-primary transition-colors">
                        {{ $event->title }}
                    </h3>
                    <div class="flex items-center gap-4 text-slate-500 dark:text-slate-400 text-sm mb-4">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-base">location_on</span>
                            {{ $event->city ?? '' }}
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-base">schedule</span>
                            {{ $event->start_date?->format('M d, Y') ?? '' }}
                        </div>
                    </div>
                    <a href="{{ route('events.show', $event->slug) }}" class="text-primary font-semibold hover:gap-2 transition-all inline-flex items-center gap-1">
                        View Details
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-slate-500 dark:text-slate-400">No featured events available.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Trending Near You Grid -->
<section class="mt-20">
    <div class="mx-auto max-w-[1440px] px-6 lg:px-20">
        <div class="flex items-end justify-between mb-8 border-b border-slate-200 dark:border-white/10 pb-4">
            <div class="space-y-1">
                <h2 class="text-3xl font-black tracking-tight">Trending Near You</h2>
                <p class="text-slate-500 dark:text-slate-400">Popular events in your area right now</p>
            </div>
            <a class="text-primary font-bold flex items-center gap-1 hover:gap-2 transition-all" href="{{ route('events.index') }}">
                View All
                <span class="material-symbols-outlined">chevron_right</span>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($trendingEvents as $event)
            <!-- Trending Item -->
            <div class="group flex flex-col gap-4">
                <a href="{{ route('events.show', $event->slug) }}" class="overflow-hidden rounded-xl relative h-48">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                         src="{{ $event->getBanner() }}"
                         alt="{{ $event->title }}"/>
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/70 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                        <span class="text-white text-sm font-bold">{{ $event->category->name ?? 'Event' }}</span>
                    </div>
                </a>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('events.show', $event->slug) }}" class="font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                        {{ Str::limit($event->title, 50) }}
                    </a>
                    <div class="flex items-center gap-1 text-slate-500 dark:text-slate-400 text-xs">
                        <span class="material-symbols-outlined text-sm">location_on</span>
                        {{ Str::limit($event->city ?? '', 40) }}
                    </div>
                    <div class="text-primary font-bold text-sm">
                        From ${{ $event->tickets->min('price') ?? '0' }}
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-slate-500 dark:text-slate-400">No trending events available.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
