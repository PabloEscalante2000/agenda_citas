<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Sesion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sesion>
 */
class SesionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => User::factory(),
            "patient_id" => Patient::factory(),
            "start_time" => fake()->dateTimeBetween('-1 week', '+1 week'),
            "end_time" => fn (array $attributes) => Carbon::parse($attributes['start_time'])->addHour(),
            "status" => fake()->randomElement(['scheduled', 'completed', 'canceled']),
        ];
    }
}
