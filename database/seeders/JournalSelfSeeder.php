<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JournalSelf;
class JournalSelfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         JournalSelf::factory()->count(3)->create();
    }
}
