<?php

namespace App\View\Components;

use Illuminate\View\Component;

/**
 * Event Card Component
 * 
 * Reusable component for displaying event cards
 * Usage: <x-event-card :event="$event" />
 */
class EventCard extends Component
{
    public function __construct(
        public $event,
        public $showPrice = true,
        public $showCategory = true,
    ) {}

    public function render()
    {
        return view('components.event-card');
    }
}
