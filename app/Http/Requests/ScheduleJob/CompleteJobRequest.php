<?php

namespace App\Http\Requests\ScheduleJob;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompleteJobRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'assessment' => ['required', 'string', 'max: 255'],
        ];
    }
}
