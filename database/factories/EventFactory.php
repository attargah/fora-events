<?php

namespace Database\Factories;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->words(3, true);
        $startDate = $this->faker->dateTimeBetween('now', '+6 months');
        $endDate = (clone $startDate)->modify('+' . $this->faker->numberBetween(1, 7) . ' days');
        $salesStartDate = (clone $startDate)->modify('-30 days');
        $salesEndDate = (clone $startDate)->modify('-1 day');

        return [
            'title' => ucfirst($title),
            'slug' => str($title)->slug(),
            'description' => $this->faker->sentence(10),
            'content' => $this->faker->paragraphs(3, true),
            'banner' => 'https://placehold.co/800x400/png?text=Event+Banner',
            'images' => [
                'https://placehold.co/600x400/png?text=Image+1',
                'https://placehold.co/600x400/png?text=Image+2',
                'https://placehold.co/600x400/png?text=Image+3',
            ],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'sales_start_date' => $salesStartDate,
            'sales_end_date' => $salesEndDate,
            'city' => $this->faker->city(),
            'district' => $this->faker->streetName(),
            'minimum_age' => $this->faker->randomElement([0, 13, 16, 18, 21]),
            'is_alcohol_allowed' => $this->faker->boolean(30),
            'is_featured' => $this->faker->boolean(20),
            'event_category_id' => EventCategory::inRandomOrder()->first()->id,
            'event_type_id' => EventType::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(EventStatus::cases()),
        ];
    }


    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }


    public function upcoming(): static
    {
        $startDate = $this->faker->dateTimeBetween('+1 week', '+3 months');
        $endDate = (clone $startDate)->modify('+' . $this->faker->numberBetween(1, 7) . ' days');
        $salesStartDate = (clone $startDate)->modify('-30 days');
        $salesEndDate = (clone $startDate)->modify('-1 day');

        return $this->state(fn (array $attributes) => [
            'status' => EventStatus::Active,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'sales_start_date' => $salesStartDate,
            'sales_end_date' => $salesEndDate,
        ]);
    }




}
