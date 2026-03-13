<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            ClassSeeder::class,
            SubjectSeeder::class,
            TeacherSeeder::class,
            ClassTeacherSeeder::class,
            CourseSeeder::class,
            StudentSeeder::class,
            CourseStudentSeeder::class,
            JournalSeeder::class,
            JournalClassesSeeder::class,
            JournalGoalSeeder::class,
            JournalSelfSeeder::class,
            MessageSeeder::class,
            DetailMessageSeeder::class,
            AdminSeeder::class
        ]);
    }
}
