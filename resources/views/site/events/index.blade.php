@extends('site.layouts.app')

@section('title', 'Events - ForaEvents')

@section('content')
<div class="max-w-[1440px] mx-auto flex flex-col px-4 md:px-10 py-6 gap-6"
     x-data="{
        filters: {
            category: {{ json_encode(collect(request('category', []))->wrap(request('category', []))->toArray()) }},
            type: {{ json_encode(collect(request('type', []))->wrap(request('type', []))->toArray()) }},
            date: '{{ request('date', '') }}',
            start_date: '{{ request('start_date', '') }}',
            end_date: '{{ request('end_date', '') }}',
            min_price: '{{ request('min_price', '') }}',
            max_price: '{{ request('max_price', '') }}',
            sort: '{{ request('sort', 'latest') }}',
            search: '{{ request('search', '') }}'
        },
        showAllCategories: false,
        showAllTypes: false,
        applyFilters() {
            const params = new URLSearchParams();
            
            if (this.filters.category.length) {
                this.filters.category.forEach(slug => params.append('category[]', slug));
            }
            if (this.filters.type.length) {
                this.filters.type.forEach(slug => params.append('type[]', slug));
            }
            if (this.filters.date) params.set('date', this.filters.date);
            if (this.filters.date === 'custom') {
                if (this.filters.start_date) params.set('start_date', this.filters.start_date);
                if (this.filters.end_date) params.set('end_date', this.filters.end_date);
            }
            if (this.filters.min_price) params.set('min_price', this.filters.min_price);
            if (this.filters.max_price) params.set('max_price', this.filters.max_price);
            if (this.filters.sort) params.set('sort', this.filters.sort);
            if (this.filters.search) params.set('search', this.filters.search);

            window.location.href = '{{ route('events.index') }}?' + params.toString();
        },
        toggleCategory(slug) {
            const index = this.filters.category.indexOf(slug);
            if (index > -1) {
                this.filters.category.splice(index, 1);
            } else {
                this.filters.category.push(slug);
            }
        },
        toggleType(slug) {
            const index = this.filters.type.indexOf(slug);
            if (index > -1) {
                this.filters.type.splice(index, 1);
            } else {
                this.filters.type.push(slug);
            }
        }
     }">
    <!-- Breadcrumbs -->
    <div class="flex flex-wrap items-center gap-2">
        <a class="text-slate-500 dark:text-slate-400 text-sm font-medium hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
        <span class="text-slate-500 dark:text-slate-400 text-sm font-medium">/</span>
        <span class="text-slate-900 dark:text-white text-sm font-medium">Events</span>
        @if(request('category'))
        <span class="text-slate-500 dark:text-slate-400 text-sm font-medium ml-2">— 
            @if(is_array(request('category')))
                {{ ucfirst(request('category')[0]) }}{{ count(request('category')) > 1 ? ' + ' . (count(request('category')) - 1) . ' more' : '' }}
            @else
                "{{ ucfirst(request('category')) }}"
            @endif
        </span>
        @endif
    </div>
    
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Navigation (Filters) -->
        <aside class="w-full lg:w-64 flex-shrink-0">
            <div class="lg:sticky lg:top-24 flex flex-col bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-white/10 lg:max-h-[calc(100vh-120px)] overflow-hidden shadow-sm">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 pb-4 border-b border-slate-100 dark:border-white/5">
                    <h3 class="font-bold text-lg">Filters</h3>
                    <a href="{{ route('events.index') }}" class="text-primary text-sm font-semibold hover:underline">Clear</a>
                </div>
                
                <!-- Scrollable Body -->
                <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-6 custom-scrollbar">
                    <!-- Search Bar -->
                    <div class="flex flex-col gap-3">
                        <h4 class="font-semibold text-sm">Search</h4>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors text-lg">search</span>
                            <input type="text" x-model="filters.search" @keyup.enter="applyFilters" 
                                   placeholder="Search events..." 
                                   class="w-full pl-10 pr-3 py-2 rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition-all"/>
                        </div>
                    </div>

                    <!-- Category Checklist -->
                    <div class="flex flex-col gap-3">
                        <h4 class="font-semibold text-sm">Category</h4>
                        <div class="flex flex-col gap-2">
                            @foreach($categories ?? [] as $index => $category)
                            <label class="flex items-center gap-2 cursor-pointer group" 
                                   x-show="showAllCategories || {{ $index }} < 5"
                                   x-transition>
                                <input type="checkbox" class="checkbox-tick" 
                                       :checked="filters.category.includes('{{ $category->slug }}')"
                                       @change="toggleCategory('{{ $category->slug }}')"/>
                                <span class="text-sm group-hover:text-primary transition-colors">{{ $category->name }}</span>
                            </label>
                            @endforeach
                            
                            @if(count($categories ?? []) > 5)
                            <button @click="showAllCategories = !showAllCategories" 
                                    class="text-xs text-primary font-bold text-left hover:underline mt-1">
                                <span x-text="showAllCategories ? 'Show Less' : 'Show All ({{ count($categories) }})'"></span>
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Type Checklist -->
                    <div class="flex flex-col gap-3">
                        <h4 class="font-semibold text-sm">Type</h4>
                        <div class="flex flex-col gap-2">
                            @foreach($types ?? [] as $index => $type)
                            <label class="flex items-center gap-2 cursor-pointer group"
                                   x-show="showAllTypes || {{ $index }} < 5"
                                   x-transition>
                                <input type="checkbox" class="checkbox-tick" 
                                       :checked="filters.type.includes('{{ $type->slug }}')"
                                       @change="toggleType('{{ $type->slug }}')"/>
                                <span class="text-sm group-hover:text-primary transition-colors">{{ $type->name }}</span>
                            </label>
                            @endforeach

                            @if(count($types ?? []) > 5)
                            <button @click="showAllTypes = !showAllTypes" 
                                    class="text-xs text-primary font-bold text-left hover:underline mt-1">
                                <span x-text="showAllTypes ? 'Show Less' : 'Show All ({{ count($types) }})'"></span>
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Date Filter -->
                    <div class="flex flex-col gap-3">
                        <h4 class="font-semibold text-sm">Date</h4>
                        <div class="flex flex-col gap-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="date" value="" x-model="filters.date" class="w-4 h-4 text-primary focus:ring-primary"/>
                                <span class="text-sm">All Dates</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="date" value="today" x-model="filters.date" class="w-4 h-4 text-primary focus:ring-primary"/>
                                <span class="text-sm">Today</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="date" value="week" x-model="filters.date" class="w-4 h-4 text-primary focus:ring-primary"/>
                                <span class="text-sm">This Week</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="date" value="month" x-model="filters.date" class="w-4 h-4 text-primary focus:ring-primary"/>
                                <span class="text-sm">This Month</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="date" value="custom" x-model="filters.date" class="w-4 h-4 text-primary focus:ring-primary"/>
                                <span class="text-sm">Specific Range</span>
                            </label>
                        </div>
                        
                        <!-- Custom Date Inputs -->
                        <div x-show="filters.date === 'custom'" x-transition class="flex flex-col gap-2 mt-2">
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] uppercase text-slate-400 font-bold">Start Date</label>
                                <input type="date" x-model="filters.start_date" class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary"/>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] uppercase text-slate-400 font-bold">End Date</label>
                                <input type="date" x-model="filters.end_date" class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary"/>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Price Range -->
                    <div class="flex flex-col gap-3">
                        <h4 class="font-semibold text-sm">Price</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] uppercase text-slate-400 font-bold">Min</label>
                                <input type="number" x-model="filters.min_price" placeholder="0" class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary"/>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] uppercase text-slate-400 font-bold">Max</label>
                                <input type="number" x-model="filters.max_price" placeholder="1000+" class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary"/>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer / Apply Button -->
                <div class="p-6 border-t border-slate-100 dark:border-white/5 bg-slate-50/50 dark:bg-white/5">
                    <button @click="applyFilters" class="w-full flex items-center justify-center rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold tracking-[0.015em] hover:bg-blue-700 transition-colors shadow-lg shadow-primary/20">
                        Apply Filters
                    </button>
                </div>
            </div>
        </aside>

        
        <!-- Main Results Area -->
        <div class="flex-1 flex flex-col gap-6">
            <!-- Summary & Sort -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-white/10">
                <div class="text-slate-600 dark:text-slate-400 text-sm">
                    Showing <span class="font-bold">{{ $events->total() }}</span> events
                </div>
                <div class="flex items-center gap-3">
                    <label class="text-sm text-slate-600 dark:text-slate-400">Sort by:</label>
                    <select x-model="filters.sort" @change="applyFilters" class="form-select rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="latest">Newest</option>
                        <option value="oldest">Oldest</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                    </select>
                </div>
            </div>
            
            <!-- Event List -->
            <div class="flex flex-col gap-4">
                @forelse($events as $event)
                <a href="{{ route('events.show', $event->slug) }}" class="group flex flex-col md:flex-row bg-white dark:bg-slate-800 rounded-xl overflow-hidden border border-slate-200 dark:border-white/10 hover:border-primary/50 transition-all shadow-sm hover:shadow-xl hover:shadow-primary/5 cursor-pointer">
                    <div class="w-full md:w-64 h-48 relative overflow-hidden">
                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             src="{{ $event->getBanner() }}"
                             alt="{{ $event->title }}"/>
                        @if($event->status->value === 'selling_fast')
                        <div class="absolute top-3 left-3 bg-orange-500 text-white px-3 py-1 rounded-lg text-xs font-bold flex items-center gap-1 shadow-lg">
                            <span class="material-symbols-outlined text-sm">local_fire_department</span> Selling Fast
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-1 group-hover:text-primary transition-colors">
                                {{ $event->title }}
                            </h3>
                            <div class="flex items-center gap-4 text-slate-500 dark:text-slate-400 text-sm">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-base">location_on</span>
                                    {{ $event->city ?? '' }}
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-base">schedule</span>
                                    {{ $event->start_date?->format('M d, Y h:i') ?? '' }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center justify-between border-t border-slate-100 dark:border-white/10 pt-4">
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase">Starting from</p>
                                <p class="text-xl font-bold text-slate-900 dark:text-white">${{ $event->tickets->min('price') ?? '0' }}</p>
                            </div>
                            <button class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors flex items-center gap-2 shadow-lg shadow-primary/20">
                                Buy Tickets
                                <span class="material-symbols-outlined text-sm">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-12 bg-white dark:bg-slate-800 rounded-xl border border-dashed border-slate-300 dark:border-slate-700">
                    <div class="flex flex-col items-center gap-2">
                        <span class="material-symbols-outlined text-4xl text-slate-300">search_off</span>
                        <p class="text-slate-500 dark:text-slate-400">No events found. Try adjusting your filters.</p>
                        <a href="{{ route('events.index') }}" class="text-primary font-bold hover:underline">Clear all filters</a>
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($events->hasPages())
            <nav class="flex items-center justify-center gap-2 py-8">
                @if($events->onFirstPage())
                <button disabled class="flex items-center justify-center size-10 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-slate-300 cursor-not-allowed">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                @else
                <a href="{{ $events->appends(request()->except('page'))->previousPageUrl() }}" class="flex items-center justify-center size-10 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
                @endif
                
                @foreach($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                @if($page == $events->currentPage())
                <button disabled class="flex items-center justify-center size-10 rounded-lg bg-primary text-white font-bold">{{ $page }}</button>
                @elseif($page == 1 || $page == $events->lastPage() || abs($page - $events->currentPage()) < 2)
                <a href="{{ $events->appends(request()->except('page'))->url($page) }}" class="flex items-center justify-center size-10 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">{{ $page }}</a>
                @elseif($page == 2 || $page == $events->lastPage() - 1)
                <span class="text-slate-400 px-2">...</span>
                @endif
                @endforeach
                
                @if($events->hasMorePages())
                <a href="{{ $events->appends(request()->except('page'))->nextPageUrl() }}" class="flex items-center justify-center size-10 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
                @else
                <button disabled class="flex items-center justify-center size-10 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-slate-300 cursor-not-allowed">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
                @endif
            </nav>
            @endif
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #475569;
    }
</style>
@endsection

