<?php

namespace Database\Factories;

use App\Models\ScheduleJob;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ScheduleJobFactory extends Factory
{
    protected $model = ScheduleJob::class;

    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'scheduled_date' => Carbon::now(),
            'status' => $this->faker->word(),
            'user_id' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
