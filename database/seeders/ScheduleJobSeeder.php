<?php

namespace Database\Seeders;

use App\Models\ScheduleJob;
use Illuminate\Database\Seeder;

class ScheduleJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScheduleJob::factory(20)->create();
    }
}
