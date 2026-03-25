<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScrapeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url' => ['required', 'url', 'max:2048'],
            'api_key_id' => [
                'required',
                'integer',
                Rule::exists('api_keys', 'id')->where(
                    fn ($query) => $query->where('user_id', $this->user()?->id)
                ),
            ],
        ];
    }
}
