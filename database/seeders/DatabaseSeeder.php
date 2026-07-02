<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory(100)->create();
        $this->call([
        SpecializationSeeder::class,
        ]);
        Doctor::factory()->count(30)->create();
        Clinic::factory()->count(50)->create();
        $this->call([
        DoctorSeeder::class,
        ]);
        Appointment::factory()->count(50)->create();
        Review::factory()->count(50)->create();
        DoctorSchedule::factory()->count(100)->create();




        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
