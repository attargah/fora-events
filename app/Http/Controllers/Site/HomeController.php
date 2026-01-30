<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {

        $featuredEvents = Cache::remember('featured_events', 3600, function () {
            $events = Event::where('is_featured', true)
                ->latest('start_date')
                ->take(6)
                ->with(['category', 'tickets'])
                ->get();


            if ($events->isEmpty()) {
                $events = Event::latest('start_date')
                    ->take(6)
                    ->with(['category', 'tickets'])
                    ->get();
            }

            return $events;
        });


        $trendingEvents = Cache::remember('trending_events', 3600, function () {
            return Event::withCount('registrations')
                ->latest('registrations_count')
                ->take(8)
                ->with(['category', 'tickets'])
                ->get();
        });

        return view('site.index', [
            'featuredEvents' => $featuredEvents,
            'trendingEvents' => $trendingEvents,
        ]);
    }
}
