<?php

namespace Database\Factories;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DoctorSchedule>
 */
class DoctorScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day' => fake()->randomElement(['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday']),
            'start_time' => fake()->time('H:i', '12:00'),
            'end_time' => fake()->time('H:i', '20:00'),
            'doctor_id' => Doctor::inRandomOrder()->first()->id,
            'clinic_id' => Clinic::inRandomOrder()->first()->id,
        ];
    }
}
