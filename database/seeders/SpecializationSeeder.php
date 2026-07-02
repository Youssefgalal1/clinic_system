<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            'Cardiology',
            'Dermatology', 
            'Neurology',
            'Orthopedics',
            'Pediatrics',
            'Psychiatry',
        ];

        foreach ($specializations as $name) {
            Specialization::create(['name' => $name]);
        }
    }
}
