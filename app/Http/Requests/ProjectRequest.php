<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PlatformEnum;
use App\Enums\ProjectStatusEnum;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'sometimes|required|string|max:255',
            'url'         => [
                'sometimes',
                'required',
                'url',
                'regex:/^https?:\/\//i', // Только HTTP/HTTPS
            ],
            'platform'    => 'sometimes|required|in:' . implode(',', PlatformEnum::getValues()),
            'status'      => 'sometimes|required|in:' . implode(',', ProjectStatusEnum::getValues()),
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Название проекта обязательно.',
            'name.max'           => 'Название проекта не должно превышать 255 символов.',
            'url.required'       => 'URL проекта обязателен.',
            'url.url'            => 'URL указан неверно.',
            'url.regex'          => 'URL должен начинаться с http:// или https://',
            'platform.in'        => 'Платформа указана неправильно.',
            'status.in'          => 'Статус указан неправильно.',
            'description.string' => 'Описание должно быть текстом.',
        ];
    }
}
