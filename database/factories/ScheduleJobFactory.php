<?php

namespace Database\Factories;

use App\Enums\JobStatusEnum;
use App\Models\ScheduleJob;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleJobFactory extends Factory
{
    protected $model = ScheduleJob::class;

    public function definition(): array
    {
        $status = fake()->randomElement([
            JobStatusEnum::NOT_STARTED,
            JobStatusEnum::IN_PROGRESS,
            JobStatusEnum::DONE,
        ]);

        $userId = $status !== JobStatusEnum::NOT_STARTED ? User::inRandomOrder()->first()->id : null;

        $scheduleDate = $userId ? now() : null;

        return [
            'title' => fake()->word(),
            'description' => fake()->text(),
            'scheduled_date' => $scheduleDate,
            'status' => $status,
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
