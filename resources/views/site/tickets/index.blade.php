@extends('site.layouts.app')

@section('title', 'My Tickets - ForaEvents')

@section('content')
<div class="px-6 lg:px-20 py-12">
    <div class="mx-auto max-w-[1440px]">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">My Tickets</h1>
        </div>

        <div class="rounded-xl border border-gray-100 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            @if($registrations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600 dark:text-slate-400">
                        <thead class="bg-gray-50 text-xs uppercase text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">Event</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Date</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Quantity</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Total Price</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-800 border-t border-gray-100 dark:border-slate-800">
                            @foreach($registrations as $registration)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                                        {{ $registration->event->title ?? 'Unknown Event' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $registration->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $registration->quantity }}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${{ number_format($registration->total_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-900/30 dark:text-green-400 dark:ring-green-500/20">
                                            Confirmed
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('tickets.show', $registration) }}" class="font-medium text-primary hover:text-blue-500 transition-colors">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-800">
                    {{ $registrations->links() }}
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="rounded-full bg-gray-50 p-4 dark:bg-slate-800">
                        <span class="material-symbols-outlined h-8 w-8 text-gray-400">confirmation_number</span>
                    </div>
                    <h3 class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">No tickets found</h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">You haven't purchased any tickets yet.</p>
                    <div class="mt-6">
                        <a href="{{ route('home') }}" class="inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-all">
                            Browse Events
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
