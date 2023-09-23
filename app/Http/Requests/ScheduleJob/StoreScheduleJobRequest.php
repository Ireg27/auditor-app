<?php

namespace App\Http\Requests\ScheduleJob;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleJobRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }
}
