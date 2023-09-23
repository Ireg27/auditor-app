<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleJobRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required'],
            'description' => ['required'],
            'scheduled_date' => ['required', 'date'],
            'status' => ['required'],
            'user_id' => ['nullable'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
