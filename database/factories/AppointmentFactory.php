<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'user_id' => User::inRandomOrder()->first()->id,
           'doctor_id' => Doctor::inRandomOrder()->first()->id,
           'clinic_id' => Clinic::inRandomOrder()->first()->id,
           'appointment_date' => fake()->dateTimeBetween('now', '+1 year'),
           'status' => fake()->randomElement(['pending','confirmed','cancelled','completed']),
        ];
    }
}
