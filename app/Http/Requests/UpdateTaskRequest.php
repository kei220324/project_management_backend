<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'due_date' => ['sometimes', 'nullable', 'date'],
            'status' => [
                'sometimes',
                'required',
                Rule::in([
                    'not_started',
                    'in_progress',
                    'in_review',
                    'completed',
                ]),
            ],
        ];
    }
}
