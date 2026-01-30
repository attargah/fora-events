<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class EventFilterService
{
    public function apply(Request $request): Builder
    {
        $query = Event::query()->with(['category', 'type', 'tickets']);

        $this->filterCategory($query, $request);
        $this->filterType($query, $request);
        $this->filterDate($query, $request);
        $this->filterPrice($query, $request);
        $this->search($query, $request);
        $this->sort($query, $request);

        return $query;
    }

    protected function filterCategory(Builder $query, Request $request): void
    {
        if ($request->filled('category')) {
            $categories = is_array($request->category) ? $request->category : [$request->category];
            $query->whereHas('category', function ($q) use ($categories) {
                $q->whereIn('slug', $categories);
            });
        }
    }

    protected function filterType(Builder $query, Request $request): void
    {
        if ($request->filled('type')) {
            $types = is_array($request->type) ? $request->type : [$request->type];
            $query->whereHas('type', function ($q) use ($types) {
                $q->whereIn('slug', $types);
            });
        }
    }


    protected function filterDate(Builder $query, Request $request): void
    {
        if ($request->filled('date')) {
            match ($request->date) {
                'today' => $query->whereDate('start_date', now()->today()),
                'week' => $query->whereBetween('start_date', [now()->startOfWeek(), now()->endOfWeek()]),
                'month' => $query->whereMonth('start_date', now()->month)->whereYear('start_date', now()->year),
                'custom' => $this->filterCustomDate($query, $request),
                default => null,
            };
        }
    }

    protected function filterCustomDate(Builder $query, Request $request): void
    {
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('start_date', '<=', $request->end_date);
        }
    }

    protected function filterPrice(Builder $query, Request $request): void
    {
        if ($request->filled('min_price')) {
            $query->whereHas('tickets', function ($q) use ($request) {
                $q->where('price', '>=', $request->min_price);
            });
        }

        if ($request->filled('max_price')) {
            $query->whereHas('tickets', function ($q) use ($request) {
                $q->where('price', '<=', $request->max_price);
            });
        }
    }

    protected function search(Builder $query, Request $request): void
    {
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }
    }

    protected function sort(Builder $query, Request $request): void
    {
        $sort = $request->get('sort', 'latest');

        match ($sort) {
            'oldest' => $query->oldest('start_date'),

            'price_low' => $query
                ->leftJoin('event_tickets', 'events.id', '=', 'event_tickets.event_id')
                ->select('events.*')
                ->groupBy('events.id')
                ->orderByRaw('MIN(event_tickets.price) asc'),

            'price_high' => $query
                ->leftJoin('event_tickets', 'events.id', '=', 'event_tickets.event_id')
                ->select('events.*')
                ->groupBy('events.id')
                ->orderByRaw('MAX(event_tickets.price) desc'),

            'newest' => $query->latest('start_date'),

            default => $query->latest('start_date'),
        };
    }

}
