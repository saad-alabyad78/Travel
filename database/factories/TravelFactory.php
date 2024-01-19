<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Travel>
 */
class TravelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->streetName() ,
            'description' => $this->faker->paragraph() ,
            'number_of_days' => $this->faker->numberBetween(1 , 365) ,
            'is_public' => $this->faker->boolean()
        ];
    }
}
