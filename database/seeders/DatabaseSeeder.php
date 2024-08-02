<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Student::factory(10)->create();
        Course::factory(10)->create()->each(function($course){
            $course->students()->sync(Student::all()->random(rand(2,3)));
        });
    }
}
