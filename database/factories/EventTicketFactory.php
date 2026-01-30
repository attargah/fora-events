<?php

namespace Database\Factories;

use App\Enums\EventTicketStatus;
use App\Models\EventTicket;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventTicket>
 */
class EventTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['General Admission', 'VIP', 'Premium', 'Standard', 'Student'];
        
        return [
            'event_id' => Event::factory(),
            'name' => $this->faker->randomElement($types),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(EventTicketStatus::cases()),
            'price' => $this->faker->randomFloat(2, 29.99, 999.99),
            'quantity' => $this->faker->numberBetween(50, 500),
            'available_quantity' => $this->faker->numberBetween(10, 500),
        ];
    }

    public function vip(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'VIP',
            'price' => $this->faker->randomFloat(2, 200, 500),
            'quantity' => 50,
        ]);
    }

    public function standard(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Standard',
            'price' => $this->faker->randomFloat(2, 50, 150),
        ]);
    }

    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Premium',
            'price' => $this->faker->randomFloat(2, 30, 100),
        ]);
    }
}
