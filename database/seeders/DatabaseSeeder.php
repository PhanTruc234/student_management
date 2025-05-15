<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; ++$i) {
            Student::query()->create([
                'code' => 'PMT' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'name' => fake()->name(),
                'email' => fake()->unique()->userName() . '@gmail.com',
                'gender' => fake()->randomElement(['Male', 'Female']),
                'dob' => fake()->date(),
            ]);
        }
    }
}
