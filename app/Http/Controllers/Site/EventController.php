<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventType;
use App\Services\EventFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EventController extends Controller
{
    public function index(Request $request, EventFilterService $eventFilterService)
    {
        $events = $eventFilterService
            ->apply($request)
            ->paginate(10);

        $categories = Cache::remember('event_categories', 86400, function () {
            return EventCategory::all();
        });

        $types = Cache::remember('event_types', 86400, function () {
            return EventType::all();
        });

        return view('site.events.index', [
            'events' => $events,
            'categories' => $categories,
            'types' => $types,
        ]);
    }


    public function show(string $slug)
    {
        $event =  Cache::remember("event_detail_{$slug}", 3600, function () use ($slug) {
            $event = Event::query()->where('slug', $slug)->firstOr(callback: fn() => abort(404));
            $event->load(['category', 'type', 'tickets', 'registrations']);
            return $event;
        });

        return view('site.events.show', [
            'event' => $event,
        ]);
    }
}
