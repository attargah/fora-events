<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventType;
use App\Models\EventTicket;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = [
            ['name' => 'Concerts', 'slug' => 'concerts', 'description' => 'Live music concerts and performances'],
            ['name' => 'Sports', 'slug' => 'sports', 'description' => 'Sports events and competitions'],
            ['name' => 'Theater', 'slug' => 'theater', 'description' => 'Theater shows and performances'],
            ['name' => 'Festivals', 'slug' => 'festivals', 'description' => 'Music and cultural festivals'],
            ['name' => 'Comedy', 'slug' => 'comedy', 'description' => 'Stand-up comedy shows'],
        ];

        foreach ($categories as $category) {
            EventCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $types = [
            ['name' => 'Indoor', 'slug' => 'indoor', 'description' => 'Indoor venue events'],
            ['name' => 'Outdoor', 'slug' => 'outdoor', 'description' => 'Outdoor venue events'],
            ['name' => 'Virtual', 'slug' => 'virtual', 'description' => 'Online/Virtual events'],
            ['name' => 'Hybrid', 'slug' => 'hybrid', 'description' => 'Both indoor and outdoor'],
            ['name' => 'Arena', 'slug' => 'arena', 'description' => 'Large arena events'],
        ];

        foreach ($types as $type) {
            EventType::firstOrCreate(
                ['slug' => $type['slug']],
                $type
            );
        }


        Event::factory(8)
            ->featured()
            ->upcoming()
            ->create()
            ->each(function ($event) {
                EventTicket::factory(1)->premium()->for($event)->create();
                EventTicket::factory(1)->standard()->for($event)->create();
                EventTicket::factory(1)->vip()->for($event)->create();
            });

        Event::factory(12)
            ->upcoming()
            ->create()
            ->each(function ($event) {
                EventTicket::factory(1)->premium()->for($event)->create();
                EventTicket::factory(1)->standard()->for($event)->create();
                EventTicket::factory(1)->vip()->for($event)->create();
            });


    }
}
