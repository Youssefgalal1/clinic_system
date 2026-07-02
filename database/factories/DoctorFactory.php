<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>User::inRandomOrder()->first()->id,
            'specialization_id'=>Specialization::inRandomOrder()->first()->id,
            'title' => fake()->randomElement(['Dr.', 'Prof.', 'Consultant']),
            'bio' => fake()->paragraph(10),
            'fees' => fake()->numberBetween(100, 5000),
            'experience_years' => fake()->numberBetween(1, 50),
            'rating' => fake()->randomFloat(2, 1, 9.99),
        ];
    }
}
