<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = Doctor::all();
        $clinics = Clinic::all();

        $doctors->each(function ($doctor) use ($clinics) {
            $doctor->clinics()->attach(
                $clinics->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
