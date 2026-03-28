<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'language' => ['sometimes', 'string', Rule::in(['en', 'ru', 'uz'])],
            'timezone' => ['sometimes', 'timezone'],
            'time_format' => ['sometimes', 'in:12h,24h'],
            'notifications_enabled' => ['sometimes', 'boolean'],
        ];
    }
}
